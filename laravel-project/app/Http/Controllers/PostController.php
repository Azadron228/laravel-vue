<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\View\View;

class PostController extends Controller
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function showAll()
    {
        $posts = Post::with('user')->paginate(10);

        foreach ($posts as $post) {
            $post->user_name = $post->user->name;
        }

        $data = [
            'current_page' => $posts->currentPage(),
            'total_pages' => $posts->lastPage(),
            'data' => $posts->items(),
        ];

        return response()->json($data, Response::HTTP_OK);
    }
    
    public function create()
    {
    return FacadesView::make('posts.create');
    }
    public function createPost(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Create a new post
        $post = new Post;
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->user_id = $user->id;
        $post->save();

        return FacadesResponse::json(['message' => 'Congrtulations! Post created successfully'], 201);
    }

    // public function findById($id)
    // {
    //     $post = Post::findOrFail($id);
    //
    //     return response()->json($post);
    // }
    //
    public function destroy($id)
    {
        $this->post->deletePost($id);

        return response()->json(null, 204);
    }
}
