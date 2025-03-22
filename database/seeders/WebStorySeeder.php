<?php

namespace Database\Seeders;

use App\Models\WebStory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WebStorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        WebStory::create([
            'title' => 'Test Web Story 1',
            'slug' => 'test-web-story-1',
            'content' => 'This is a sample web story for testing.',
            'image' => 'test1.jpg',
            'channel_id' => 1,  // Make sure to use a valid channel ID
            'topic_id' => 1,  // Make sure to use a valid topic ID
            'url' => 'http://example.com/test-web-story-1',  // Add the URL field
        ]);
    
        WebStory::create([
            'title' => 'Test Web Story 2',
            'slug' => 'test-web-story-2',
            'content' => 'This is another sample web story for testing.',
            'image' => 'test2.jpg',
            'channel_id' => 1,  // Use valid channel ID
            'topic_id' => 1,  // Use valid topic ID
            'url' => 'http://example.com/test-web-story-2',  // Add the URL field
        ]);
    }
    
}
