<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\ReportComment;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class ReportCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Reported Comments";
        return view('admin.comment.report-index',compact('title'));
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
        try{
        $getData =  ReportComment::select('report_comments.id','users.name','report','comments.comment','report_comments.created_at')
        ->join('users', 'report_comments.user_id', 'users.id')
        ->join('comments', 'report_comments.comment_id', 'comments.id')->get();
        
        return DataTables::of($getData)
        ->addColumn('action', function ($getData) {
            return"<a href='javascript:void(0);' class='btn text-danger btn-sm' id='delete_report_comment' data-bs-toggle='tooltip' data-comment-id='$getData->id' title='Delete'> <i class='fa fa-trash'></i> </a>";
        })
        ->make(true);
    } catch (Throwable $e) {
        ResponseService::logErrorResponse($e, "UserController -> show");
        return ResponseService::errorResponse('Something Went Wrong');
    }
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
        if (Auth::check()) {

        $commentId = ReportComment::find($id);
        /* Delete Child Comment */
            if($id){
                $this->deleteChildComment($commentId->comment_id);
            }

            $comments = Comment::find($commentId->comment_id);
            if($comments){
                $post = Post::find($comments['post_id']);
                $comments->delete();
                    if($post->comments > 0){
                        $post->decrement('comment');
                    }
                    $commentId->delete();
                $message = 'Comment Deleted Successfully.';
            
            }else{
                $message = 'Comment not found.';
            }

        } else {
            $message = 'Unauthorized user.';
        }
        
        return response()->json([
            'error' => false,
            'message' => $message,
            'comment_id' => $id ?? ""
        ]);

    }

    /* Delete Parent Comment */
    public function deleteChildComment($commentId){
        $comments = Comment::where('parent_id',$commentId)->orderBy('id','desc')->get()->toArray();
        if($comments){
            foreach($comments as $comment){
                
                $post = Post::find($comment->post_id);

                        $comment->delete();
                        if($post->comment > 0){
                            $post->decrement('comment');
                        }
            }
            $message = "parent comment deleted successfully";
        }else{
            $message = "parent comment not found";
        }
            return $message;
    }

}
