<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Topic;


const STORAGE_PATH = 'storage/';
class StoryController extends Controller
{
    public function index($type, $topic = '')
    {
        try {
            if ($type == "home") {
                $response = $this->home();
            } elseif ($type == "all-stories") {
                $response = $this->categories();
            } elseif ($type == "topic") {
                $response = $this->topic($topic);
            }
            return $response;
        } catch (\Exception $e) {
            Log::error('Error in StoryController@index: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching stories.',
                'data' => [$e]
            ], 500);
        }
    }



    private function home($story_limit = 1, $topic_limit = 10)
    {
        // First, get topics with their stories and slides, limited by topic_limit
        $topics = Topic::has('stories')
            ->with([
                'stories' => function ($query) {
                    $query->select('id', 'title', 'slug', 'topic_id')->orderBy('created_at', 'DESC');
                },
                'stories.story_slides' => function ($query) {
                    $query->select('id', 'story_id', 'title', 'image', 'description', 'order', 'animation_details')
                        ->orderBy('order', 'asc');
                }
            ])
            ->select('id', 'name', 'slug')
            ->limit($topic_limit)
            ->get();


        // Shuffle stories within each topic and limit to story_limit
        $topics->each(function ($topic) use ($story_limit) {
            $topicStories = $topic->stories->shuffle()->take($story_limit);

            // Assign shuffled stories back to the topic
            $topic->setRelation('stories', $topicStories);

            // Process each story within the topic
            $topic->stories->each(function ($story) use ($topic) {
                // Set topic_name for each story
                $story->topic_name = $topic->name;

                // Process image paths
                $story->story_slides->map(function ($storySlide) {
                    $storySlide->image = asset(STORAGE_PATH . $storySlide->image);
                    return $storySlide;
                });
            });
        });

        return response()->json([
            'error' => false,
            'message' => 'Home stories fetched successfully',
            'data' => $topics
        ]);
    }

    
    private function categories()
    {
        $perPage = request()->get('per_page', 10);

        $topics = Topic::has('stories')
            ->with([
                'stories' => function ($query) {
                    $query->select('id', 'title', 'slug', 'topic_id')->orderBy('created_at', 'DESC')->take(10);
                },
                'stories.story_slides' => function ($query) {
                    $query->select('id', 'story_id', 'title', 'image', 'description', 'order', 'animation_details')->orderBy('order', 'asc');
                }
            ])
            ->select('id', 'name', 'slug')
            ->paginate($perPage)
            ->map(function ($topic) {
                $topic->stories->each(function ($story) {
                    $story->story_slides->map(function ($storySlide) {
                        $storySlide->image = asset(STORAGE_PATH . $storySlide->image);
                        return $storySlide;
                    });
                });
                return $topic;
            });

        return response()->json([
            'error' => false,
            'message' => 'All stories fetched successfully',
            'data' => $topics,
        ]);
    }


    private function topic($topic)
    {
        $perPage = request()->get('per_page', 10);

        $topics = Topic::where('slug', $topic)
            ->with([
                'stories' => function ($query) use ($perPage) {

                    $query->select('id', 'title', 'slug', 'topic_id')
                        ->paginate($perPage);
                },
                'stories.story_slides' => function ($query) {

                    $query->select('id', 'story_id', 'title', 'image', 'description', 'order', 'animation_details')
                        ->orderBy('order', 'asc');
                }
            ])
            ->select('id', 'name', 'slug')
            ->get()->map(function ($topic) {
                $topic->stories->each(function ($story) {
                    $story->story_slides->map(function ($storySlide) {
                        $storySlide->image = asset(STORAGE_PATH . $storySlide->image);
                        return $storySlide;
                    });
                });
                return $topic;
            });

        return response()->json([
            'error' => false,
            'message' => 'All stories fetched successfully',
            'data' => $topics,
        ]);
    }
}
