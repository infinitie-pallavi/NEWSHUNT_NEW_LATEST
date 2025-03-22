<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicFrontController extends Controller
{
    public function index(){
        $perPage = 16;
    
        $front_topics = Topic::select('*')->where('status','active')->has('posts')->paginate($perPage);
        $title = 'Topics' ?? 'Posts';
        $theme = getTheme();
        $data = compact('title', 'theme', 'front_topics');
        return view('front_end/' . $theme . '/pages/topics', $data);
    }   
}
