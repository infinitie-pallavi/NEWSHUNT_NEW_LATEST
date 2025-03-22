<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use App\Models\Channel;
use Carbon\Carbon;
use App\Models\Topic;
use App\Models\Post;

class ChannelController extends Controller
{

    const ERROR_MESSAGE ='Failed to manage subscription. Please try again later.';
    const STORAGE_PATH ='storage/images/';
/**** Fetch chennels *******/
protected function index()
{
    $user = auth()->user();
    $followedChannelIds = $user ? $user->subscriptions()->pluck('channel_id')->toArray() : [];

    $page = request()->get('page', 1);
    $perPage = request()->get('per_page', 10);
    $offset = ($page - 1) * $perPage;
    
    $channels = Channel::select('id', 'name', 'logo', 'slug')
        ->where('status', 'active')
        ->get()
        ->map(function ($item) use ($followedChannelIds) {
            $item->logo = asset(self::STORAGE_PATH. $item->logo);
            $item->isFollow = in_array($item->id, $followedChannelIds) ? 1 : 0;
            return $item;
        })
        ->values()->slice($offset, $perPage)
        ->toArray();
        $channels =array_values($channels);

        
    return response()->json([
        'error' => false,
        'message' => 'Channels fetched successfully.',
        'data' => [
            'isChannelFollow'=>$followedChannelIds? true: false,
            'channels'=>$channels
            ]
    ]);
}


/***** Channel Subscribe *****/
  public function subscribeChannel(Request $request, $slug)
{
    if (!Auth::check()) {
        return response()->json([
            'error' => true,
            'message' => 'Unauthenticated. Please log in to subscribe to channels.',
        ], 401);
    }
    
    $user = Auth::user();
    $channel = Channel::where('slug',$slug)->first();
    $isSubscribed = $channel->subscribers()->where('user_id', $user->id)->exists();
    
    try {
        if ($isSubscribed) {
            $channel->subscribers()->detach($user->id);
            $channel->decrement('follow_count');
            $status= '0';
            $message = 'User unsubscribed from channel successfully.';
        } else {
            $channel->subscribers()->attach($user->id);
            $channel->increment('follow_count');
            $status= '1';
            $message = 'User subscribed to channel successfully.';
        }
        return response()->json([
            'error' => false,
            'status' => $status,
            'channel_slug' => $channel->slug,
            'message' => $message
            ]);
    
    } catch (\Exception $e) {
        return response()->json([
            'error' => true,
            'status' => $status,
            'channel_slug' => $channel->slug,
            'message' => self::ERROR_MESSAGE,
        ], 500);
    }
}


/***** Channel Subscribe *****/
  public function subscribeChannelNew(Request $request, $slug)
{
    if (!Auth::check()) {
        return response()->json([
            'error' => true,
            'message' => 'Unauthenticated. Please log in to subscribe to channels.',
        ], 401);
    }
    
    $user = Auth::user();
    $channel = Channel::where('slug',$slug)->first();
    
    $isSubscribed = $channel->subscribers()->where('user_id', $user->id)->exists();
    try {
        if ($isSubscribed) {
            $status= '1';
            $message = 'Already Subscribed.';
        } else {
            $channel->subscribers()->attach($user->id);
            $channel->increment('follow_count');
            $status= '1';
            $message = 'User subscribed to channel successfully.';
        }
        return response()->json([
            'error' => false,
            'status' => $status,
            'channel_slug' => $channel->slug,
            'message' => $message
            ]);
    
    } catch (\Exception $e) {
        return response()->json([
            'error' => true,
            'status' => $status,
            'channel_slug' => $channel->slug,
            'message' => self::ERROR_MESSAGE,
        ], 500);
    }
}

/***** Channel Unsubscribe *****/
public function unSubscribeChannel(Request $request, $slug)
{
    if (!Auth::check()) {
        return response()->json([
            'error' => true,
            'message' => 'Unauthenticated. Please log in to unsubscribe to channels.',
        ], 401);
    }
    
    $user = Auth::user();
    $channel = Channel::where('slug',$slug)->first();
    $isSubscribed = $channel->subscribers()->where('user_id', $user->id)->exists();
    
    try {
        if ($isSubscribed) {
            $channel->subscribers()->detach($user->id);
            $channel->decrement('follow_count');
            $status= '0';
            $message = 'User unsubscribed from channel successfully.';
        } else {
            $status= '0';
            $message = 'Already Unsubscribed.';
        }
        return response()->json([
            'error' => false,
            'status' => $status,
            'channel_slug' => $channel->slug,
            'message' => $message
            ]);
    
    } catch (\Exception $e) {
        return response()->json([
            'error' => true,
            'status' => $status,
            'channel_slug' => $channel->slug,
            'message' => self::ERROR_MESSAGE,
        ], 500);
    }
}

    public function getProfileData($slug)
    {
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        
        $data = Channel::select('channels.id', 'name', 'logo', 'description', 'slug', 'follow_count')
    ->where('slug', $slug)
    ->selectRaw('IF(channel_subscribers.user_id IS NOT NULL, 1, 0) as is_followed')
    ->selectRaw('(SELECT COUNT(*) FROM posts WHERE posts.channel_id = channels.id) as total_post')
    ->leftJoin('channel_subscribers', function($join) use ($userId) {
        $join->on('channels.id', '=', 'channel_subscribers.channel_id')
             ->where('channel_subscribers.user_id', '=', $userId);
    })
    ->get()
    ->map(function ($item){
        
        $item->logo = url(self::STORAGE_PATH. $item->logo);
        $topicIds = Post::where('channel_id', $item->id)
                        ->distinct()
                        ->pluck('topic_id')
                        ->toArray();

                        
        $topics = Topic::whereIn('id', $topicIds)->get(['id', 'name', 'slug']);
        $item->topics_list = $topics;
        $firstPost = Post::where('channel_id', $item->id)
                         ->orderBy('created_at', 'desc')
                         ->first();
                         
        $item->post_image = $firstPost && $firstPost->image ? $firstPost->image : null;
        
        return $item;
    })
    ->first();

            
        return response()->json([
            'error' => false,
            'message' => 'Topics fetched successfully.',
            'data' => $data
        ]);
    }


    public function getProfilePosts($slug)
    {
        $user = Auth::user();
        $userId = $user ? $user->id : null;

        try {
                $short = request()->get('short');
                $category = request()->get('category');
                
                $page = (int) request()->get('page', 1);
                $perPage = (int) request()->get('per_page', 10);
                $offset = ($page - 1) * $perPage;
                
                if($slug !== ''){
                    $channel = Channel::select('id')->where('slug',$slug)->first();
                }

                if($category !== 'all'){
                    $topic = Topic::select('id')->where('slug',$category)->first();
                }
                $postQuery = Post::select('posts.id','posts.title','posts.slug','posts.type','posts.video_thumb','posts.video','posts.image','posts.publish_date','posts.shere','posts.view_count','posts.favorite','posts.comment','topics.name as topic_name','topics.slug as topic_slug','channels.name as channel_name','channels.slug as channel_slug','channels.logo as channel_logo')
                        ->selectRaw('IF(favorites.user_id IS NOT NULL, 1, 0) as is_favorite')
                        ->join('channels', 'posts.channel_id', '=', 'channels.id')
                        ->join('topics', 'posts.topic_id', '=', 'topics.id')
                        ->leftJoin('favorites', function($join) use ($userId) {
                            $join->on('posts.id', '=', 'favorites.post_id')
                            ->where('favorites.user_id', '=', $userId);
                        })
                        
                        ->where('posts.channel_id', $channel->id);
                        
                        if(!empty($topic->id)){
                            $postQuery->where('posts.topic_id', $topic->id);
                        }
                        
                        $postQuery->where('posts.image','!=','');
                        if($short == 'most_read' && $short !== 'all'){
                            $postQuery->orderBy('posts.view_count', 'desc');
                        }
                        if($short == 'most_favorit' && $short !== 'all'){
                            $postQuery->orderBy('posts.favorite', 'desc');
                        }
                        
                        if($short == 'most_recent' && $short !== 'all'){
                            $postQuery->orderBy('posts.publish_date', 'desc');
                        }
        
                        $results = $postQuery->orderBy('posts.publish_date', 'desc')->offset($offset)
                                    ->limit($perPage)
                                    ->get()
                                    ->map(function ($item) {
                                        $item->image = $item->image == null ? "" : $item->image;
                                        $item->video_thumb = $item->video_thumb == null ? "" : $item->video_thumb;
                                        $item->video = $item->video == null ? "" : $item->video;
                                        $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
                                        $item->channel_logo = url(self::STORAGE_PATH. $item->channel_logo);
                                        
                                        return $item;
                                    });

            return response()->json([
                'error' => false,
                'message' => 'Data fetched successfully.',
                'data' => $results
            ]);
        } catch (\Exception $e) {
            ResponseService::logErrorResponse($e, 'Failed to fetch Recommendation posts: ' . $e->getMessage());
            return response()->json([
                'error' => 'Unable to fetch posts at this time. Please try again later.'
            ], 500);
        }
    }
    

    public function fetchTopics()
    {
        $page = (int) request()->get('page', 1);
        $perPage = (int) request()->get('per_page', 10);
        $offset = ($page - 1) * $perPage;

        
        $topics = Topic::select('id','slug','name','logo')->where('status','active')->whereHas('posts')
                    ->offset($offset)
                    ->limit($perPage)
                    ->get()->map(function ($item) {
                        if (empty($item->logo)) {
                            $item->logo = asset('assets/images/no_image_available.png');
                        } else {
                            $item->logo = asset(self::STORAGE_PATH. $item->logo);
                        }
                        return $item;
                    });

        return response()->json([
            'error' => false,
            'message' => 'Topics fetched successfully.',
            'data' => $topics
        ]);
    }
}
