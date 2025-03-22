<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ResponseService::noAnyPermissionThenRedirect(['list-topic', 'create-topic', 'update-topic', 'delete-topic']);
        $title = __('TOPICS');
        return view('admin.topic.index', compact('title'));
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
    public function store(Request $request, Topic $topic)
    {
        ResponseService::noPermissionThenSendJson('create-topic');
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'logo' => 'required|max:2000|mimes:jpg,jpeg,png,webp,svg'

        ]);

        /* Store the channel logo. */
        $file = $request->file('logo');
        if ($file) {
            $fileName = rand('0000', '9999') . $file->getClientOriginalName();
            $file->storeAs('images', $fileName, 'public');
        }

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;

        while (Topic::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $topic->name = $request->name;
        $topic->slug = $slug;
        $topic->logo = $fileName;
        $topic->status = $request->status;
        $save = $topic->save();
        if ($save) {
            return response()->json(['success' => true, 'message' => 'topic crated successfully.']);
        } else {
            return redirect()->back()->with('error', 'Somthing went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $status = $request->input('status') ?? '';
        try {
            ResponseService::noPermissionThenSendJson('list-topic');

            $getPosts = Topic::select('id', 'logo', 'name', 'slug', 'status')
                ->when($status !== '' && $status !== '*', function ($query) use ($status) {
                    $query->where('status', $status);
                })
                ->get()
                ->map(function ($item) {
                    if (empty($item->logo)) {
                        $item->logo = asset('assets/images/no_image_available.png');
                    } else {
                        $item->logo = asset('storage/images/' . $item->logo);
                    }
                    return $item;
                });

            return DataTables::of($getPosts)
                ->addColumn('action', function ($getData) {

                    return "<a href='" . route('topics.edit', $getData->id) . "' class='btn text-primary btn-sm edit_btn' data-bs-toggle='modal' data-bs-target='#editTopicModal' title='editTopic'> <i class='fa fa-pen'></i></a> &nbsp; " .
                        "<a href='" . route('topics.destroy', $getData->id) . "' class='btn text-danger btn-sm delete-form delete-form-reload' data-bs-toggle='tooltip' title='Delete'> <i class='fa fa-trash'></i> </a>";
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
    public function update(Request $request, string $id)
    {
        ResponseService::noPermissionThenSendJson('update-topic');
        $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);

        $file = $request->file('logo');
        $topic_id = $request->id;
        $topic = Topic::find($topic_id);
        if ($file) {
            $oldImagePath = public_path('images/' . $topic->logo);
            if (file_exists($oldImagePath) && $topic->logo) {
                unlink($oldImagePath);
            }

            $fileName = rand('0000', '9999') . $file->getClientOriginalName();
            $file->storeAs('images', $fileName, 'public');
        } else {
            $fileName = $topic->logo;
        }


        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;

        while (Topic::where('slug', $slug)->where('id', '!=', $topic_id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $topic->name = $request->name;
        $topic->slug = $slug;
        $topic->logo = $fileName;
        $topic->status = $request->status;
        $save = $topic->update();

        if ($save) {
            return response()->json(['success' => true, 'message' => 'topic updated successfully.']);
        } else {
            return redirect()->back()->with('error', 'Somthing went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            ResponseService::noPermissionThenSendJson('delete-topic');
            Topic::find($id)->delete();
            ResponseService::successResponse("Topic deleted Successfully");
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "PlaceController -> destroyCountry");
            ResponseService::errorResponse('Something Went Wrong');
        }
    }

    public function updateStatus(Request $request)
    {

        ResponseService::noPermissionThenSendJson('topic-stsus-update');
        $channel = Topic::find($request->id);

        if ($request->status === 'active') {
            $channel->status = 'active';
        } else {
            $channel->status = 'inactive';
        }
        $channel->save();
        if ($request->status == 'active') {
            return response()->json(['message' => 'Topic Activated']);
        } else {
            return response()->json(['message' => 'Topic Inactivated']);
        }
    }
}
