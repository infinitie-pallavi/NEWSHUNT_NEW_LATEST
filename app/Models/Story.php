<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'topic_id','animation_details'];
    /**
     * Get the slides associated with the story.
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    // In your Story model (app/Models/Story.php)
    public function story_slides()
    {
        return $this->hasMany(StorySlide::class)->orderBy('order', 'asc');
    }

}

