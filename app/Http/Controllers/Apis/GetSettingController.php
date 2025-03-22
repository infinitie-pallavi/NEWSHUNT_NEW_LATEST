<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use App\Models\Setting;
use Throwable;

class GetSettingController extends Controller
{
    
    public function getSystemSettings(Request $request) {
        try {
            
            $type=['facebook_link','instagram_link','x_link','maintenance_mode','default_language','android_version','ios_version','about_us','privacy_policy','terms_conditions','maintenance_mode'];
            

            $settings = Setting::select(['name', 'value'])
                ->whereIn('name', $type)
                ->get()
                ->map(function ($item) {
                    $item->value = $item->value ?? "";
                    return $item;
                });

            return response()->json([
                'error' => false,
                'message' => 'Get Setting successfully.',
                'data' => $settings
                ]);

        } catch (\Exception $e) {
            ResponseService::logErrorResponse($e, 'Failed to fetch Recomandation posts: ' . $e->getMessage());
            return response()->json([
                'error' => 'Unable to fetch posts at this time. Please try again later.'
            ], 500);
        }
    }
}
