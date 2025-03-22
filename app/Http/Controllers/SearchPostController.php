<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Topic;
use App\Models\Channel;
use App\Models\TopicFollower;
use App\Models\ChannelSubscriber;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SearchPostController extends Controller
{
    public function search(Request $request)
    {
        $searchQuery = $request->input('search');
        $channels = $request->input('channel');
        $topics = $request->input('topic');
        $filter = $request->input('filter');

        $channel_ids = ChannelSubscriber::where('user_id', Auth::user()->id ?? 0)->pluck('channel_id')->toArray();
        $topic_ids = TopicFollower::where('user_id', Auth::user()->id ?? 0)->pluck('topic_id')->toArray();

        $getPosts = Post::select(
            'posts.id',
            'posts.slug',
            'posts.image',
            'posts.comment',
            'channels.name as channel_name',
            'channels.logo as channel_logo',
            'channels.slug as channel_slug',
            'topics.name as topic_name',
            'topics.slug as topic_slug',
            'posts.title',
            'posts.favorite',
            'posts.description',
            'posts.status',
            'posts.publish_date',
            'posts.view_count',
            'posts.type',
            'posts.video_thumb',
        )
            ->join('channels', 'posts.channel_id', '=', 'channels.id')
            ->join('topics', 'posts.topic_id', '=', 'topics.id');

        if ($searchQuery) {
            $getPosts->where(function ($subQuery) use ($searchQuery) {
                $subQuery->where('posts.slug', 'LIKE', "%$searchQuery%")
                    ->orWhere('posts.title', 'LIKE', "%$searchQuery%")
                    ->orWhere('channels.slug', 'LIKE', "%$searchQuery%")
                    ->orWhere('channels.name', 'LIKE', "%$searchQuery%")
                    ->orWhere('topics.slug', 'LIKE', "%$searchQuery%")
                    ->orWhere('topics.name', 'LIKE', "%$searchQuery%");
            });
        }
        if (!empty($channels)) {
            $getPosts->whereIn('channels.slug', $channels);
        }
        if (!empty($topics)) {
            $getPosts->whereIn('topics.slug', $topics);
        }


        if ($filter == "most-read") {

            $getPosts->where('publish_date', '>', now()->subDays(7)->endOfDay())->orderBy('posts.view_count', 'DESC');
        } elseif ($filter == "most-liked") {

            $getPosts->orderBy('posts.favorite', 'DESC');
        } elseif ($filter == "most-recent") {

            $getPosts->orderBy('posts.publish_date', 'DESC');
        } elseif ($filter == "channels-followed") {

            $getPosts->whereIn('posts.channel_id', $channel_ids);
        } elseif ($filter == "topics-followed") {

            $getPosts->whereIn('posts.topic_id', $topic_ids);
        } else {
            $getPosts->orderBy('posts.publish_date', 'DESC');
        }

        $getPosts = $getPosts->paginate(15)->withQueryString();
        $channels = Channel::select('id', 'name', 'slug')->where('status', 'active')->get();
        $topics = Topic::select('id', 'name', 'slug')->where('status', 'active')->get();
        $post_label = Setting::get()->where('name', 'news_label_place_holder')->first();

        foreach ($getPosts as $post) {
            if ($post->publish_date) {
                $post->image = $post->image ?? url('public/front_end/classic/images/default/post-placeholder.jpg');
                $post->publish_date_news = Carbon::parse($post->publish_date)->format('Y-m-d H:i');
                $post->publish_date = Carbon::parse($post->publish_date)->diffForHumans();
            }
        }

        $title = $searchQuery ?? isset($post_label->value) ? $post_label->value : "";
        $theme = getTheme();

        return view('front_end/' . $theme . '/pages/search-result', compact('getPosts', 'title', 'searchQuery', 'post_label', 'channels', 'topics', 'theme'));
    }

    public function autocomplete(Request $request)
    {
        $searchQuery = $request->input('search');

        $posts = Post::select('title', 'slug', 'image')
            ->when($searchQuery, function ($query) use ($searchQuery) {
                return $query->where('title', 'LIKE', "$searchQuery%");
            })
            ->orderBy('publish_date', 'desc'); // Move orderBy here

        $topics = Topic::selectRaw('name as title,  slug, "" as image')
            ->when($searchQuery, function ($query) use ($searchQuery) {
                return $query->where('name', 'LIKE', "$searchQuery%");
            });

        $channels = Channel::selectRaw(' name as title, slug,"" as image')
            ->when($searchQuery, function ($query) use ($searchQuery) {
                return $query->where('name', 'LIKE', "$searchQuery%");
            });

        $combinedQuery = $posts->union($channels)->union($topics);

        $results = $combinedQuery->get();

        $formattedResults = $results->map(function ($post) {
            return [
                'title' => $post->title,
                'url' => isset($post->slug) ? route('posts.show', $post->slug) : null,
                'image' => $post->image
            ];
        });

        return response()->json($formattedResults);
    }

    public function getChannel($id)
    {
        $channel = Channel::select('id', 'name', 'logo', 'follow_count')->find($id);

        if ($channel) {
            $channel->channel_logo = url('storage/images/' . $channel->logo);
            return response()->json($channel);
        }

        return response()->json(['error' => 'Channel not found'], 404);
    }
}