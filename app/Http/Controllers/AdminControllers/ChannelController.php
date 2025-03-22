<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Services\ResponseService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ResponseService::noAnyPermissionThenRedirect(['list-channel', 'create-channel', 'edit-channel', 'delete-channel','update-status-channel']);
        $title = __('CHANNELS');
        $data = compact('title');
        return view('admin.channel.index',$data);
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
    public function store(Request $request, Channel $channel)
    {
        ResponseService::noPermissionThenRedirect('create-channel');
        $request->validate([
                'name'=> 'required',
                'description'=> 'required',
                'logo'=> 'required|max:2000|mimes:jpg,jpeg,png,webp,svg',
                'status'=> 'required'
            ],);

            /* Store the channel logo. */
            $file = $request->file('logo');
            if($file){
                $fileName = rand('0000','9999').$file->getClientOriginalName();
                $path = $file->storeAs('images', $fileName, 'public');
                        storage_path('app/public/' . $path);
            }
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;

            while (Channel::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $channel->name = $request->name;
            $channel->description = $request->description;
            $channel->logo = $fileName;
            $channel->slug = $slug;
            $channel->status = $request->status;
            $save = $channel->save();

            if($save){
                return redirect()->route('channels.index')->with('success', 'channel created successfully.');
            }else{
                return redirect()->back()->with('error', 'Somthing went wrong.');
            }

    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $status = $request->input('channel_status') ?? '';

        try {
            ResponseService::noPermissionThenSendJson('list-channel');
            $query = Channel::select('id', 'name', 'logo as poster_image', 'status','description', 'slug', 'follow_count');
            if ($status !== '' && $status !== '*') {
                $query->where('status', $status);
            }
            $getChannel = $query->get();

            $getChannel->each(function ($channel) {
                $channel->poster_image = asset('storage/images/' . $channel->poster_image);
            });

            return DataTables::of($getChannel)
                ->addColumn('action', function ($getData) {
                    return "<a href='" . route('channels.edit', $getData->id) . "' class='btn text-primary btn-sm edit_btn' data-bs-toggle='modal' data-bs-target='#editChannelModal' title='editChannel'> <i class='fa fa-pen'></i></a> &nbsp; " .
                    "<a href='" . route('channels.destroy', $getData->id) . "' class='btn text-danger btn-sm delete-form delete-form-reload' data-bs-toggle='tooltip' title='Delete'> <i class='fa fa-trash'></i> </a>";
                })
                ->make(true);
        } catch (\Exception $e) {
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
        ResponseService::noPermissionThenRedirect('edit-channel');
        $request->validate([
            'name'=> 'required',
            'description'=> 'required',
            'status'=> 'required'
        ]);
        $file = $request->file('logo');
        $id = $request->id;
        $channel = Channel::find($id);

        if($file){
            $oldImagePath = public_path('images/' . $channel->logo);
                if (file_exists($oldImagePath) && $channel->logo) {
                    unlink($oldImagePath);
                }

            $fileName = rand('0000','9999').$file->getClientOriginalName();
            $path = $file->storeAs('images', $fileName, 'public');
                        storage_path('app/public/' . $path);
        }else
        {
            $fileName = $channel->logo;
        }
        $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;

            while (Channel::where('slug', $slug)->where('id', '!=' ,$id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $channel = Channel::find($id);
            $channel->name = $request->name;
            $channel->description = $request->description;
            $channel->logo = $fileName;
            $channel->slug = $slug;
            $channel->status = $request->status;
            $save = $channel->update();
        if($save){
            return redirect()->route('channels.index')->with('success', 'channel updated successfully.');
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
            ResponseService::noPermissionThenSendJson('delete-channel');
            Channel::find($id)->delete();
            ResponseService::successResponse("Channel deleted Successfully");
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "ChannelControler -> destroyChannel");
            ResponseService::errorResponse('Something Went Wrong');
        }
    }

    public function updateStatus(Request $request)
    {
        ResponseService::noPermissionThenSendJson('update-status-channel');

        $channel = Channel::find($request->id);

        if($request->status === 'active'){
            $channel->status = 'active';
        }else{
            $channel->status = 'inactive';
        }
        $channel->save();
        if($request->status == 'active'){
            return response()->json(['message' => 'Channel Activated']);
        }else{
            return response()->json(['message' => 'Channel Inactivated']);
        }
    }

}
