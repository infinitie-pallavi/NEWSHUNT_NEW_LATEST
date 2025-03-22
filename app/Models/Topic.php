<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'logo', 'status'];

    public function rssFeeds()
    {
        return $this->hasMany(RssFeed::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    // Define the relationship with the WebStory model

    public function webStories()
    {
        return $this->hasMany(StorySlide::class);
    }
    public function stories()
    {
        return $this->hasMany(Story::class);
    }
}
