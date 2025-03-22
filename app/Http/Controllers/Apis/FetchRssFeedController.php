<?php

namespace App\Http\Controllers\Apis;

use App\Traits\SelectsFields;
use App\Constants\DatabaseFields;
use App\Http\Controllers\Controller;
use App\Models\Admin\Notifications as AdminNotifications;
use App\Models\AppPostView;
use App\Models\ChannelSubscriber;
use App\Models\Post;
use App\Models\ReadNotification;
use App\Models\Notifications;
use App\Services\ResponseService;
use Carbon\Carbon;
use DevDojo\LaravelReactions\Models\Reaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class FetchRssFeedController extends Controller
{
    const IS_FAVORIT_CONDITION = 'IF(favorites.user_id IS NOT NULL, 1, 0) as is_favorite';
    const STORAGE_PATH = 'storage/images/';
    use SelectsFields;
    
    /***** Fetch the post description*****/
    public function postDescription($slug, $device_id = null,$fcm_id = "")
    {
        $user = Auth::user();
        $userId = $user->id ?? null;
        try {
            if($device_id != ""){
                $this->viewCount($slug, $device_id);
            }

        $post = Post::select($this->selectPostDescriptionFields())
        ->selectRaw(self::IS_FAVORIT_CONDITION)
        ->join('channels', 'posts.channel_id', '=', 'channels.id')
        ->join('topics', 'posts.topic_id', '=', 'topics.id')
        ->leftJoin('favorites', function($join) use ($userId) {
            $join->on('posts.id', '=', 'favorites.post_id')
                 ->where('favorites.user_id', '=', $userId);
        })
        ->where('posts.slug', $slug)
        ->first();
        
        if ($post) {
            
            $post->publish_date = Carbon::parse($post->publish_date)->diffForHumans();
            $post->channel_logo = url(self::STORAGE_PATH . $post->channel_logo);

                            
            $userHasReacted = $post->reactions()->where('responder_id', $userId)->first();
            $post->user_has_reacted = isset($userHasReacted) ? true : false;
            $post->emoji_type = isset($userHasReacted) ? $userHasReacted->name : "";
            
            $getReactCountsData = $post->getReactionsSummary();
            
            $post->reaction_list = $getReactCountsData->sortByDesc(function($reaction) {
                $reactionEmoji = Reaction::where('name', $reaction->name)->first();
                $reaction->uuid = $reactionEmoji->uuid;
                return $reaction->count;
            })->values();

            $post->releted_post = Post::select($this->selectPostDescriptionFields())
                ->join('channels', 'posts.channel_id', '=', 'channels.id')
                ->join('topics', 'posts.topic_id', '=', 'topics.id')
                ->where('topics.name', $post->topic_name)
                ->where('posts.slug', '!=', $slug)
                ->where('posts.publish_date', '>=', Carbon::now()->subDays(7))
                ->inRandomOrder()
                ->orderBy('posts.publish_date', 'desc')
                ->take(4)
                ->get()
                ->map(function($item) {
                    $item->video_thumb = $item->video_thumb == null ? "" : $item->video_thumb;
                    $item->video = $item->video == null ? "" : $item->video;
                    $item->image = $item->image ?? url('public/front_end/classic/images/default/post-placeholder.jpg');
                    $item->publish_date_org = $item->publish_date;
                    $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
                    $item->channel_logo = url(self::STORAGE_PATH. $item->channel_logo);
                    return $item;
                });

            
            if($fcm_id != ""){
                $this->readNotification($fcm_id,$slug);
            }
            return response()->json([
                'error' => false,
                'message' => DatabaseFields::POST_DESCRIPTION_FETCHED_SECCUSSES,
                'data' => $post
            ]);
        }
  

        return response()->json([
            'error' => false,
            'message' => 'No post found.',
            'data' => []
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => true,
            'message' => 'An error occurred while fetching the post: ' . $e->getMessage()
        ], 500);
    }
}

    /***** Fetch Banner Posts *****/
    protected function fetchBannerPosts()
    {
        $post = Post::select($this->selectBannerPosts())
            ->join('channels', 'posts.channel_id', '=', 'channels.id')
            ->join('topics', 'posts.topic_id', '=', 'topics.id')
            ->where('publish_date', '>', now()->subDays(7)->endOfDay())
            ->where('posts.image','!=','')
            ->where('posts.description','!=','')
            ->groupBy('channel_id')
            ->orderBy('publish_date','desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                $item->image = $item->image == null ? "" : $item->image;
                $item->video_thumb = $item->video_thumb == null ? "" : $item->video_thumb;
                $item->video = $item->video == null ? "" : $item->video;
                $item->pubdate = $item->publish_date;
                $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
                return $item;
            });
            
        return response()->json([
            'error' => false,
            'message' => 'Banner Posts fetched successfully.',
            'data' => $post
        ]);
    }

     /***** Fetch Popular Posts For Home Page *****/
 /*     protected function fetchPopularHome(Request $request)
     {
            $user = Auth::user();
            $userId = $user ? $user->id : null;
         try {
             $popularPost = Post::select($this->selectPopularPostFields())
                 ->selectRaw(self::IS_FAVORIT_CONDITION)
                 ->join('channels', 'posts.channel_id', '=', 'channels.id')
                 ->join('topics', 'posts.topic_id', '=', 'topics.id')
                 ->leftJoin('favorites', function($join) use ($userId) {
                     $join->on('posts.id', '=', 'favorites.post_id')
                          ->where('favorites.user_id', '=', $userId);
                 })
                 ->orderBy('publish_date', 'desc')
                 ->where('posts.image','!=','')
                 ->take(5)
                 ->get()
                 ->map(function ($item) {
                     $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
                     $item->channel_logo = url(self::STORAGE_PATH . $item->channel_logo);
 
                     return $item;
                 });
 
             return response()->json([
                 'error' => false,
                 'message' => 'Posts fetched successfully.',
                 'data' => $popularPost
             ]);
         } catch (\Exception $e) {
             Log::error('Failed to fetch popular posts: ' . $e->getMessage());
             return response()->json([
                 'error' => 'Unable to fetch popular posts at this time. Please try again later.'.$e
             ], 500);
         }
     } */

    /***** Fetch Popular Posts *****/
    protected function fetchPopularPosts()
    {

        $user = Auth::user();
        $userId = $user ? $user->id : null;
        try {
            $page = request()->get('page', 1);
            $perPage = request()->get('per_page', 10);
            $offset = ($page - 1) * $perPage;
            
            $popularPosts = Post::select($this->selectPopularPostFields())
            ->selectRaw(self::IS_FAVORIT_CONDITION)
            ->join('channels', 'posts.channel_id', '=', 'channels.id')
            ->join('topics', 'posts.topic_id', '=', 'topics.id')
            ->leftJoin('favorites', function($join) use ($userId) {
                $join->on('posts.id', '=', 'favorites.post_id')
                     ->where('favorites.user_id', '=', $userId);
            })
            ->where('publish_date', '>', now()->subDays(4)->endOfDay())
            ->orderBy('posts.view_count', 'desc')
            ->orderBy('posts.publish_date', 'desc')
            ->offset($offset)
            ->limit($perPage)
            ->get()
            ->map(function ($item) {
                $item->image = $item->image == null ? "" : $item->image;
                $item->video_thumb = $item->video_thumb == null ? "" : $item->video_thumb;
                $item->video = $item->video == null ? "" : $item->video;
                $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
                $item->channel_logo = url(self::STORAGE_PATH . $item->channel_logo);

                return $item;
            });
            
            return response()->json([
                'error' => false,
                'message' => 'Posts fetched successfully.',
                'data' => $popularPosts
            ]);
        } catch (\Exception $e) {
            ResponseService::logErrorResponse($e, 'Failed to fetch popular posts: ' . $e->getMessage());
            return response()->json([
                'error' => 'Unable to fetch popular posts at this time. Please try again later.'
            ], 500);
        }
    }

    /***** Recommanded content & Content May you Like *****/
    public function fetchPosts()
    {
        try {
            
            $user = Auth::user();
            $perPage = request()->get('per_page', 10);
            $userId = $user ? $user->id : null;
            $channel_ids = ChannelSubscriber::where('user_id', $userId)->pluck('channel_id')->toArray();

            $post = Post::select($this->recommandedfetchPosts())
            ->selectRaw(self::IS_FAVORIT_CONDITION)
            ->join('channels', 'posts.channel_id', '=', 'channels.id')
            ->join('topics', 'posts.topic_id', '=', 'topics.id')->leftJoin('favorites', function($join) use ($userId) {
                $join->on('posts.id', '=', 'favorites.post_id')
                     ->where('favorites.user_id', '=', $userId);
            })->where('channels.status','active');
            if($user){
                $post = $post->whereNotIn('posts.channel_id', $channel_ids);
            }
            $post = $post->orderBy('posts.publish_date', 'desc')
                ->orderBy('posts.view_count', 'desc')
                ->where('posts.image','!=','')
                ->paginate($perPage);
    
            $results = $post->map(function ($item) {
                $item->image = $item->image == null ? "" : $item->image;
                $item->video_thumb = $item->video_thumb == null ? "" : $item->video_thumb;
                $item->video = $item->video == null ? "" : $item->video;
                $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
                $item->channel_logo = url(self::STORAGE_PATH . $item->channel_logo);
            
                return $item;
            });

            return response()->json([
                'error' => false,
                'message' => 'Recomanded fetched successfully.',
                'data' => $results
                ]);
        } catch (\Exception $e) {
            ResponseService::logErrorResponse($e, 'Failed to fetch Recomandation posts: ' . $e->getMessage());
            return response()->json([
                'error' => 'Unable to fetch posts at this time. Please try again later.'
            ], 500);
        }
    }

    /***** Fetch Data By Topics *****/
    public function fetchPostsByTopic($topic)
{
    $user = Auth::user();
    $userId = $user ? $user->id : null;

    try {
        $page = (int) request()->get('page', 1);
        $perPage = (int) request()->get('per_page', 10);
        $offset = ($page - 1) * $perPage;

        $postQuery = Post::select($this->recommandedfetchPosts())
            ->selectRaw(self::IS_FAVORIT_CONDITION)
            ->join('channels', 'posts.channel_id', '=', 'channels.id')
            ->join('topics', 'posts.topic_id', '=', 'topics.id')
            ->leftJoin('favorites', function($join) use ($userId) {
                $join->on('posts.id', '=', 'favorites.post_id')
                     ->where('favorites.user_id', '=', $userId);
            })
            ->where('topics.name', $topic)
            ->where('posts.image','!=','')
            ->orderBy('posts.publish_date', 'desc');

        $results = $postQuery->offset($offset)
                    ->limit($perPage)
                    ->get()
                    ->map(function ($item) {
                        $item->image = $item->image == null ? "" : $item->image;
                        $item->video_thumb = $item->video_thumb == null ? "" : $item->video_thumb;
                        $item->video = $item->video == null ? "" : $item->video;
                        $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
                        $item->channel_logo = url(self::STORAGE_PATH . $item->channel_logo);

            return $item;
        });

        return response()->json([
            'error' => false,
            'message' => 'Topic fetched successfully.',
            'data' => $results
        ]);
    } catch (\Exception $e) {
        ResponseService::logErrorResponse($e, 'Failed to fetch Recommendation posts: ' . $e->getMessage());
        return response()->json([
            'error' => 'Unable to fetch posts at this time. Please try again later.'
        ], 500);
    }
}


/***** Followed channels posts *****/
public function followedChannelsPosts()
{
    try {
        
        if(Auth::check()){
        $perPage = request()->get('per_page', 10);
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $channel_ids = ChannelSubscriber::where('user_id', $userId)->pluck('channel_id')->toArray();
        
        $post = Post::select($this->recommandedfetchPosts())
        ->selectRaw(self::IS_FAVORIT_CONDITION)
        ->join('channels', 'posts.channel_id', '=', 'channels.id')
        ->join('topics', 'posts.topic_id', '=', 'topics.id')->leftJoin('favorites', function($join) use ($userId) {
            $join->on('posts.id', '=', 'favorites.post_id')
                 ->where('favorites.user_id', '=', $userId);
        })->whereIn('posts.channel_id', $channel_ids)
        ->orderBy('posts.publish_date', 'desc')
            ->orderBy('posts.view_count', 'desc')
            ->where('posts.image','!=','')
            ->paginate($perPage);

            $results = $post->map(function ($item) {
                $item->image = $item->image == null ? "" : $item->image;
                $item->video_thumb = $item->video_thumb == null ? "" : $item->video_thumb;
                $item->video = $item->video == null ? "" : $item->video;
                $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
                $item->channel_logo = url(self::STORAGE_PATH . $item->channel_logo);
            
                return $item;
            });

        return response()->json([
            'error' => false,
            'message' => 'Followed Channels posts fetched successfully.',
            'data' => $results
            ]);
        }else{
            return response()->json([
                'error' => false,
                'message' => 'Unauthorized User',
                'data' => []
                ]);
        }

    } catch (\Exception $e) {
        ResponseService::logErrorResponse($e, 'Failed to fetch Recomandation posts: ' . $e->getMessage());
        return response()->json([
            'error' => 'Unable to fetch posts at this time.'
        ], 500);
    }
}

/* Manage posts view count */
public function viewCount($slug , $device_id){
        
    $post = Post::where('slug',$slug)->first();
        if($post !== null){

            $viewexist = AppPostView::where('post_id',$post->id)
            ->where('device_id',$device_id)
            ->first();

            if(!$viewexist){
                AppPostView::create([
                    'device_id' => $device_id,
                    'post_id' => $post->id,
                ]);
                $post->increment('view_count');
            }
        }
        return true;
    }

    public function readNotification($fcm_id,$slug){
        
        
        $notificationId = AdminNotifications::where('slug', $slug)->first();
            if($notificationId != null){
                $alreadyRead = ReadNotification::where('notification_id',$notificationId->id)->where('fcm_id', $fcm_id)->first();
                if ($alreadyRead === null) {
                
                    ReadNotification::create([
                        'notification_id' => $notificationId->id,
                    'fcm_id' => $fcm_id,
                ]);
            }
        }

       return true;
    }
}
