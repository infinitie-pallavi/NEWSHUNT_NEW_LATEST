<?php
namespace App\Services;
use App\Models\Setting;
use Facebook\WebDriver\Exception\Internal\RuntimeException as InternalRuntimeException;
use Google\Client;
use Google\Exception;
use RuntimeException;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Exception\RuntimeException as ExceptionRuntimeException;
use Throwable;
class NotificationService {
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
   public static function sendFcmNotification(array $registrationIDs, string $title = '', string $message = '', string $type = 'default', array $customBodyFields = []) {
    try {
        $project_id = Setting::where('name', 'firebase_project_id')->pluck('value')->first();
        $url = "https://fcm.googleapis.com/v1/projects/{$project_id}/messages:send";
        $access_token = self::getAccessToken();
        if (!$access_token) {
            throw new InternalRuntimeException('Unable to retrieve access token');
        }
        $results = [];
        foreach ($registrationIDs as $registrationID) {
            $data = [
                'message' => [
                    'token' => $registrationID,
                    'notification' => [
                        'title' => $title,
                        'body' => $message,
                    ],
                    'data' => array_merge($customBodyFields, [
                        'title' => $title,
                        'body' => $message,
                        'type' => $type
                    ]),
                    'android' => [
                        'notification' => [
                            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                            'title' => $title,  // Optional: Android-specific title override
                            'body' => $message,  // Optional: Android-specific body override
                        ],
                        'data' => [
                            'title' => $title,
                            'body' => $message,
                            'type' => $type,  // Custom data field
                        ],
                    ],
                    'apns' => [
                        'headers' => [
                            'apns-priority' => '10',
                        ],
                        'payload' => [
                            'aps' => [
                                'alert' => [
                                    'title' => $title,  // iOS-specific title
                                    'body' => $message,  // iOS-specific body
                                ],
                                'sound' => 'default',  // Notification sound for iOS
                            ],
                        ],
                    ],
                ],
            ];
            Log::info('FCM Request Data:', ['data' => $data]); // Log request data
            $response = self::sendFcmRequest($url, $access_token, $data);
            Log::info('FCM Response:', ['response' => $response]); // Log response
            $results[] = json_decode($response, true);
        }
        return $results;
    } catch (Throwable $th) {
        Log::error('FCM Notification Error:', ['error' => $th->getMessage()]); // Log error
        throw new ExceptionRuntimeException($th->getMessage());
    }
}
    private static function sendFcmRequest($url, $access_token, $data) {
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
    /**
     * Retrieves access token for Firebase API.
     *
     * @return string|null
     * @throws RuntimeException
     */
    public static function getAccessToken() {
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
