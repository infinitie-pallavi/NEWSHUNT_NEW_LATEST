<?php

namespace App\Http\Controllers;

use App\Events\SendNotification;
use App\Models\ChannelSubscriber;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Story;
use App\Models\Topic;
use App\Models\UserFcm;
use App\Traits\SelectsFields;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

const IMAGE_PATH ='public/front_end/classic/images/default/post-placeholder.jpg';
const CHANNELS_TABEL = 'channel:id,name,logo,slug';
const TOPICS_TABEL = 'topic:id,name,slug';

// Why RAW Query?
class HomeController extends Controller
{
    use SelectsFields;

    const TIME_FORMATE = 'Y-m-d H:i';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Home';
        $frontTopics = Topic::select('id', 'name', 'slug')->where('status','active')->whereHas('posts')->take(13)->get();
        foreach ($frontTopics as $topic) {
            $topic->posts = Post::select('posts.id', 'posts.image', 'posts.title','posts.type','posts.video_thumb', 'posts.slug', 'comment', 'publish_date','channels.name','channels.logo','channels.slug as channel_slug')
            ->join('channels', 'posts.channel_id', '=', 'channels.id')
            ->where('topic_id', $topic->id)
            ->where('type','post')
            ->orderBy('publish_date', 'DESC')
            ->take(4)
            ->get()
            ->map(function ($item) {
                $item->image = $item->image ?? url(IMAGE_PATH);
                $item->publish_date_news = Carbon::parse($item->publish_date)->format(self::TIME_FORMATE);
                $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
                return $item;
            });
        }
        
        $top_posts = Post::with([CHANNELS_TABEL])
        ->where('posts.image','!=' ,'')
        ->where('posts.publish_date', '>=', Carbon::now()->subDays(7))
        ->inRandomOrder()
        ->take(8)
        ->get();
        
        // Fetch post banners with channel and topic details
        $postBanners = $this->getPostsWithBanners(5);
        
        // Fetch hot news
        $mostReads = Post::with(['channel:id,name,slug'])
        ->select('id', 'title', 'slug', 'channel_id', 'image', 'publish_date', 'view_count', 'comment')
        ->whereHas('channel', function ($query) {
            $query->where('status', 'active');
        })
        ->where('image', '!=', '')
        ->orderBy('view_count', 'desc')
        ->orderBy('publish_date', 'desc')
            ->take(10)
            ->get()
            ->map(function ($post) {
            $post->image = $post->image ?? url(IMAGE_PATH);
            $post->publish_date_news = Carbon::parse($post->publish_date)->format(self::TIME_FORMATE);
            $post->publish_date = $this->formatPubdate($post->publish_date);
            return $post;
            });
            $channel_ids = ChannelSubscriber::where('user_id', Auth::user()->id ?? 0)->pluck('channel_id')->toArray();
            if(!empty($channel_ids)){
                $channelFollowed = Post::with(['channel:id,name,slug'])
                ->select('id', 'title', 'slug', 'channel_id','type','video_thumb', 'image', 'publish_date', 'view_count', 'comment')
                ->whereHas('channel', function ($query) {
                $query->where('status', 'active');
                    })
                    ->whereIn('posts.channel_id', $channel_ids)
                    ->where('image', '!=', '')
                        ->orderBy('view_count', 'desc')
                        ->orderBy('publish_date', 'desc')
                            ->take(10)
                            ->get()
                            ->map(function ($post) {
                                $post->image = $post->image ?? url(IMAGE_PATH);
                                $post->publish_date_news = Carbon::parse($post->publish_date)->format(self::TIME_FORMATE);
                                $post->publish_date = $this->formatPubdate($post->publish_date);
                                return $post;
                            });
                            
            }else{
            $channelFollowed = [];
            }
        // Fetch latest news
        $latesNews = Post::with([CHANNELS_TABEL, TOPICS_TABEL])
            ->where('type','!=','video')
            ->orderBy('publish_date', 'Desc')
            ->take(12)
            ->get();
        
        $popularPosts = Post::select('id', 'slug', 'publish_date', 'view_count', 'title', 'favorite')
            ->orderBy('publish_date', 'desc')
            ->orderBy('view_count', 'desc')
        ->take(4)
        ->get()
        ->map(function ($item) {
            $item->pubdate_news = Carbon::parse($item->publish_date)->format(self::TIME_FORMATE);
            $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
            return $item;
        });

        $weather_api_key = Setting::select('value')->where('name', 'weather_api_key')->first();

        $videoPosts = $this->getPostsWithVideos(4);
            $location = 'bhuj';
            $latitude = '23d2469d67';
            $longitude = '69d67';
            
        $stories = Story::with(['story_slides','topic'])
        ->orderBy('created_at','ASC')
        ->get();

        $theme = getTheme();
        $data = compact('title','top_posts', 'postBanners','frontTopics','latesNews','videoPosts', 'mostReads','popularPosts','theme','location','latitude','longitude','weather_api_key','stories','channelFollowed');
        return view('front_end/' . $theme . '/pages/index', $data);
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

    // Helper method to get posts with banners
    private function getPostsWithBanners($limit)
    {
       return Post::with([CHANNELS_TABEL, TOPICS_TABEL])
       ->where('image','!=','')
            ->where('posts.type', '!=', 'video')
            ->orderBy('posts.publish_date','DESC')
            ->groupBy('channel_id')
            ->orderBy('publish_date','desc')
            ->take($limit)
            ->get()
            ->map(function ($post) {
                $post->publish_date = Carbon::parse($post->publish_date)->diffForHumans();
                return $post;
            });

    }

    private function getPostsWithVideos($limit)
    {
       return Post::select('topics.name','topics.slug as topic_slug','posts.title','posts.slug','posts.video_thumb','posts.video','posts.description','posts.status','posts.publish_date','posts.view_count','posts.reaction','posts.shere','posts.comment')
       ->where('type','video')
       ->join('channels', 'posts.channel_id', '=', 'channels.id')
       ->join('topics', 'posts.topic_id', '=', 'topics.id')
            ->orderBy('posts.publish_date','DESC')
            ->orderBy('publish_date','desc')
            ->take($limit)
            ->get()
            ->map(function ($post) {
                $post->publish_date = Carbon::parse($post->publish_date)->diffForHumans();
                return $post;
            });

            
    }

    // Helper method to format publish_date
    private function formatPubdate($publish_date)
    {
        return $publish_date ? Carbon::parse($publish_date)->diffForHumans() : null;
    }

}
