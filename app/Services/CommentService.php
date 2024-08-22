<?php

namespace App\Services;

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

class CommentService
{
    public function getCommentsByApplicant(int $applicant_id)
    {
        try {
            return Comment::with(['user', 'applicant', 'cohort', 'round1', 'round2', 'round3'])
                ->where('applicant_id', $applicant_id)
                ->get();
        } catch (\Exception $e) {
            Log::error('Error fetching comments by applicant:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function createComment(array $data, int $applicant_id, int $round_id, string $round_type): Comment
    {
        try {
            $user = auth()->user();
         // $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $data['applicant_id'] = $applicant_id;
            $applicant = Applicant::findOrFail($applicant_id);

            $data['user_id'] = $$user->id;
            $data['cohort_id'] = $applicant->cohort_id;

            switch ($round_type) {
                case 'round1':
                    $data['round1_id'] = $round_id;
                    break;
                case 'round2':
                    $data['round2_id'] = $round_id;
                    break;
                case 'round3':
                    $data['round3_id'] = $round_id;
                    break;
                default:
                    throw new \Exception('Invalid round type');
            }
            return Comment::create($data);
        } catch (\Exception $e) {
            Log::error('Error creating comment:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
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




    public function updateComment(int $id, array $data): Comment
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->update($data);

            return $comment;
        } catch (\Exception $e) {
            Log::error('Error updating comment:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function deleteComment(int $id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting comment:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }
}
