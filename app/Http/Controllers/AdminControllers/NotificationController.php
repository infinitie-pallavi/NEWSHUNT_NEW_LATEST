<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Admin\Notifications as AdminNotifications;
use App\Models\User;
use App\Services\CachingService;
use App\Services\FileService;
use App\Services\NotificationService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;
use App\Models\UserFcm;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

const SOMETHING_WENT_WRONG = 'Something Went Wrong';
class NotificationController extends Controller
{
    private string $uploadFolder;

    public function __construct() {
        $this->uploadFolder = "notification";
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         ResponseService::noAnyPermissionThenRedirect(['list-notification', 'create-notification', 'update-notification', 'delete-notification']);

        return view('admin.notification.index');
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
    public function store(Request $request)
    {
        ResponseService::noPermissionThenSendJson('notification-create');
        $validator = Validator::make($request->all(), [
            'file'    => 'image|mimes:jpeg,png,jpg',
            'send_to' => 'required|in:all,selected',
            'user_id' => 'required_if:send_to,selected',
            'title'   => 'required',
            'message' => 'required',
        ],
            [
                'user_id' => [
                    'required_if' => __("Please select at least one user")
                ]
            ]
        );

        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            $get_fcm_key = CachingService::getSystemSettings('fcm_key');
            if (!empty($get_fcm_key->data)) {
                ResponseService::errorResponse('Server FCM Key Is Missing');
            }
            $notification = AdminNotifications::create([
                ...$request->all(),
                'image'   => $request->hasFile('file') ? FileService::compressAndUpload($request->file('file'), $this->uploadFolder) : '',
                'user_id' => $request->send_to == "selected" ? $request->user_id : ''
            ]);

            $fcm_ids = $this->retrieveAndValidateFcmIds($request->send_to, $request->user_id);
            if (!empty($fcm_ids)) {
                
                $registrationIDs = array_filter($fcm_ids);
                NotificationService::sendFcmNotification((array)$registrationIDs, $request->title, $request->message, "notification", [
                    "image"   => $notification->image,
                    "item_id" => $notification->item_id,
                ]);
            }
            ResponseService::successResponse('Message Send Successfully');

        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, 'NotificationController -> store');
            ResponseService::errorResponse(SOMETHING_WENT_WRONG);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        ResponseService::noPermissionThenSendJson('list-notification');
        try{
        $getData = AdminNotifications::where('id', '!=', 0)->orderBy('id', 'DESC')->get();
        
        return DataTables::of($getData)
            ->addColumn('action', function ($getData) {
                return "<a href='" . route('notification.destroy', $getData->id) . "' class='btn text-danger btn-sm delete-form delete-form-reload' data-bs-toggle='tooltip' title='Delete'> <i class='fa fa-trash'></i> </a>";
            })
            ->make(true);
        
        }catch(Throwable $e){
            ResponseService::logErrorResponse($e, 'NotificationController -> show');
            ResponseService::errorResponse(SOMETHING_WENT_WRONG);
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
       //
   }
   /**
    * Remove the specified resource from storage.
    */
    public function destroy($id) {
        try {
            ResponseService::noPermissionThenSendJson('delete-notification');
            $notification = AdminNotifications::findOrFail($id);
            $notification->delete();
            FileService::delete($notification->getRawOriginal('image'));
            return ResponseService::successResponse('Notification Deleted Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, 'NotificationController -> destroy');
            return ResponseService::errorResponse(SOMETHING_WENT_WRONG);
        }
    }

   private function retrieveAndValidateFcmIds($sendTo, $userId) {
    $fcm_ids = [];
    if ($sendTo == "all") {
        // Use distinct to get unique FCM IDs
        $fcm_ids = UserFcm::whereNotNull('fcm_id')->distinct()->pluck('fcm_id')->toArray();
    } elseif ($sendTo == "selected" && !empty($userId)) {
        // Ensure you are getting the correct user and their FCM ID
        $fcm_ids = UserFcm::where('user_id', $userId)->pluck('fcm_id')->toArray();
    }
    
    // Use array_unique to ensure no duplicates
    return array_unique(array_filter($fcm_ids));
}
    public function batchDelete(Request $request) {
        ResponseService::noPermissionThenSendJson('delete-notification');
        try {
            $ids = explode(',', $request->id);
            foreach (AdminNotifications::whereIn('id', $ids)->get() as $notification) {
                $notification->delete();
                FileService::delete($notification->getRawOriginal('image'));
            }
            return ResponseService::successResponse("Notifications Deleted Successfully");
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "NotificationController -> batchDelete");
            return ResponseService::errorResponse(SOMETHING_WENT_WRONG);
        }
    }

    public function sendTestNotification(Request $request) {
        $request->validate([
            'fcm_token' => 'required|array',
            'title' => 'required|string',
            'message' => 'required|string',
        ]);
        try {
            $fcmTokens = $request->input('fcm_token');
            $title = $request->input('title');
            $message = $request->input('message');
            // Prepare custom data fields if any
            $customData = [
                'extra_data' => 'This is a test notification',
            ];
            
            $result = NotificationService::sendFcmNotification(
                $fcmTokens,
                $title,
                $message,
                'notification',
                $customData
            );
            return response()->json([
                 'error'=>'false',
                'message' => 'Notification sent successfully',
                'result' => $result,
            ]);
        } catch (Throwable $e) {
            Log::error('Error sending test FCM notification:', ['error' => $e->getMessage()]);
            return response()->json([ 'error'=>'true', 'message' => $e->getMessage()], 500);
        }
    }

    public function userListNofification() {
        try{
              $users = User::get();

              $users->each(function ($channel) {
                $channel->mobile = $channel->country_code.' '.$channel->mobile;
            });
            return DataTables::of($users)->make(true);
        }catch(Throwable $e){
            ResponseService::logErrorResponse($e, 'NotificationController -> userListNotification');
            ResponseService::errorResponse(SOMETHING_WENT_WRONG);
        }
    }
}
