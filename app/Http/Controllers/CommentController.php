<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Services\CommentService;
use App\Models\Comment;
use App\Models\Applicant;
use App\Models\Cohort;
use App\Models\Round1;
use App\Models\Round2;
use App\Models\Round3;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function getCommentsByApplicant($applicant_id)
    {
        try {
            $comments = $this->commentService->getCommentsByApplicant($applicant_id);

            return response()->json($comments);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching comments by applicant'], 500);
        }
    }
    public function store0(CommentRequest $request, $applicant_id, $round_id, $round_type)
    {
        try {
            $comment = $this->commentService->createComment($request->validated(), $applicant_id, $round_id, $round_type);

            return response()->json(['comment' => $comment], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating comment'], 500);
        }
    }

    public function store(Request $request, $applicant_id, $round_id, $round_type)
    {
        try {
            $data = $request->validate([
                'feedback' => 'nullable|string',
                'decision' => 'nullable|in:accepted,rejected',
            ]);
    
            $user = auth()->user();
         // $user = Auth::user();

            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $applicant = Applicant::findOrFail($applicant_id);
            $data['user_id'] = $user->id;
            $data['applicant_id'] = $applicant->id;
            $data['cohort_id'] = $applicant->cohort_id;
    
            switch ($round_type) {
                case 'round1':
                    $round1 = Round1::findOrFail($round_id);
                    $data['round1_id'] = $round1->id;
                    break;
                case 'round2':
                    $round2 = Round2::findOrFail($round_id);
                    $data['round2_id'] = $round2->id;
                    break;
                case 'round3':
                    $round3 = Round3::findOrFail($round_id);
                    $data['round3_id'] = $round3->id;
                    break;
                default:
                    return response()->json(['message' => 'Invalid round type'], 400);
            }
    
            $comment = Comment::create($data);
    
            return response()->json(['comment' => $comment], 201);
        } catch (\Exception $e) {
            Log::error('Error creating comment:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Error creating comment'], 500);
        }
    }

    // public function index()
    // {
    //     try {
    //         $comments = $this->commentService->getAllComments();
    //         return response()->json($comments);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Error fetching comments'], 500);
    //     }
    // }

    public function update(CommentRequest $request, $id)
    {
        try {
            $comment = $this->commentService->updateComment($id, $request->validated());

            return response()->json(['comment' => $comment], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating comment'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->commentService->deleteComment($id);

            return response()->json(['message' => 'Comment deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting comment'], 500);
        }
    }
}
