<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Post;
use Carbon\Carbon;

class BookmarkController extends Controller
{
/*
*
* This Method Show Bookmark Posts
*/
public function index(Request $request)
{
    if (Auth::check()) {
        $userId = Auth::user()->id;
        // Get pagination parameters
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 10);
        $offset = ($page - 1) * $perPage;
        $bookmarks = Favorite::select('posts.id', 'posts.title', 'posts.image', 'posts.publish_date', 'posts.favorite')
            ->join('posts', 'favorites.post_id', '=', 'posts.id')
            ->where('favorites.user_id', $userId)
            ->orderBy('favorites.id', 'desc')
            ->offset($offset)
            ->limit($perPage)
            ->get()
            ->map(function ($item) {
                $item->publish_date = Carbon::parse($item->publish_date)->format('d M Y');
                return $item;
            });
        return response()->json([
            'error' => false,
            'message' => $bookmarks->isEmpty() ? 'No posts found' : 'Posts fetched successfully',
            'data' => $bookmarks
        ]);
    } else {
        return response()->json([
            'error' => true,
            'message' => "User is not authenticated.",
        ]);
    }
}
/**
 * Discover Posts
 */
public function discoverPosts(Request $request)
{
    try {
        
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 10);
        $offset = ($page - 1) * $perPage;
        
        $posts = Post::select(['posts.id','posts.image','posts.title','posts.slug','posts.description','posts.favorite','posts.publish_date','channels.name as channel_name','channels.slug as channel_slug'])
        ->selectRaw('IF(favorites.user_id IS NOT NULL, 1, 0) as is_favorite')
        ->join('channels', 'posts.channel_id', '=', 'channels.id')
        ->leftJoin('favorites', function($join) use ($userId) {
            $join->on('posts.id', '=', 'favorites.post_id')
                 ->where('favorites.user_id', '=', $userId);
        })
        ->where('posts.image','!=','')
        ->orderBy('posts.publish_date', 'desc')
        ->offset($offset)
        ->limit($perPage)
        ->get()
        ->map(function ($item) {
            
            $item->publish_date = Carbon::parse($item->publish_date)->format('D, d M Y');
            
            return $item;
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Posts fetched successfully.',
            'data' => $posts
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Unable to fetch posts at this time. Please try again later.'
        ], 500);
    }
}
}
