<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Admin\Notifications as AdminNotifications;
use App\Models\ReadNotification;
use App\Models\UserFcm;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class NotificationController extends Controller
{

    const STORAGE_PATH = 'storage/images/';


    public function getNotificationList()
    {
        $perPage = request()->get('per_page', 10);
        $fcmId = request()->get('fcm_id', null);
        
        $getReadNotificaiton = ReadNotification::select('notification_id')
    ->where('fcm_id', $fcmId)
    ->pluck('notification_id')
    ->toArray();

// Fetch notifications with the necessary joins
$data = AdminNotifications::select(
        'notifications.id',
        'notifications.slug',
        'channels.logo',
        'notifications.title',
        'notifications.message',
        'notifications.image',
        'notifications.created_at'
    )
    ->leftJoin('posts', 'notifications.slug', '=', 'posts.slug')
    ->leftJoin('channels', 'posts.channel_id', '=', 'channels.id')
    ->where('send_to', 'all')
    ->orderBy('notifications.created_at', 'desc')
    ->paginate($perPage);

// Prepare the notifications array
$notifications = [];
foreach ($data as $notification) {
    $notifications[] = [
        'id' => $notification->id,
        'isRead' => in_array($notification->id, $getReadNotificaiton) ? 1 : 0,
        'channel_logo' => $notification->logo ? url(self::STORAGE_PATH . $notification->logo) : "",
        'slug' => $notification->slug,
        'title' => $notification->title,
        'message' => $notification->message,
        'image' => $notification->image,
        'created_at' => Carbon::parse($notification->created_at)->diffForHumans(),
    ];
}
        $dataCount = $data->count();
        return response()->json([
            'error' => false,
            'message' => 'Data fetched successfully.',
            'data' => [
                'isAllRead' => count($getReadNotificaiton) == $dataCount ? false : true,
                'notification' => $notifications
            ],
           
        ]);
    }

/* Store Fcm id */
    public function storeOnlyFcm(Request $request){
       
        $validator = Validator::make($request->all(), [
            'fcmId'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Fcm id validation error',
                'data' => "",
            ], 422);
        }
        
        $userFcmId = UserFcm::where('fcm_id',$request->fcmId)->first();
        if(empty($userFcmId)){
            UserFcm::create([
                'user_id' =>"",
                'fcm_id' =>$request->fcmId
            ]);
            $message = 'Fcm id store successfully.';
        }else{
            $message = 'Already stored.';
        }
        

        return response()->json([
            'error' => false,
            'message' => $message,
            'data' => [
                'fcm_id' => $request->fcmId
            ],
           
        ]);
    }
}
