<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Topic;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\Favorite;
use App\Models\PostView;
use Illuminate\Support\Facades\Auth;
use App\Traits\SelectsFields;
use DevDojo\LaravelReactions\Models\Reaction;
use Illuminate\Support\Facades\Cookie;


class PostDetailController extends Controller
{
    use SelectsFields;
    /**
     * Display a listing of the resource.
     */

     public function index($slug)
    {
        
        $post = Post::select($this->selectPostDescriptionFields())
        ->join('channels', 'posts.channel_id', '=', 'channels.id')
        ->join('topics', 'posts.topic_id', '=', 'topics.id')
        ->where('posts.slug', $slug)
        ->firstOrFail();
        $userId = auth()->user()->id ?? "0";
        $image = $post->image;
        $bookmark = Favorite::where('user_id', $userId)
                        ->where('post_id', $post->id)
                        ->first();
        $post->is_bookmark = $bookmark ? 1 : 0;

        $getReactCountsData = $post->getReactionsSummary();

        $getReactCounts = $getReactCountsData->sortByDesc(function($reaction) {
            return $reaction->count;
        });
        $getTopReactions = $getReactCounts->take(3);
        $emoji = "";
        $reactionUsers = [];

        foreach ($getReactCounts as $getReractCount) {
            $reaction = Reaction::where('name', $getReractCount->name)->first();
            $getReractCount->uuid = $reaction->uuid;
        
            $reactionUsers[$getReractCount->name] = [];
            
            foreach ($post->reactions as $reactor) {
                $userDetails = $reactor->getResponder();
                $getEmoji = $reactor->uuid;
                $reactionName = $reactor->name;
                $user_id = $userDetails->id;
            
                if ($getReractCount->name === $reactionName) {
                    $reactionUsers[$getReractCount->name][] = $userDetails;
                }
                if ($userId == $user_id) {
                    $emoji = $getEmoji;
                }
            }
        
            $getReractCount->users = $reactionUsers[$getReractCount->name];
        }

        /* Manage Post view count */
        $this->viewCount($post);
    
        $post->publish_date = Carbon::parse($post->publish_date)->diffForHumans();
        $post->channel_logo = url('storage/images/' . $post->channel_logo);
    
        $topics = Topic::select('id', 'name', 'slug')
            ->where('status', 'active')
            ->take(5)
            ->get();
    
        $previousPost = Post::where('id', '<', $post->id)->orderBy('id', 'desc')->first();
        $nextPost = Post::where('id', '>', $post->id)->orderBy('id')->first();
        $relatedPosts = Post::select($this->selectPostDescriptionFields())
        ->join('channels', 'posts.channel_id', '=', 'channels.id')
        ->join('topics', 'posts.topic_id', '=', 'topics.id')
            ->where('topics.name', $post->topic_name)
            ->where('posts.slug', '!=', $slug)
            ->whereNotIn('posts.id', [$previousPost->id ?? null, $nextPost->id ?? null])
            ->orderBy('posts.publish_date', 'desc')
            ->take(4)
            ->get()->map(function($item){
                     $item->image = $item->image ?? url('public/front_end/classic/images/default/post-placeholder.jpg');
                     $item->publish_date_org = $item->publish_date;
                     $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
                     return $item;
            });
        $post_label = Setting::get()->where('name','news_label_place_holder')->first();
        $reactions = Reaction::get();
        $title = "{$post->title} | {$post->topic_name}";
        $post_title = $post->title;
        $description = $post->description;
        $theme = getTheme();
    
        return view("front_end/" . $theme . "/pages/post-detail-page", compact('title','reactions','emoji','getTopReactions', 'post', 'relatedPosts', 'topics', 'previousPost', 'nextPost','post_label','theme','image','post_title','description'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function favorteToggle(Request $request)
{
    if (!Auth::check()) {
        return response()->json([
            'error' => true,
            'message' => 'Unauthorized user.',
        ], 401);
    }

    $validatedData = $request->validate([
        'id' => ['required', 'exists:posts,id'],
    ]);
    
    $postId = $validatedData['id'];
    $userId = auth()->user()->id;

    $post = Post::findOrFail($postId);
    
    $favorite = Favorite::where('user_id', $userId)
                        ->where('post_id', $postId)
                        ->first();
    
    if ($favorite) {
        // Unlike the post
        if ($post->favorite > 0) {
            $favorite->delete();
            $post->decrement('favorite');
            $status = '0';
            $bookmark_count = Favorite::where('post_id', $postId)->count();
            $message = 'Bookmark Removed';
    }
    } else {
        Favorite::create([
            'user_id' => $userId,
            'post_id' => $postId,
        ]);
        $post->increment('favorite');
        $status = '1';
        $bookmark_count = Favorite::where('post_id', $postId)->count();
        $message = 'Bookmark added';
    }
        return response()->json([
            'error' => false,
            'status' => $status,
            'postId' => $postId,
            'count' => $bookmark_count,
            'message' => $message,
        ], 201);
    
}

    public function viewCount($post){
        
        $user_id = Auth::user()->id ?? null;
        $cookieName = 'viewed_post_' . $post->id;

        $viewexist = PostView::where('post_id',$post->id)
                        ->where('user_id',$user_id)
                        ->first();
        
        if(!$viewexist){
            if (!Cookie::has($cookieName)) {
                if($user_id !== null){
                    PostView::create([
                        'post_id' => $post->id,
                        'user_id' => $user_id,
                    ]);
                }
                Cookie::queue($cookieName, true, 21600);
                $post->increment('view_count');
                return $post;
            }else{
                if($user_id !== null){
                    PostView::create([
                        'post_id' => $post->id,
                        'user_id' => $user_id,
                    ]);
                }
                return$post;
            }
        }else{
            return $post;
        }


    }

}
