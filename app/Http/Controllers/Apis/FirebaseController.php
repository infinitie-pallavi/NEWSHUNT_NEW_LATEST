<?php

namespace App\Http\Controllers\Apis;

use libphonenumber\NumberParseException;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use libphonenumber\PhoneNumberUtil;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use App\Models\UserFcm;
use Exception;

class FirebaseController extends Controller
{
    protected function base64UrlDecode($input) {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $input .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

    protected function decodeJWT($jwt) {
        $tokenParts = explode('.', $jwt);
        if (count($tokenParts) !== 3) {
            throw new AuthenticationException('Invalid JWT token structure');
        }
        $payload = $this->base64UrlDecode($tokenParts[1]);
        
        return json_decode($payload, true);
    }
                    
    public function firebaseTokenverify(Request $request)
    {
        try {

            $token = $request->token;

            // Decode the Firebase ID token without signature verification
            $userData = $this->decodeJWT($token);
            if (!$userData) {
                throw new AuthenticationException('Failed to decode token');
            }

            // Log the decoded token for debugging purposes
            // Log::info('Decoded token payload: ' . json_encode($userData));
            
            if(isset($userData['email'])){

                if (!isset($userData['sub']) || !isset($userData['email'])) {
                    Log::error('Decoded token does not contain required fields: ' . json_encode($userData));
                    throw new AuthenticationException('Token missing required fields');
                }
            }elseif(isset($userData['phone_number'])){

                 if (!isset($userData['sub']) || !isset($userData['phone_number'])) {
                    Log::error('Decoded token does not contain required fields: ' . json_encode($userData));
                    throw new AuthenticationException('Token missing required fields');
                }
            }

           if(isset($userData['email'])){
               
            $userData = [
                'uid' => $userData['sub'],
                'type' => 'google',
                'fcm_id' => $request->fcm_id ?? "",
                'email' => $userData['email'],
                'name' => isset($userData['name']) && !empty($userData['name']) ? $userData['name'] : "Unknown User",                
                ];

           }elseif(isset($userData['phone_number']))
           {
              
               $phone_nuber =  $this->separatePhoneNumber($userData['phone_number']);
               
            $userData = [
                'uid' => $userData['sub'],
                'fcm_id' => $request->fcm_id,
                'type' => 'mobile',
                'phone_number' => $phone_nuber['phone_number'],
                'country_code' => $phone_nuber['country_code'],
                'name' => $phone_nuber['name'] ?? "Unknown User",
                ];
           }
           // Process user data
           if(isset($userData['email'])){
                $user = $this->findOrCreateEmail($userData);
            }elseif(isset($userData['phone_number'])){
                $user = $this->findOrCreatePhone($userData);
            }
            $user->assignRole('user');
            $token = $user->createToken('AuthToken')->plainTextToken;
            return response()->json([
                                    'error' => false,
                                    'message' => $user->wasRecentlyCreated ? 'New User Registed.' : 'User login successfylly.',
                                    'data' => [
                                        'newsUser'=> $user->wasRecentlyCreated ? true : false,
                                        'token'=> $token,
                                        'user' => $user
                                        ]
                                    ]);

        } catch (\Exception $e) {
            Log::error('Token verification failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Token verification failed: ' . $e->getMessage(),
            ], 401);
        }
    }

    protected function findOrCreateEmail($userData)
    {
        $user = User::where('email', $userData['email'])->first();

        if (!$user) {
            $user = User::create([
                'name' => !empty($userData['name']) ? $userData['name'] : "Unknown User",

                'email' => $userData['email'],
                'type' => $userData['type'],
                'fcm_id' => $userData['fcm_id'],
                'password' => Hash::make(rand(100000, 999999)),
            ]);
        }
        $userFcmId = UserFcm::where('fcm_id',$userData['fcm_id'])->first();
        if(empty($userFcmId)){
                UserFcm::create([
                    'user_id' =>$user->id,
                    'fcm_id' =>$userData['fcm_id']
                ]);
            }
        return $user;
    }

    protected function findOrCreatePhone($userData)
    {
        $user = User::where('mobile', $userData['phone_number'])->first();

        if (!$user) {
            $user = User::create([
                'name' => isset($userData['name']) && !empty($userData['name']) ? $userData['name'] : "Unknown User",
                'email' => $userData['email']?? 'user'.rand(1000, 9999).'@gmail.com',
                'mobile' => $userData['phone_number'],
                'type' => $userData['type'],
                'fcm_id' => $userData['fcm_id'],
                'country_code' => $userData['country_code'],
                'password' => Hash::make(rand(100000, 999999)),
               
            ]);
        }

        $userFcmId = UserFcm::where('fcm_id',$userData['fcm_id'])->get();
            if(!empty($userFcmId)){
                UserFcm::create([
                    'user_id' =>$user->id,
                    'fcm_id' =>$userData['fcm_id']
                ]);
            }
        return $user;
    }

    /* To saprate the phone number and country code */
    protected function separatePhoneNumber($phoneNumber)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            $numberProto = $phoneUtil->parse($phoneNumber, null);

            $countryCode = $numberProto->getCountryCode();
            $nationalNumber = $numberProto->getNationalNumber();

            return [
                'country_code' => '+' . $countryCode,
                'phone_number' => $nationalNumber,
            ];
        } catch (NumberParseException $e) {
            return [
                'error' => 'Invalid phone number format',
            ];
        }
    }
}
