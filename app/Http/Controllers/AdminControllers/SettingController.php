<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Services\ResponseService;
use App\Services\CachingService;
use App\Services\FileService;
use Illuminate\Http\Request;
use App\Models\Setting;
use Throwable;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private string $uploadFolder;
    protected $helperService;

    public function __construct() {
        $this->uploadFolder = 'settings';
    }

    public function index() {
        ResponseService::noAnyPermissionThenRedirect(['list-settings', 'create-settings', 'update-settings', 'delete-settings']);
        return view('admin.settings.index');
    }

    public function page() {
        ResponseService::noPermissionThenSendJson('update-settings');
        $type = last(request()->segments());
        $settings = CachingService::getSystemSettings()->toArray();
        if (!empty($settings['place_api_key']) && config('app.demo_mode')) {
            $settings['place_api_key'] = "**************************";
        }
        $stripe_currencies = ["USD", "AED", "AFN", "ALL", "AMD", "ANG", "AOA", "ARS", "AUD", "AWG", "AZN", "BAM", "BBD", "BDT", "BGN", "BIF", "BMD", "BND", "BOB", "BRL", "BSD", "BWP", "BYN", "BZD", "CAD", "CDF", "CHF", "CLP", "CNY", "COP", "CRC", "CVE", "CZK", "DJF", "DKK", "DOP", "DZD", "EGP", "ETB", "EUR", "FJD", "FKP", "GBP", "GEL", "GIP", "GMD", "GNF", "GTQ", "GYD", "HKD", "HNL", "HTG", "HUF", "IDR", "ILS", "INR", "ISK", "JMD", "JPY", "KES", "KGS", "KHR", "KMF", "KRW", "KYD", "KZT", "LAK", "LBP", "LKR", "LRD", "LSL", "MAD", "MDL", "MGA", "MKD", "MMK", "MNT", "MOP", "MRO", "MUR", "MVR", "MWK", "MXN", "MYR", "MZN", "NAD", "NGN", "NIO", "NOK", "NPR", "NZD", "PAB", "PEN", "PGK", "PHP", "PKR", "PLN", "PYG", "QAR", "RON", "RSD", "RUB", "RWF", "SAR", "SBD", "SCR", "SEK", "SGD", "SHP", "SLE", "SOS", "SRD", "STD", "SZL", "THB", "TJS", "TOP", "TTD", "TWD", "TZS", "UAH", "UGX", "UYU", "UZS", "VND", "VUV", "WST", "XAF", "XCD", "XOF", "XPF", "YER", "ZAR", "ZMW"];
        $languages = CachingService::getLanguages();
        return view('admin.settings.' . $type, compact('settings', 'type', 'languages', 'stripe_currencies'));
    }

    public function store(Request $request) {
        ResponseService::noPermissionThenSendJson('update-settings');
        try {
            $inputs = $request->input();
            unset($inputs['_token']);
            $data = [];
            foreach ($inputs as $key => $input) {
                $data[] = [
                    'name'  => $key,
                    'value' => $input,
                    'type'  => 'string'
                ];
            }
            //Fetch old images to delete from the disk storage
            $oldSettingFiles = Setting::whereIn('name', collect($request->files)->keys())->get();
            foreach ($request->files as $key => $file) {
                $data[] = [
                    'name'  => $key,
                    'value' => $request->file($key)->store($this->uploadFolder, 'public'),
                    'type'  => 'file'
                ];
                $oldFile = $oldSettingFiles->first(function ($old) use ($key) {
                    return $old->name == $key;
                });
                if (!empty($oldFile)) {
                    FileService::delete($oldFile->getRawOriginal('value'));
                }
            }
            Setting::upsert($data, 'name', ['value']);
            CachingService::removeCache(config('constants.CACHE.SETTINGS'));
            ResponseService::successResponse('Settings Updated Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "Setting Controller -> store");
            ResponseService::errorResponse('Something Went Wrong');
        }
    }

    public function updateFirebaseSettings(Request $request) {
        ResponseService::noPermissionThenSendJson('update-settings');
        
        $validator = Validator::make($request->all(), [
            'apiKey'            => 'required',
            'authDomain'        => 'required',
            'projectId'         => 'required',
            'storageBucket'     => 'required',
            'messagingSenderId' => 'required',
            'appId'             => 'required',
            'measurementId'     => 'required',
            'firebase_json_file'=> 'required|file|mimes:json',
        ]);
    
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
    
        try {
            $inputs = $request->input();
            unset($inputs['_token']);
            
            $data = [];
            foreach ($inputs as $key => $input) {
                if ($key != 'firebase_json_file') {
                    $data[] = [
                        'name'  => $key,
                        'value' => $input,
                        'type'  => 'string'
                    ];
                }
            }
    
            Setting::upsert($data, 'name', ['value']);
    
            if ($request->hasFile('firebase_json_file')) {
                $firebaseJson = $request->file('firebase_json_file');
                $fileName = 'firebase_config.json';
                $filePath = 'firebase/' . $fileName;
                $firebaseJson->storeAs('firebase', $fileName, 'local');
                
                // Store the file path in the settings table with 'type' set as 'file'
                Setting::updateOrCreate(
                    ['name' => 'firebase_json_file'],
                    [
                        'value' => $filePath,
                        'type'  => 'file'
                    ]
                );
            }
    
            File::copy(public_path('assets/dummy-firebase-messaging-sw.js'), public_path('firebase-messaging-sw.js'));
            $serviceWorkerFile = file_get_contents(public_path('firebase-messaging-sw.js'));
    
            $updateFileStrings = [
                "apiKeyValue"            => '"' . $request->apiKey . '"',
                "authDomainValue"        => '"' . $request->authDomain . '"',
                "projectIdValue"         => '"' . $request->projectId . '"',
                "storageBucketValue"     => '"' . $request->storageBucket . '"',
                "messagingSenderIdValue" => '"' . $request->measurementId . '"',
                "appIdValue"             => '"' . $request->appId . '"',
                "measurementIdValue"     => '"' . $request->measurementId . '"'
            ];
    
            $serviceWorkerFile = str_replace(array_keys($updateFileStrings), $updateFileStrings, $serviceWorkerFile);
            file_put_contents(public_path('firebase-messaging-sw.js'), $serviceWorkerFile);
    
            CachingService::removeCache(config('constants.CACHE.SETTINGS'));
            
            ResponseService::successResponse('Settings Updated Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "Settings Controller -> updateFirebaseSettings");
            ResponseService::errorResponse();
        }
    }
}
