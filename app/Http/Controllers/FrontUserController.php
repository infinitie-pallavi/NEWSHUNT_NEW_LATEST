<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Carbon\Carbon;
class FrontUserController extends Controller
{
    const PATH = 'front_end/';
    public function __construct()
    {
        $this->middleware('auth'); // Ensures user is authenticated
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    if (!auth()->check()) {
        return redirect()->route('home');
    }
    $title = "My Account";
    $theme = getTheme();
    $data = compact('title','theme');
    return view(self::PATH. $theme . '/pages/my-account/user-profile', $data);
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

    public function followingsChannels(){
        if (!auth()->check()) {
            return redirect()->route('home');
        }
        $channelData = auth()->user()->subscriptions()->paginate(8);
        $title = 'Followings';
        $theme = getTheme();
        $data = compact('title','channelData','theme');
        return view(self::PATH. $theme . '/pages/my-account/following', $data);
    }
    
    public function favoritePosts(){
        if (!auth()->check()) {
            return redirect()->route('home');
        }
        $userId = auth()->user()->id;

        $favoritedPosts = Favorite::select('posts.id', 'posts.title', 'posts.slug', 'posts.image','posts.type','posts.video_thumb', 'posts.publish_date', 'channels.name as channel_name', 'channels.logo as channel_logo', 'channels.slug as channel_slug', 'topics.name as topic_name', 'topics.slug as topic_slug')
        ->leftJoin('posts', 'favorites.post_id', '=', 'posts.id')
        ->leftJoin('channels', 'posts.channel_id', '=', 'channels.id')
        ->leftJoin('topics', 'posts.topic_id', '=', 'topics.id')
        ->where('favorites.user_id', $userId)
        ->paginate(8)
        ->withQueryString();
        $favoritedPosts->getCollection()->transform(function ($item) {
            $item->publish_date_news = Carbon::parse($item->publish_date)->format('Y-m-d H:i');
            $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();
            $item->channel_logo = url('storage/images/' . $item->channel_logo);
            
            return $item;
        });
        $title = 'Favorite';
        $theme = getTheme();
        $data = compact('title','favoritedPosts','theme');
        return view(self::PATH. $theme . '/pages/my-account/favorite', $data);
    }
}
