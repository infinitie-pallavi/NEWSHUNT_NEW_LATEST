<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\NewsHuntSubscriber;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class NewsHuntSubscriberController extends Controller
{

    public function index(){
        try{
            $theme = getTheme();
            $title = "Subscribers";
            return view('admin.subscriber.news-hunt-subscribers',compact('theme','title'));
        }catch(\Exception $e){
            return"";
        }
    }
    
    public function show(){
        $data = NewsHuntSubscriber::select('id','email')->get();
        
        return DataTables::of($data)->make(true);
    }


    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:news_hunt_subscribers,email',
        ]);

        $subscriber = new NewsHuntSubscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        $cookie = cookie('subscriber_email_', $request->email, 21600);

        return redirect()->back()->withCookie($cookie);
    }

}
