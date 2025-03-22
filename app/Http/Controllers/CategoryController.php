<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Channel;
use App\Models\Topic;
use App\Models\Setting;
use Carbon\Carbon;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($topic = null)
    {
        $perPage = 15;
    
        $getPosts = Post::select('posts.id','posts.slug' ,'posts.image', 'posts.type', 'posts.video_thumb', 'posts.comment','posts.view_count',
                'channels.name as channel_name', 'channels.logo as channel_logo', 'channels.slug as channel_slug',
                'topics.name as topic_name','topics.slug as topic_slug', 'posts.title',
                'posts.favorite', 'posts.description', 'posts.status', 'posts.publish_date')
                ->join('channels', 'posts.channel_id', '=', 'channels.id')
                ->join('topics', 'posts.topic_id', '=', 'topics.id')
            ->orderBy('posts.publish_date', 'Desc');
    
        if(!empty($topic)){
            $getPosts->where('topics.name', $topic);
        }
    
        $getPosts = $getPosts->paginate($perPage);
    
        foreach ($getPosts as $post) {
            if ($post->publish_date) {
                $post->publish_date_news = Carbon::parse($post->publish_date)->format('Y-m-d H:i');
                $post->publish_date = Carbon::parse($post->publish_date)->diffForHumans();
            }
        }
        $post_lable = Setting::get()->where('name','news_lable_place_holder')->first();
        $title = $getPosts->first()->topic_name ?? 'Posts';
        $theme = getTheme();
        $data = compact('title', 'getPosts','post_lable','theme');
        return view('front_end/' . $theme . '/pages/topic-posts', $data);
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
    public function show(Request $request)
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
}
