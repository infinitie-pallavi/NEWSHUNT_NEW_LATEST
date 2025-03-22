<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Setting;
use Carbon\Carbon;

class FooterController extends Controller
{
    /*
    *
    *Privacy & Policy
    */
    public function privacyEndPolicy() {
        $title = 'privacy-policy';
        $privacyPolicy = Setting::select('name', 'value', 'updated_at')
            ->where('name', 'privacy_policy')
            ->first();
    
        // Attempt to read property "updated_at" on null
        if (!$privacyPolicy) {
            $privacyPolicy = new Setting();
            $privacyPolicy->value = 'Privacy Policy not set';
            $privacyPolicy->updated_at = Carbon::now();
        }

        $privacyPolicy->updated_at = Carbon::parse($privacyPolicy->updated_at)->diffForHumans();
        $theme = getTheme();
        $data = compact('title','privacyPolicy','theme');
        return view('front_end/' .$theme. '/pages/privacy', $data);
    }
    /*
     *
     *Term & Conditions
     *
     */
    public function termsAndCondition()
    {
        $title = 'terms-of-use';

        $termsOfCondition = Setting::select('name', 'value', 'updated_at')
        ->where('name', 'terms_conditions')
        ->first();
        $theme = getTheme();
    $data = compact('title','termsOfCondition','theme');
    return view('front_end/' .$theme. '/pages/terms_and_condition', $data);
    }
}
