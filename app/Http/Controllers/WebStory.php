<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Topic;
use App\Models\StorySlide;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class WebStory extends Controller
{
    public function index(Request $request)
    {
        $topics = Topic::all();
        $theme = getTheme();
        $selectedTopicId = $request->query('topic');

        $stories = Story::with(['story_slides', 'topic'])
            ->whereHas('story_slides')
            ->when($selectedTopicId, function (Builder $query) use ($selectedTopicId) {
                return $query->where('topic_id', $selectedTopicId);
            })
            ->get();

        $filteredTopics = $topics->filter(function ($topic) use ($stories) {
            return $stories->contains('topic_id', $topic->id);
        });

        return view("front_end/{$theme}/pages/webstory", compact(
            'filteredTopics',
            'theme',
            'stories',
            'selectedTopicId',
        ));
    }

    public function show(Topic $topic, Story $story)
    {
        
        if ($story->topic_id !== $topic->id) {
            abort(404);
        }
    
        // Get next story in the same topic
        $nextStory = Story::with(['story_slides', 'topic'])
            ->where('topic_id', $topic->id)
            ->where('id', '>', $story->id)
            ->whereHas('story_slides')
            ->first();
    
        // If no next story in the same topic, get the first story from any topic
        if (!$nextStory) {
            $nextStory = Story::with(['story_slides', 'topic'])
                ->whereHas('story_slides')
                ->where('id', '!=', $story->id)
                ->first();
        }
    
        // Pass the slides directly, no need to decode anything
        $animations = [];
        foreach ($story->story_slides as $slide) {
            $animations[$slide->id] = $slide->animation_details; // It's already an array
        }
    
        $theme = getTheme();
        
        return view("front_end/{$theme}/pages/webstory_slide", compact(
            'story',
            'theme',
            'nextStory',
            'animations' // Pass the animations to the view
        ));
    }
    
    public function storyByTopic(Topic $topic)
    {
        $topics = Topic::all();

        $theme = getTheme();

        $stories = Story::with(['story_slides', 'topic'])
            ->where('topic_id', $topic->id)
            ->whereHas('story_slides')
            ->latest()
            ->paginate(12);

        $totalStories = $stories->total();

        return view("front_end/{$theme}/pages/webstory_by_topic", compact(
            'stories',
            'topic',
            'theme',
            'totalStories',
            'topics'
        ));
    }
}