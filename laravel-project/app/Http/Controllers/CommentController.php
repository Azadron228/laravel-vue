<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Response;
use Request;

class CommentController extends Controller
{
    public function getAll($slug)
    {
        $post= Post::whereSlug($slug)
            ->firstOrFail();
        $post_id = $post->id;

        $comments = Comment::where('post_id', $post_id)->get();

        // $profile = User::where('username', $username)
        // ->firstOrFail();
        // dd($comments);

        // return new CommentResource($comments);
        return new CommentCollection($comments);


    }

    public function create(StoreCommentRequest $request, $slug)
    {

        // $post = Post::where('slug', $slug)->first();
        //
        // $validatedData = $request->validate([
        //     'post_id' => 'required|exists:posts,id',
        //     'content' => 'required|string',
        // ]);

        // Assuming you're using authentication
        // $user = auth()->user();

        // $comment = Comment::create([
        //     'user_id' => $user->id,
        //     'post_id' => $post->id,
        //     // 'content' => $validatedData['content'],
        //     'content' => $request->input('comment.body'),
        //
        // ]);

        // return response()->json(['message' => 'Comment added successfully',
        // 'comment' => $comment]);
        // return new CommentResource($comment);

        $post= Post::whereSlug($slug)
            ->firstOrFail();

        /** @var \App\Models\User $user */
        // $user = $request->user();
        // $user = $request->user();
        $user = auth()->user();
        // dd($post);



        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'body' => $request->input('comment.body'),
        ]);

        // return (new CommentResource($comment))
        // ->response()
        // ->setStatusCode(201);
        return new CommentResource($comment);
    }

    public function delete($id)
    {
        // Assuming you're using authentication
        // $user = auth()->user();
        //
        // if ($user->id !== $comment->user_id) {
        //     return response()->json(
        //         ['message' => 'Unauthorized'],
        //         Response::HTTP_UNAUTHORIZED
        //     );
        // }

        // $comment = Post::where('slug', $slug)->first();
        $comment = Comment::findOrFail($id);

        //
        // if (! $post) {
        //     return response()->json(['error' => 'Post not found'], 404);
        // }

        $this->authorize('delete', $comment);

        // $post->delete();


        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
