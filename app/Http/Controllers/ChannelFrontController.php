<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Channel;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\ChannelSubscriber;
class ChannelFrontController extends Controller
{

    public function Index($channel=null)
    {
        $theme = getTheme();
        if($channel !== null){
            $channelData = Channel::where('slug', $channel)->firstOrFail();
            $channelData->logo = url('storage/images/' . $channelData->logo);

            $perPage = 15;

            $getChannelPosts = Post::select('posts.id', 'posts.slug','posts.type','posts.video','posts.video_thumb', 'posts.image', 'posts.comment',
                    'channels.name as channel_name', 'channels.logo as channel_logo',
                    'topics.name as topic_name', 'topics.slug as topic_slug', 'posts.title',
                    'posts.favorite', 'posts.description', 'posts.status', 'posts.publish_date')
                    ->join('channels', 'posts.channel_id', '=', 'channels.id')
                    ->join('topics', 'posts.topic_id', '=', 'topics.id')
                    ->where('posts.channel_id', $channelData->id)
                    ->orderBy('posts.publish_date', 'desc')
                    ->paginate($perPage);
            $post_count = Post::where('posts.channel_id', $channelData->id)->count();
            foreach ($getChannelPosts as $post) {
                if ($post->publish_date) {
                    $post->image = $post->image ?? url('public/front_end/classic/images/default/post-placeholder.jpg');
                    $post->publish_datee_news = Carbon::parse($post->publish_date)->format('Y-m-d H:i');
                    $post->publish_date = Carbon::parse($post->publish_date)->diffForHumans();
                }
            }
            if (Auth::check()) {
                $user = Auth::user();
                $subscriber = ChannelSubscriber::where('channel_id',$channelData->id)->where('user_id', $user->id)->first();
            }else{
                $subscriber = 'unauthorized';
            }
                $title = $channelData->name;
                $data = compact('title', 'channelData', 'getChannelPosts','subscriber','post_count','theme');
                return view('front_end/' . $theme . '/pages/channel-profile', $data);
        }else{
            
            $perPage = 12;
            $user = Auth::user();
                $channelData = Channel::where('status', 'active')
                    ->withCount(['subscribers as is_followed' => function ($query) use ($user) {
                        $query->where('user_id', $user->id ?? '');
                    }])
                    ->paginate($perPage);
            $title = 'Channels';
            $data = compact('title', 'channelData','theme');
            return view('front_end/' . $theme . '/pages/channels', $data);
        }

    }

    public function channelFollow(Channel $channel)
    {
        if (!Auth::check()) {
            return response()->json(['error' => true, 'message' => 'User not authenticated.'], 401);
        }

        $user = Auth::user();
        $isSubscribed = $channel->subscribers()->where('user_id', $user->id)->exists();

        if ($isSubscribed) {
            $channel->subscribers()->detach($user->id);
            $channel->decrement('follow_count');
            $status= "0";
            $message = 'Channel unsubscribed successfully.';
        } else {
            $channel->subscribers()->attach($user->id);
            $channel->increment('follow_count');
            $status= "1";
            $message = 'Channel subscribed successfully.';
        }

        $updatedFollowCount = $channel->follow_count;
        return response()->json(['error' => false,'status'=>$status, 'count'=>$updatedFollowCount, 'message' => $message]);
    }

}
