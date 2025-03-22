<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Jobs\FetchRssFeedJob;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use App\Models\Channel;
use App\Models\RssFeed;
use App\Models\Topic;
use Throwable;

class RssFeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ResponseService::noAnyPermissionThenRedirect(['list-rssfeed', 'create-rssfeed', 'update-rssfeed', 'delete-rssfeed']);
        $title = __('RSS_FEEDS');
        $pre_title = __('RSS_FEEDS');
        $channels_lists = Channel::all()->where('status', 'active');
        $topics_lists = Topic::all()->where('status', 'active');
        $data = compact('title','pre_title','channels_lists','topics_lists');
        return view('admin.rss_feed.index', $data);
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
    public function store(Request $request, RssFeed $rssFeed)
{
    ResponseService::noPermissionThenSendJson('create-rssfeed');
    
    $validator = Validator::make($request->all(), [
        'rss_feed_url' => 'required|url',
        'channel_id' => 'required|exists:channels,id',
        'topic_id' => 'required|exists:topics,id',
        'sync_interval' => 'required|integer|min:1',
        'data_formate' => 'required|in:XML,JSON',
        'status' => 'required|in:active,inactive',
    ], [
        'rss_feed_url.required' => __('RSS Feed URL is required'),
        'rss_feed_url.url' => __('Please enter a valid URL'),
        'channel_id.required' => __('Please select a channel'),
        'topic_id.required' => __('Please select a topic'),
        'sync_interval.required' => __('Sync interval is required'),
        'sync_interval.integer' => __('Sync interval must be an integer'),
        'sync_interval.min' => __('Sync interval must be at least 30 seconds'),
        'data_formate.required' => __('Please select a data format'),
        'status.required' => __('Please select a status'),
        'status.in' => __('Please select a valid status (active or inactive)'),
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $rssFeed->feed_url = $request->rss_feed_url;
    $rssFeed->sync_interval = $request->sync_interval;
    $rssFeed->data_format = $request->data_formate;
    $rssFeed->channel_id = $request->channel_id;
    $rssFeed->topic_id = $request->topic_id;
    $rssFeed->status = $request->status;
    
    $rssFeed->save();
    
    return response()->json(['success' => true, 'message' => 'RSS Feed created successfully.']);
}

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $status = $request->input('feedStatus') ?? '';
    
        try {
        ResponseService::noPermissionThenSendJson('list-rssfeed');
    
            $query = RssFeed::select('rss_feeds.id', 'channels.name as channel_name', 'topics.name as topic_name', 'rss_feeds.feed_url', 'rss_feeds.data_format', 'rss_feeds.sync_interval','rss_feeds.status','channels.id as channels_id','topics.id as topics_id')
                ->join('channels', 'rss_feeds.channel_id', 'channels.id')
                ->join('topics', 'rss_feeds.topic_id', 'topics.id');
            
            if ($status !== '' && $status !== '*') {
                $query->where('rss_feeds.status', $status);
            }
            
            $feeds = $query->get();
            
            return DataTables::of($feeds)
                ->addColumn('action', function ($feed) {

                       return "<a href='" . route('rss-feeds.edit', $feed->id) . "' class='btn text-primary btn-sm edit_btn' data-bs-toggle='modal' data-bs-target='#editRssFeedModal' title='editChannel'>  <i class='fa fa-pen'></i></a> &nbsp; " .
                    "<a href='" . route('rss-feeds.destroy', $feed->id) . "' class='btn text-danger btn-sm delete-form delete-form-reload' data-bs-toggle='tooltip' title='Delete'> <i class='fa fa-trash'></i> </a>";
                })
                ->make(true);
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "CustomFieldController -> show");
            ResponseService::errorResponse('Something Went Wrong');
        }
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
    public function update(Request $request)
    {
        ResponseService::noPermissionThenSendJson('update-rssfeed');
        $request->validate([
            'rss_feed_url' => 'required|url',
            'sync_interval' => 'required',
            'data_formate' => 'required',
            'channel_id' => 'required',
            'topic_id' => 'required',
            'status' => 'required',
        ]);
        $id = $request->id;
        $rssFeed = RssFeed::find($id);
        $rssFeed->feed_url = $request->rss_feed_url;
        $rssFeed->sync_interval = $request->sync_interval;
        $rssFeed->data_format = $request->data_formate;
        $rssFeed->channel_id = $request->channel_id;
        $rssFeed->topic_id = $request->topic_id;
        $rssFeed->status = $request->status;
        $save = $rssFeed->save();

        if($save){
            return redirect()->route('rss-feeds.index')->with('success', 'Rss Feed Updated successfully..!');
        }else{
            return redirect()->back()->with('error', 'Somthing went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            ResponseService::noPermissionThenSendJson('delete-rssfeed');
            RssFeed::find($id)->delete();
            ResponseService::successResponse("Feed deleted Successfully");
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "PlaceController -> destroyCountry");
            ResponseService::errorResponse('Something Went Wrong');
        }
    }

    public function updateStatus(Request $request)
    {
        $channel = RssFeed::find($request->id);

        if($request->status === 'active'){
            $channel->status = 'active';
        }else{
            $channel->status = 'inactive';
        }
        $channel->save();
        if($request->status == 'active'){
            return response()->json(['message' => 'RssFeed Activated']);
        }else{
            return response()->json(['message' => 'RssFeed Inactivated']);
        }
    }

    /* Fetch single feed data  */
    public function singelFeedFetch(Request $request)
    {
        try {
            $id = $request->id;
            
            $feeds = RssFeed::where('id', $id)->get();
            
            if ($feeds->isNotEmpty() && $feeds->first()->status == 'active') {
                
                FetchRssFeedJob::dispatch($feeds);

                return response()->json(['error' => false, 'message' => 'RssFeed fetched Successfully']);
            } else {
                return response()->json(['error' => true, 'message' => 'Please activate before fetching']);
            }
    
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}
