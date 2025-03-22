<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Favorite;
use App\Models\Reactable;
use App\Models\Topic;
use App\Services\ResponseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Throwable;
use Illuminate\Support\Facades\Validator;

const STOREGE = 'storage/';
class PostController extends Controller
{

    private $post_image_path = "";
    private $thumbnail_image_path = "";
    private $video_path = "";

    public function __construct()
    {
        $this->post_image_path = "posts/post_images/";
        $this->thumbnail_image_path = "posts/thumbnail_images/";
        $this->video_path = "posts/videos/";
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ResponseService::noAnyPermissionThenRedirect(['list-post', 'create-post', 'update-post', 'delete-post']);
        $title = __('NEWS_POSTS');
        $channel_filters = Channel::select('id','name')->where('status', 'active')->get();
        $topics = Topic::select('id','name')->where('status', 'active')->get();
        return view('admin.post.index', compact('title', 'channel_filters', 'topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = __('CREATE_POSTS');
        $url = url('admin/posts');
        $method = "POST";
        $formID = "addPostForm";
        $channel_filters = Channel::select('id','name')->where('status', 'active')->get();
        $news_topics = Topic::select('id','name')->where('status', 'active')->get();
        return view('admin.post.create', compact('title','channel_filters','news_topics','url','method','formID'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        ResponseService::noPermissionThenRedirect('create-post');
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'channel_id' => 'required|exists:channels,id',
            'topic_id' => 'required|exists:topics,id',
        ];

        $messages = [
            'title.required' => __('Title is required'),
            'description.required' => __('Please select a channel'),
            'topic_id.required' => __('Please select a topic'),
        ];

        if ($request->type == 'post') {
            $rules['image'] = 'required|max:10240|mimes:jpg,jpeg,png,webp,svg';
            $messages['image.required'] = __('Image is required for a post');
        } elseif ($request->type == 'video') {
            $rules['thumb_image'] = 'required|max:10240|mimes:jpg,jpeg,png,webp,svg';
            $rules['video'] = 'required|mimes:mp4,mov,ogg,qt|max:10240';
            $messages['thumb_image.required'] = __('Thumbnail image is required for a video');
            $messages['video.required'] = __('Video file is required');
        }

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $s3_bucket_name = Setting::where('name', 's3_bucket_name')->first();
        $s3_bucket_url = Setting::where('name', 's3_bucket_url')->first();
        $s3_image = $image = null;
        $s3_thumb_img = $thumbImage = null;
        $s3_thumb_video = $video = null;

        if (isset($s3_bucket_name->value) && $s3_bucket_name->value !== "" && isset($s3_bucket_url)) {
            /* Upload post image in S3 bucket */
            $postImage = $request->file('image');
            if ($postImage) {
                $posts_img = getFileName($postImage);
                if ($posts_img) {
                    uploadFileS3Bucket($postImage, $posts_img, $this->post_image_path);
                    $s3_image = $s3_bucket_url->value . $this->thumbnail_image_path . $posts_img;
                }
            }

            /* Upload thumb image in S3 bucket */
            $thumbImage = $request->file('thumb_image');
            if ($thumbImage) {
                $s3_thumb_img = getFileName($thumbImage);
                if ($s3_thumb_img) {
                    uploadFileS3Bucket($thumbImage, $s3_thumb_img, $this->thumbnail_image_path);
                    $thumbImage = $s3_bucket_url->value . $this->thumbnail_image_path . $s3_thumb_img;
                }
            }

            /* Upload video file in S3 bucket */
            $videoFile = $request->file('video');
            if ($videoFile) {
                $s3_thumb_video = getFileName($videoFile);
                if ($s3_thumb_video) {
                    uploadFileS3Bucket($videoFile, $s3_thumb_video, $this->video_path);
                    $s3_thumb_video = $s3_bucket_url->value . $this->thumbnail_image_path . $s3_thumb_video;
                }
            }
        } else {
            /* Store the Post Image locally */
            $imageFile = $request->file('image');
            if ($imageFile) {
                $imageFileName = rand('0000', '9999') . $imageFile->getClientOriginalName();
                $imageFilePath = $imageFile->storeAs('posts_image', $imageFileName, 'public');
                $image = url(Storage::url($imageFilePath));
            }

            /* Store the Thumb Image locally */
            $thumbImageFile = $request->file('thumb_image');
            if ($thumbImageFile) {
                $thumbFileName = rand('0000', '9999') . $thumbImageFile->getClientOriginalName();
                $path = $thumbImageFile->storeAs('thumb_image', $thumbFileName, 'public');
                $thumbImage = url(Storage::url($path));
            }

            /* Store the Video File locally */
            $videoFileLocal = $request->file('video');
            if ($videoFileLocal) {
                $videoFileName = rand('0000', '9999') . $videoFileLocal->getClientOriginalName();
                $videoPath = $videoFileLocal->storeAs('posts_videos', $videoFileName, 'public');
                $video = url(Storage::url($videoPath));
            }
        }

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $pubDate = Carbon::now()->toDateTimeString();
        $publishDate = Carbon::parse($pubDate);

        $post->title = $request->title;
        $post->slug = $slug;
        $post->type = $request->post_type;
        $post->description = $request->description;
        $post->channel_id = $request->channel_id;
        $post->topic_id = $request->topic_id;
        $post->status = $request->status;
        $post->image = $s3_image ?? $image;
        $post->video_thumb = $s3_thumb_img ?? $thumbImage;
        $post->video = $s3_thumb_video ?? $video;
        $post->pubdate = $pubDate;
        $post->publish_date = $publishDate;
        $save = $post->save();

        if($save){
            return response()->json(['success' => true, 'message' => 'Post created successfully.']);
        }else{
            return redirect()->back()->with('error', 'Somthing went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        ResponseService::noPermissionThenRedirect('list-post');
        

        $filter = $request->input('filter') ?? '';
        $channel = $request->input('channel') ?? '';
        $topic = $request->input('topic') ?? '';
        try {

            $query = Post::select('posts.id','posts.channel_id','posts.topic_id','posts.slug','posts.type','posts.video_thumb','posts.video', 'posts.image', 'posts.resource','posts.view_count','posts.comment',
                'channels.name as channel_name', 'channels.logo as channel_logo',
                'topics.name as topic_name', 'posts.title', 'posts.favorite',
                'posts.description', 'posts.status', 'posts.publish_date')
                ->withCount('reactions')
                ->join('channels', 'posts.channel_id', 'channels.id')
                ->join('topics', 'posts.topic_id', 'topics.id');

            /****** Filter for Most View,Likes & Recent News *********/
            if ($filter === 'viewd') {
                $query->orderBy('posts.view_count', 'DESC');
            }elseif($filter === 'liked'){
                $query->orderBy('posts.favorite', 'DESC');
            }elseif($filter === 'recent'){
                $query->orderBy('publish_date', 'desc');
            }elseif($filter === 'video_posts'){
                $query->where('type', 'video');
            }else{
                $query->orderBy('id', 'desc');
            }
            /****** Filter of Channels *********/
            if ($channel !== '' && $channel !== '*') {
                $query->where('channels.id', $channel);
            }
            /****** Filter of Topics *********/
            if ($topic !== '' && $topic !== '*') {
                $query->where('topics.id', $topic);
            }
            /****** Filter of Search News *********/
            if ($request->has('search') && $request->search) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('posts.title', 'like', '%' . $search . '%')
                        ->orWhere('channels.name', 'like', '%' . $search . '%')
                        ->orWhere('topics.name', 'like', '%' . $search . '%');
                });
            }

            $getPosts = $query->paginate(12);

            // Format the publish_date field for each post
            $getPosts->getCollection()->transform(function ($post) {
                $post->publish_date = Carbon::parse($post->publish_date)->diffForHumans();
                return $post;
            });

            return response()->json([
                'data' => $getPosts->items(),
                'total' => $getPosts->total(),
                'last_page' => $getPosts->lastPage(),
                'current_page' => $getPosts->currentPage(),
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching posts'], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = __('EDIT_POST');
        $url = route('posts.store').'/'.$id;
        $method = "PUT";
        $formID = "editPostForm";
        $post = Post::find($id);
        $channel_filters = Channel::select('id','name')->where('status', 'active')->get();
        $news_topics = Topic::select('id','name')->where('status', 'active')->get();

        $data = compact('title','channel_filters','news_topics','post','url','method','formID');
        return view('admin.post.create', $data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        ResponseService::noPermissionThenRedirect('update-post');

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'channel_id' => 'required|exists:channels,id',
            'topic_id' => 'required|exists:topics,id',
        ], [
            'title.required' => __('Title is required'),
            'description.required' => __('Description field is required.'),
            'channel_id.required' => __('Please select a channel'),
            'topic_id.required' => __('Please select a topic'),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            $post = Post::find($id);

            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;
            while (Post::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $post = Post::findOrFail($id);
            $image = $post->image ?? "";
            if($request->type == 'post'){
                if ($request->hasFile('image')) {
                    $image = $this->storePostImage($request->file('image'),$post);
                }
            }else{
                if($request->hasFile('thumb_image')){
                    $video_thumb = $this->storeThumbImage($request->file('thumb_image'),$post);
                }else{
                    $video_thumb = $post->video_thumb;
                }
                if($request->hasFile('video')){
                    $video = $this->storeVideo($request->file('video'),$post);
                }else{
                    $video = $post->video;
                }
            }

            $pubDate = Carbon::now()->toDateTimeString();

            $post->title = $request->title;
            $post->slug = $slug;
            $post->type = $request->post_type;
            $post->description = $request->description;
            $post->channel_id = $request->channel_id ?? $post->channel_id ;
            $post->topic_id = $request->topic_id ?? $post->topic_id;
            $post->status = $request->status;
            $post->image = $image;
            $post->video_thumb = $video_thumb ?? "";
            $post->video = $video ?? "";
            $post->pubdate = $pubDate;
            $post->publish_date = Carbon::parse($pubDate);

            $post->save();

            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully.'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            ResponseService::noPermissionThenSendJson('delete-post');
            Favorite::where('post_id',$id)->delete();
            $post = Post::find($id);
            if($post->type== 'video'){

                $baseUrl = URL::to('storage/');

                $filePath = str_replace($baseUrl, '', $post->video_thumb);
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }

                $videoFilePath = str_replace($baseUrl, '', $post->video);
                if (Storage::disk('public')->exists(ltrim($videoFilePath, '/'))) {
                    Storage::disk('public')->delete(ltrim($videoFilePath, '/'));
                }
            }else{
                $baseUrl = URL::to('storage/');

                $filePath = str_replace($baseUrl, '', $post->image);
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
            $post->delete();
            ResponseService::successResponse("Post deleted Successfully");
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "PlaceController -> destroyCountry");
            ResponseService::errorResponse('Something Went Wrong');
        }
    }

    public function storePostImage($image, $post)
    {
        $s3_bucket_name = Setting::where('name', 's3_bucket_name')->first();
        $s3_bucket_url = Setting::where('name', 's3_bucket_url')->first();

        if (isset($s3_bucket_url, $s3_bucket_name) && $s3_bucket_url->value && $s3_bucket_name->value) {
            $posts_img_name = getFileName($image);
            if ($posts_img_name) {
                uploadFileS3Bucket($image, $posts_img_name, $this->post_image_path, $post->image);
                $s3_image = $s3_bucket_url->value . $this->post_image_path . $posts_img_name;
            }
        } else {
            if ($image) {
                $baseUrl = URL::to('storage/');

                $filePath = str_replace($baseUrl, '', $post->image);
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            if ($image) {
                $fileName = rand('0000', '9999') . $image->getClientOriginalName();
                $imageFilePath = $image->storeAs('posts_image', $fileName, 'public');
                $imageUrl = url(Storage::url($imageFilePath));
            }
        }

        return $s3_image ?? $imageUrl;
    }

    public function storeThumbImage($thumbImage, $post)
    {
        $s3_bucket_name = Setting::where('name', 's3_bucket_name')->first();
        $s3_bucket_url = Setting::where('name', 's3_bucket_url')->first();

        if (isset($s3_bucket_url, $s3_bucket_name) && $s3_bucket_url->value && $s3_bucket_name->value) {
            $posts_thumb_name = getFileName($thumbImage);
            if ($posts_thumb_name) {
                uploadFileS3Bucket($thumbImage, $posts_thumb_name, $this->thumbnail_image_path, $post->image);
                $s3_image = $s3_bucket_url->value . $this->thumbnail_image_path . $posts_thumb_name;
            }
        } else {
            if ($thumbImage) {
                $baseUrl = URL::to('storage/');

                $filePath = str_replace($baseUrl, '', $post->video_thumb);
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            if ($thumbImage) {
                $fileName = rand('0000', '9999') . $thumbImage->getClientOriginalName();
                $imageFilePath = $thumbImage->storeAs('thumb_image', $fileName, 'public');
                $imageUrl = url(Storage::url($imageFilePath));
            }
        }

        return $s3_image ?? $imageUrl;
    }

    public function storeVideo($video, $post)
    {
        $s3_bucket_name = Setting::where('name', 's3_bucket_name')->first();
        $s3_bucket_url = Setting::where('name', 's3_bucket_url')->first();

        if (isset($s3_bucket_url, $s3_bucket_name) && $s3_bucket_url->value && $s3_bucket_name->value) {
            $video_name = getFileName($video);
            if ($video_name) {
                uploadFileS3Bucket($video, $video_name, $this->video_path, $post->image);
                $s3_image = $s3_bucket_url->value . $this->video_path . $video_name;
            }
        } else {
            if ($video) {
                $baseUrl = URL::to('storage/');

                $videoFilePath = str_replace($baseUrl, '', $post->video);
                if (Storage::disk('public')->exists($videoFilePath)) {
                    Storage::disk('public')->delete($videoFilePath);
                }
            }
            if ($video) {
                $fileName = rand('0000', '9999') . $video->getClientOriginalName();
                $imageFilePath = $video->storeAs('posts_videos', $fileName, 'public');
                $imageUrl = url(Storage::url($imageFilePath));
            }
        }

        return $s3_image ?? $imageUrl;
    }
}
