<?php
namespace App\Services;

use Exception;
use Throwable;
use Google\Client;
use App\Models\Setting;
use App\Models\Admin\Notifications;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Facebook\WebDriver\Exception\Internal\RuntimeException as InternalRuntimeException;

class SendNotification {
     /**
     * Sends FCM notification to specified registration IDs.
     *
     * @param array $registrationIDs
     * @param string|null $title
     * @param string|null $message
     * @param string $type
     * @param array $customBodyFields
     * @return false|mixed
     */
    protected $messaging;

    public function sendPostNotification(array $fcmIDs, string $title = '',string $description = '', string $slug = '', string $image_url = '', string $type = 'default') {
        try {
            // Ensure registrationIDs is an array
            if (!is_array($fcmIDs)) {
                throw new \InvalidArgumentException('registrationIDs must be an array');
            }
            $projectId = Setting::where('name', 'firebase_project_id')->pluck('value')->first();
            $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
            $access_token = self::getDefaultAccessToken();
            if (!$access_token) {
                throw new \InvalidArgumentException('Unable to retrieve access token');
            }

            $news = Post::where('slug', $slug)->with('channel')->first();
            $channel_logo = asset('storage/images/' . $news->channel->logo) ??  asset('default-logo.png');
            $channel_name = $news->channel->name ??  "";
            $results = [];
            foreach ($fcmIDs as $fcmID) {
                $data = [
                    'message' => [
                        'token' => $fcmID['fcm_id'],
                        'data' => [
                            'title' => (string) $title,
                            'body' => (string) $description,
                            'slug' => (string) $slug,
                            'image' => (string) $image_url,
                            'channel_logo' => (string) $channel_logo,
                            'channel_name' => (string) $channel_name,
                            'notification_id' => (string) uniqid('notif_', true),
                            'timestamp' => (string) time(),
                            'type' => (string) $type,
                            'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
                        ],
                        'apns' => [
                            'headers' => [
                                'apns-priority' => '10',
                            ],
                            'payload' => [
                                'aps' => [
                                    'alert' => [
                                        'title' => $title,
                                        'body' => $slug
                                    ],
                                    'sound' => 'default',
                                    'badge' => 1,
                                    'content-available' => 1,
                                ]
                            ]
                        ]
                    ]
                ];
                
                
                $response = self::sendDefaultFcmRequest($url, $access_token, $data);
            $exist = Notifications::where('slug',$slug)->first();
                if($exist == ""){

                    $notify_data = [
                        'title'=>$title,
                        'slug'=>$slug,
                        'image'=>$image_url,
                        'channel_logo' => $channel_logo,
                        'channel_name' => $channel_name
                    ];
                    Notifications::create($notify_data);
                }
                    $results[] = $response;
            }
            return $results;
        } catch (Throwable $th) {
            Log::error('FCM Notification Error:', ['error' => $th->getMessage()]);
            return null;
        }
    }


    private static function sendDefaultFcmRequest($url, $access_token, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        if ($response === false) {
            throw new InternalRuntimeException('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }

    public static function getDefaultAccessToken() {
        try {
            $file_name = Setting::select('value')->where('name', 'service_file')->pluck('value')->first();
            $file_path = base_path('public/storage/' . $file_name);
            $client = new Client();
            $client->setAuthConfig($file_path);
            $client->setScopes(['https://www.googleapis.com/auth/firebase.messaging']);
            $token = $client->fetchAccessTokenWithAssertion();
            return $token['access_token'] ?? null;
        } catch (Exception $e) {
            throw new InternalRuntimeException($e->getMessage());
        }
    }
    
}
