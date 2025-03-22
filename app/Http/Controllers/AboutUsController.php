<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Carbon\Carbon;

class AboutUsController extends Controller
{
    public function index(){
        $title = 'About us';
        $about_us = Setting::select('name', 'value', 'updated_at')
            ->where('name', 'about_us')
            ->first();
    
        if (!$about_us) {
            $about_us = new Setting();
            $about_us->value = "About us not set";
            $about_us->updated_at = Carbon::now();            
        }  

        $about_us->updated_at = Carbon::parse($about_us->updated_at)->diffForHumans();
        $theme = getTheme();
        $data = compact('title','about_us','theme');
        return view('front_end/' . $theme . '/pages/about-us', $data);
    }
}
