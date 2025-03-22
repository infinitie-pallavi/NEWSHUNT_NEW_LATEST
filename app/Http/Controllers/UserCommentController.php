<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Services\ResponseService;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Throwable;

class UserCommentController extends Controller
{
    
    public function show($postId)
{
   $comments = Comment::with('user', 'replies.user')
    ->where('post_id', $postId)
    ->whereNull('parent_id')->orderBy('id','DESC')
    ->get();
    $commentCount = Comment::where('post_id', $postId)->count();
    return response()->json([
        'comments' => $comments,
        'count' => $commentCount,
    ]);
}

public function store(Request $request)
{
    try {
        $request->validate([
            'comment' => 'required',
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
            'parent_id' => $request->parent_id,
            'comment' => $request->comment,
        ]);
        $post = Post::find($request->post_id);
        $post->increment('comment');
        $comment->load('user');

        return response()->json(['success' => true, 'message' => "Comment stored successfully.", 'comment' => $comment]);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->validator->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function update(Request $request){
    try {
        $request->validate([
            'comment' => 'required',
            'id' => 'required',
        ]);
        
        $comment = Comment::find($request->id);
        $comment->comment = $request->comment;
        $comment->update();

        if($comment){
                $message ="Comment update successfully.";
            }else{
                $message ="record not found...!";
        }
        $comment->load('user');


        return response()->json(['success' => true, 'message' => $message, 'comment' => $comment]);
    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->validator->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
    }

    public function destroy($id){
        try {

            $comment = Comment::find($id);
            
            if ($comment) {
                
                Comment::where('parent_id', $id)->delete();
                $comment->delete();
                
                $post = Post::find($comment->post_id);
            
            if ($post) {
                $post->decrement('comment');
            }
                ResponseService::successResponse("Comment deleted Successfully");
            }else{
                ResponseService::errorResponse('No Comment found');
            }
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "ChannelControler -> destroyChannel");
            ResponseService::errorResponse('Something Went Wrong');
        }
    }   
}