<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function getAll($post_id)
    {
        $comments = Comment::where('post_id', $post_id)->get();

        // $profile = User::where('username', $username)
            // ->firstOrFail();

        return response()->json(['comments' => $comments]);
    }

    public function create(StoreCommentRequest $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string',
        ]);

        // Assuming you're using authentication
        $user = auth()->user();

        $comment = Comment::create([
            'user_id' => $user->id,
            'post_id' => $validatedData['post_id'],
            'content' => $validatedData['content'],
        ]);

        return response()->json(['message' => 'Comment added successfully',
            'comment' => $comment]);
    }

    public function delete(Comment $comment)
    {
        // Assuming you're using authentication
        $user = auth()->user();

        if ($user->id !== $comment->user_id) {
            return response()->json(['message' => 'Unauthorized'],
                Response::HTTP_UNAUTHORIZED);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
