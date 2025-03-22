<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\ReportComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserCommentController extends Controller
{
    const COMMENT_VALIDATION = 'required|string|max:500';

    
    public function store(Request $request)
    {
        $request->validate([
            'comment' => self::COMMENT_VALIDATION,
            'post_id' => 'required|exists:posts,id',
            'replay_id' => 'nullable|exists:comments,id',
        ]);

        $user = Auth::user();

        if ($user) {
            $comment = Comment::create([
                'user_id' => $user->id,
                'post_id' => $request->post_id,
                'parent_id' => $request->replay_id,
                'comment' => $request->comment,
            ]);

            $post = Post::find($request->post_id);
            $post->increment('comment');

            $comment->load('user');

            $data = [
                'post_id' => $request->post_id,
                'parent_id' => $request->replay_id ?? '0',
                'comment' => $request->comment,
                'status' => '1'
            ];

            return response()->json([
                'error' => false,
                'message' => "Comment store successfully.",
                'data' => $data
            ], 200);
        } else {

            $data = [
                'post_id' => $request->post_id,
                'parent_id' => $request->replay_id ?? '0',
                'comment' => $request->comment,
                'status' => '0'
            ];

            return response()->json([
                'error' => false,
                'message' => "Unauthorized user..",
                'data' => $data
            ], 201);
        }
    }

    public function show($id)
    {
        $postId = $id;
        $perPage = request()->get('per_page', 3);

        try {

            $parentComments = Comment::with('user')
                ->where('post_id', $postId)
                ->whereNull('parent_id')
                ->orderBy('id', 'desc')
                ->paginate($perPage);


            $parentCommentIds = $parentComments->pluck('id')->toArray();

            $replies = Comment::with('user')
                ->where('post_id', $postId)
                ->whereIn('parent_id', $parentCommentIds)
                ->orderBy('id', 'desc')
                ->get();

            $commentsById = [];
            $organizedComments = [];
            // Why?
            $defaultProfileImage = url('public/front_end/classic/images/default/profile-avatar.jpg');

            foreach ($parentComments as $comment) {

                $userProfileImage = $comment->user->profile ?? $defaultProfileImage;

                $commentData = [
                    'id' => $comment->id,
                    'text' => $comment->comment,
                    'created_at' => Carbon::parse($comment->created_at)->diffForHumans(),
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                        'profile' => $userProfileImage
                    ],
                    'replies' => 0
                ];
                $commentsById[$comment->id] = $commentData;
            }

            // Attach replies count to each parent comment
            foreach ($replies as $reply) {
                if (isset($commentsById[$reply->parent_id])) {
                    $commentsById[$reply->parent_id]['replies']++;
                }
            }

            // Reorganize comments by parent structure
            $organizedComments = array_values($commentsById);
            $count = Comment::where('post_id', $postId)->count();
            // Prepare response
            $response = [
                "error" => false,
                "message" => "Comments fetched successfully",
                "data" => [
                    'count'=> $count,
                    'comment'=> $organizedComments
                ],
            ];

            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, "message" => $th->getMessage(), "data" => ["detailed_error" => $th]]);
        }

    }

    // Take this for reference
    public function replayShow($postId, $parentId)
    {
        $page = request()->get('page', 1);
        $perPage = request()->get('per_page', 10);
        $offset = ($page - 1) * $perPage;

        try {
            $comments = Comment::with('user')
                ->where('post_id', $postId)
                ->where('parent_id', $parentId)
                ->orderBy('id', 'desc')
                ->offset($offset)
                ->limit($perPage)
                ->get();

            $commentsById = [];
            $defaultProfileImage = url('public/front_end/classic/images/default/profile-avatar.jpg');

            foreach ($comments as $comment) {

                $userProfileImage = $comment->user->profile ?? $defaultProfileImage;

                $commentData = [
                    'id' => $comment->id,
                    'user_id' => $comment->user_id,
                    'post_id' => $comment->post_id,
                    'parent_id' => $comment->parent_id,
                    'replies' => $comment->replies,
                    'comment' => $comment->comment,
                    'created_at' => Carbon::parse($comment->created_at)->diffForHumans(),
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                        'profile' => $userProfileImage
                    ]
                ];

                $commentsById[$comment->id] = $commentData;
            }

            $organizedComments = array_values($commentsById);

            $response = [
                "error" => false,
                "message" => "Comments fetched successfully",
                "data" => $organizedComments
            ];
            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, "message" => $th->getMessage(), "data" => ['detailed_message' => $th]], 500);
        }

    }

    public function update(Request $request)
    {

        $request->validate([
            'comment' => self::COMMENT_VALIDATION,
            'id' => 'required|exists:posts,id',
        ]);
        if (Auth::check()) {
            $comment = Comment::where('id', $request->id)->first();

            $comment->comment = $request->comment;
            $comment->update();

            return response()->json([
                'error' => false,
                'message' => "comment updated successfully",
                'comment_id' => $request->id ?? ""
            ]);
        } else {
            return response()->json([
                'error' => false,
                'message' => "Unauthorized user..",
            ], 201);
        }
    }

    public function destroy($id)
    {
        if (Auth::check()) {

            if($id){
                $this->deleteChildComment($id);
            }
            $comments = Comment::find($id);
            if($comments){
                $post = Post::find($comments->post_id);
                $comments->delete();
                    if($post->comments > 0){
                        $post->decrement('comment');
                    }
                $message = 'Comment Deleted Successfully.';
            
            }else{
                $message = 'Comment not found.';
                print_r($message); exit;
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

    public function reportComment(Request $request, ReportComment $reportComment)
    {
        $request->validate([
            'reportCommentId' => 'required',
            'report' => 'required|string|max:500',
        ]);
    
            $comment_id = $request->reportCommentId ?? 0;
            $comment = Comment::find($comment_id);
            $commentId = $comment->id ?? 0;
            $comment_message = "Comment not found";
            try {
                    $user_id = $request->id ?? Auth::user()->id;
                
            if ($user_id && $commentId != 0) {
                $reportComment->user_id = $user_id;
                $reportComment->comment_id = $request->reportCommentId;
                $reportComment->report = $request->report;
                $reportComment->save();
            } else {
                return response()->json([
                    'error' => true,
                    'message' => $commentId == 0 ? $comment_message : 'User not authenticated',
                    'data'=> [
                        'id'=>$request->report_comment_id,
                        'report'=>"",
                        ]
                ], 401);
            }
    
            return response()->json([
                'error' => false,
                'message' => 'Thanks for the report',
                'data' => [
                    'id'=>$request->reportCommentId,
                    'report'=>$request->report,
                    ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred: ' . $e->getMessage(),
                'data'=> [
                    'id'=>$request->reportCommentId,
                    'report'=>""
                    ]
            ]);
        }
    }
    
    public function deleteChildComment($id){
        $comments = Comment::where('parent_id',$id)->orderBy('id','desc')->get();
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
