<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Story;
use App\Models\Topic;
use App\Models\StorySlide;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function publicIndex()
    {
        $title = __('STORIES');

        ResponseService::noAnyPermissionThenRedirect([ 'create-form-story','store-story','edit-form-story', 'update-story', 'delete-story']);
        $stories = Story::with(['story_slides' => function ($query) {
            $query->orderBy('order', 'asc');
        }, 'topic'])->latest()->get();
        
        return view('admin.webstory.all_story', compact('stories','title'));
    }
    public function create_story()
    {
        ResponseService::noPermissionThenRedirect('create-form-story');

        $title = __('CREATE_STORY');

        $topic = Topic::all();
        return view('admin.webstory.create_story', compact('title','topic'));
    }
    
    public function store(Request $request)
    {   
        ResponseService::noPermissionThenRedirect('store-story');

        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'slides' => 'required|array|min:1',
            'slides.*.title' => 'required|string|max:255',
            'slides.*.description' => 'nullable|string',
            'slides.*.image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slide_order' => 'required|json'
        ]);

        DB::beginTransaction();
        try {
            // Create story
            $slug = Str::slug($request->title);
            $existingSlug = Story::where('slug', $slug)->first();
            if ($existingSlug) {
                $slug = $slug . '-' . time();
            }

            $story = Story::create([
                'topic_id' => $request->topic_id,
                'title' => $request->title,
                'slug' => $slug,
            ]);
            // Process slides
            $slideOrder = json_decode($request->slide_order, true);
            foreach ($slideOrder as $order => $index) {
                $slide = $request->slides[$index];
                $path = $slide['image']->store('story_slides', 'public');
             
                StorySlide::create([
                    'story_id' => $story->id,
                    'title' => $slide['title'],
                    'description' => $slide['description'] ?? null,
                    'image' => $path,
                    'order' => $order,
                    'animation_details' => json_decode($request->animation_settings, true)
                ]);

            }

            DB::commit();
            
            return redirect()->route('stories.publicIndex')->with('success', 'Story created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating story: ' . $e->getMessage());
            return back()->with('error', 'Failed to create story. Please try again.');
        }
    }

    public function edit(Story $story)
    {
        ResponseService::noPermissionThenRedirect('edit-form-story');

        $title = __('UPDATE_STORY');
        $topic = Topic::all();
        $story->load('story_slides'); 
    
        $animations = [];
        foreach ($story->story_slides as $slide) {
            $animations[$slide->id] = is_string($slide->animation_details) 
                ? json_decode($slide->animation_details, true) 
                : $slide->animation_details; 
        }
    
        return view('admin.webstory.edit', compact('story', 'title', 'topic', 'animations'));
    }
    

    public function update(Request $request, Story $story)
    {
        ResponseService::noPermissionThenRedirect('update-story');

        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'slides' => 'required|array|min:1',
            'slides.*.title' => 'required|string|max:255',
            'slides.*.description' => 'nullable|string',
            'slides.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slide_order' => 'required|json',
            'delete_slides' => 'nullable|array' // Add this validation rule
        ]);

        DB::beginTransaction();
        try {
            // Update story details
            $slug = Str::slug($request->title);
            if ($slug !== $story->slug) {
                $existingSlug = Story::where('slug', $slug)
                    ->where('id', '!=', $story->id)
                    ->first();
                if ($existingSlug) {
                    $slug = $slug . '-' . time();
                }
            }

            $story->update([
                'topic_id' => $request->topic_id,
                'title' => $request->title,
                'slug' => $slug,
            ]);

            // Handle deleted slides first
            if ($request->has('delete_slides')) {
                foreach ($request->delete_slides as $slideId) {
                    $slide = StorySlide::find($slideId);
                    if ($slide && $slide->story_id === $story->id) {
                        Storage::disk('public')->delete($slide->image);
                        $slide->delete();
                    }
                }
            }

            // Process remaining slides
            $slideOrder = json_decode($request->slide_order, true);
            $existingSlideIds = $story->story_slides->pluck('id')->toArray();
            $updatedSlideIds = [];

            foreach ($slideOrder as $order => $index) {
                $slideData = $request->slides[$index];
                $slideId = $slideData['id'] ?? null;

                if ($request->has('delete_slides') && in_array($slideId, $request->delete_slides)) {
                    continue;
                }

                $slideUpdateData = [
                    'story_id' => $story->id,
                    'title' => $slideData['title'],
                    'description' => $slideData['description'] ?? null,
                    'order' => $order,
                    'animation_details' => json_decode($request->animation_settings,true)
                ];

                if (isset($slideData['image']) && $slideData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $slideUpdateData['image'] = $slideData['image']->store('story_slides', 'public');
                }

                if ($slideId) {
                    // Update existing slide
                    $slide = StorySlide::find($slideId);
                    if ($slide) {
                        if (isset($slideUpdateData['image'])) {
                            Storage::disk('public')->delete($slide->image);
                        }
                        $slide->where(['id'=>$slideId])->update($slideUpdateData);
                        $updatedSlideIds[] = $slideId;
                    }
                } else {
                    // Create new slide
                    $slide = StorySlide::create($slideUpdateData);
                    $updatedSlideIds[] = $slide->id;
                }
            }

            DB::commit();
            return redirect()->route('stories.publicIndex')
                ->with('success', 'Story updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating story: ' . $e->getMessage());
            return back()->with('error', 'Failed to update story. Please try again.');
        }
    }

    public function destroy(Story $story)
    {
        ResponseService::noPermissionThenRedirect('delete-story');

        $story->delete();
        return redirect()->route('stories.publicIndex')->with('success', 'Story deleted successfully.');
    }

    public function reorderView(Story $story)
    {
        $story->load(['story_slides' => function ($query) {
            $query->orderBy('order', 'asc');
        }]);

        return view('admin.webstory.reorder', compact('story'));
    }

    public function updateOrder(Request $request, Story $story)
    {
        try {
            DB::beginTransaction();

            $order = $request->input('order');

            $slideCount = $story->story_slides()->whereIn('id', $order)->count();
            if ($slideCount !== count($order)) {
                throw new \Exception('Invalid slide IDs provided');
            }

            // Update order for each slide
            foreach ($order as $index => $id) {
                StorySlide::where('id', $id)
                    ->where('story_id', $story->id)
                    ->update(['order' => $index]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Slide order updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating slide order: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update slide order'
            ], 500);
        }
    }
}
    