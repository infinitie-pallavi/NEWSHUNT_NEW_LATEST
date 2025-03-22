<?php

namespace App\Http\Controllers;

use App\Models\AppPostView;
use App\Models\Channel;
use App\Models\ChannelSubscriber;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Post;
use App\Models\PostView;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Throwable;

class UserLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showLoginForm()
    {
        $title = 'Login';
        $theme = getTheme();
        return view('front_end/' . $theme . '/pages/user-login',compact('theme','title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changeProfileUpdate(Request $request) {
        try {


            $user_id = Auth::user()->id;
            $user = User::find($user_id);
            
            $user->name = $request->name;
            if(isset($request->password)){
                $password = Hash::make($request->password);
                $user->password = $password;
            }
    
            if ($request->hasFile('profile')) {
                if ($user->profile && Storage::exists('public/' . $user->profile)) {
                    Storage::delete('public/' . $user->profile);
                }
    
                $logoPath = $request->file('profile')->store('profile_images', 'public');
                $user->profile = $logoPath;
            }
            $user->update();
    
            return response()->json(['error' => false, 'message' => "Profile Updated Successfully"]);
        } catch (Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
    
    

    public function login(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => false, 'message' => 'Please enter valid Email']);
        }else{
            $userCheck = User::where('email', $request->email)->first();

            if (!$userCheck) {
                return response()->json(['error' => true, 'message' => 'Please enter valid Email', 'data' => 'email']);
            } else {
                return response()->json(['error' => true, 'message' => 'Please enter valid Password', 'data' => 'password']);
            }
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->back();
    }
    
    public function deleteAccount(Request $request){
        $user_id = Auth::user()->id ?? null;
        
        if($user_id != null){
    
            PostView::where('user_id',$user_id)->delete();
    
            $bookmarks = Favorite::where('user_id',$user_id)->get();
            foreach($bookmarks as $bookmark){
                $post = Post::find($bookmark->post_id);
                
                $post->decrement('favorite');
                $bookmark->delete();
            }
    
            $channelList = ChannelSubscriber::where('user_id',$user_id)->get();
            if($channelList){
                foreach($channelList as $channel){
                    $channelProfile = Channel::find($channel->channel_id);
                    $channelProfile->subscribers()->detach($user_id);
                    $channelProfile->decrement('follow_count');
                }
            }
            
            $comments = Comment::where('user_id',$user_id)->orderBy('id','desc')->get();
            if($comments){
                foreach($comments as $comment){
                    $post = Post::find($comment->post_id);
                    $comment->delete();
                    if($post->comment > 0){
                        $post->decrement('comment');
                    }
                }
            }
        }
        if($user_id != 1){
            $user = User::find($user_id);
            $user->forceDelete();
        }
        
        return response()->json([
            'error' => false,
            'message' => 'User removed successfully.'
        ]);
    }
}
