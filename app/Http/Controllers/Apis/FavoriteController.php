<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Post;
use Carbon\Carbon;


const UNAUTHORIZED_USER = 'Unauthorized user.';
class FavoriteController extends Controller
{
    /***** Manage user liked post *****/
    public function toggleFavorite(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'error' => true,
                'message' => UNAUTHORIZED_USER,
            ], 401);
        }

        $validatedData = $request->validate([
            'id' => ['required', 'exists:posts,id'],
        ]);

        try {
            $post = Post::findOrFail($validatedData['id']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'No post found.',
            ], 404);
        }

        $userId = Auth::id();
        $postId = $validatedData['id'];
        $favorite = Favorite::where('user_id', $userId)
            ->where('post_id', $postId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $post->decrement('favorite');
            $status = '0';
            $posrId = $postId;
            $message = 'Favorite removed';
        } else {

            Favorite::create([
                'user_id' => $userId,
                'post_id' => $postId,
            ]);
            $post->increment('favorite');
            $status = '1';
            $posrId = $postId;
            $message = 'Favorite added';
        }

        return response()->json([
            'error' => false,
            'status' => $status,
            'postId' => $posrId,
            'message' => $message,
        ]);
    }

    /***** Manage user store bookmark *****/
    public function addToggleFavorite(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'error' => true,
                'message' => UNAUTHORIZED_USER,
            ], 401);
        }

        $post = Post::where('slug', $request->slug)->first();
        
        $userId = Auth::id();

        $favorite = Favorite::where('user_id', $userId)
            ->where('post_id', $post->id)->first();

        if ($favorite != "") {
            $status = '0';
            $message = 'Aleary exest.';
        } else {
            Favorite::create([
                'user_id' => $userId,
                'post_id' => $post->id,
            ]);
            $post->increment('favorite');
            $status = '1';
            $message = 'Favorite added';
        }

        return response()->json([
            'error' => false,
            'status' => $status,
            'message' => $message,
        ]);
    }

    /***** Manage user remove bookmark *****/
    public function removeToggleFavorite(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'error' => true,
                'message' => UNAUTHORIZED_USER,
            ], 401);
        }

        $post = Post::where('slug', $request->slug)->first();

        $userId = Auth::id();
        $favorite = Favorite::where('user_id', $userId)
            ->where('post_id', $post->id)
            ->first();
        if ($favorite != "") {
            $favorite->delete();
            $post->decrement('favorite');
            $status = '0';
            $message = 'Favorite removed';
        } else {
            $status = '0';
            $message = 'Post not found.';
        }

        return response()->json([
            'error' => false,
            'status' => $status,
            'message' => $message,
        ]);
    }
    /***** Manage user Bookmarked posts *****/
    public function getPosts(Request $request)
    {

        if (Auth::check()) {
            $userId = Auth::user()->id;

            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 10);
            $offset = ($page - 1) * $perPage;

            $bookmarks = Favorite::select('favorites.id', 'posts.id as post_id', 'posts.title','posts.type','posts.video_thumb', 'posts.slug', 'posts.image', 'posts.publish_date', 'posts.favorite')
                ->leftJoin('posts', 'favorites.post_id', '=', 'posts.id')
                ->orderBy('favorites.id', 'desc')
                ->where('favorites.user_id', $userId)
                ->offset($offset)
                ->limit($perPage)
                ->get()
                ->map(function ($item) {
                    $item->video_thumb = $item->video_thumb == null ? "" : $item->video_thumb;
                    $item->image = $item->image == null ? "" : $item->image;
                    $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
                    $item->is_favorit = '1';
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
}
