<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Topic;
use App\Models\Channel;
use Illuminate\Support\Facades\Auth;
use App\Traits\SelectsFields;
use Illuminate\Support\Facades\DB;

class SuggestionPostController extends Controller
{
    /******* Get Suggestions *******/
    public function getsuggestion(Request $request)
{
    $searchQuery = $request->input('search');
    $perPage = $request->get('per_page', 5);

    $posts = Post::select('image as image', 'video_thumb', 'type', 'title', 'slug')
        ->when($searchQuery, function ($query) use ($searchQuery) {
            return $query->where('title', 'LIKE', "$searchQuery%");
        });

    $channels = Channel::select(DB::raw('CONCAT("' . url('storage/images/') . '/", logo) as image'), 'name as title', 'slug')
        ->selectRaw('"" as video_thumb, "" as type') // Use empty strings
        ->when($searchQuery, function ($query) use ($searchQuery) {
            return $query->where('name', 'LIKE', "$searchQuery%");
        });

    $topics = Topic::selectRaw('"" as image, "" as video_thumb, "" as type, name as title, slug')
        ->when($searchQuery, function ($query) use ($searchQuery) {
            return $query->where('name', 'LIKE', "$searchQuery%");
        });

    $suggestions = $posts->orderBy('posts.publish_date', 'desc')
        ->union($channels)
        ->union($topics)
        ->paginate($perPage);

    $result = $suggestions->map(function($suggestion) {
        return [
            'image' => $suggestion->type== 'post' ? $suggestion->image: $suggestion->video_thumb,
            'title' => $suggestion->title
        ];
    });

    return response()->json([
        'error' => false,
        'message' => 'Get suggestion successfully.',
        'data' => $result,
    ]);
}

    
    

    /****** Get Search Data ******/
    public function search(Request $request)
    {
        $page = request()->get('page', 1);
        $searchQuery = $request->input('search');
        $perPage = $request->get('per_page', 10);
        $offset = ($page - 1) * $perPage;
    
        if (Auth::check()) {
            $userId = Auth::user()->id;
        }else{
            $userId = '0';
        }
        $getPosts = Post::select('posts.id', 'posts.favorite','posts.image','posts.type','posts.video_thumb', 'posts.title', 'posts.slug','posts.view_count',
            'channels.name as channel_name', 'channels.logo as channel_logo', 'channels.slug as channel_slug',
            'topics.name as topic_name', 'topics.slug as topic_slug', 'posts.pubdate','posts.publish_date')
            ->selectRaw('IF(favorites.user_id IS NOT NULL, 1, 0) as is_favorite')
            ->join('channels', 'posts.channel_id', '=', 'channels.id')
            ->join('topics', 'posts.topic_id', '=', 'topics.id')
            ->leftJoin('favorites', function($join) use ($userId) {
                $join->on('posts.id', '=', 'favorites.post_id')
                     ->where('favorites.user_id', '=', $userId);
            })
            ->when($searchQuery, function ($query) use ($searchQuery) {
                return $query->where(function ($subQuery) use ($searchQuery) {
                    $subQuery->where('posts.slug', 'LIKE', "%$searchQuery%")
                        ->orWhere('posts.title', 'LIKE', "%$searchQuery%")
                        ->orWhere('channels.name', 'LIKE', "%$searchQuery%")
                        ->orWhere('topics.name', 'LIKE', "%$searchQuery%");
                });
            })
            ->orderBy('posts.publish_date','DESC')
            ->offset($offset)
            ->limit($perPage)
            ->get()
            ->map(function ($item) {
                $item->video_thumb = $item->video_thumb !== null ? $item->video_thumb : "";
                $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
                $item->channel_logo = url('storage/images/' . $item->channel_logo);
                $item->search = true;

                return $item;
            });
    
        return response()->json([
            'error' => false,
            'message' => 'Fetch search result successfully.',
            'data' => $getPosts,
        ]);
    }
}
