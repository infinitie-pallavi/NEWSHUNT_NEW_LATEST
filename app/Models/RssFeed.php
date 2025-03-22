<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RssFeed extends Model
{
    use HasFactory;
    
    protected $fillable = ['channel_id','topic_id','feed_url','data_format','sync_interval','status'];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

}
