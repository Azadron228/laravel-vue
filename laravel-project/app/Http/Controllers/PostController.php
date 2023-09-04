<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function showAll(Request $request)
    {
        $query = Post::query();

        if ($request->has('tag')) {
            $tagName = $request->input('tag');

            $query->whereHas(
                'tags',
                fn (Builder $builder) => $builder->where('name', $tagName)
            );

        }

        if ($request->has('author')) {
            $tagName = $request->input('author');

            $user = User::where('username', $tagName)->first();
            $query = $user->posts();
        }

        if ($request->has('favorited')) {
            $user = auth()->user();
            $query = $user->favorites();
        }
        $posts = $query->paginate(10);
        return new PostCollection($posts);
    }

    public function getFeed(Request $request)
    {
        $query = Post::query();

        if ($request->has('author')) {
            $tagName = $request->input('author');

            $query->whereHas(
                'author',
                fn (Builder $builder) => $builder->where('author', $tagName)
            );
        }

        return PostResource::collection($query->paginate());
    }

    public function createPost(StorePostRequest $request)
    {
        $user = auth()->user();
        // $tags = Arr::pull($attributes, 'tagList');
        $tags = $request->input('tagList');

        $thumbnailPath = null;

        if ($request->hasFile('avatar')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails');
        }
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;
        $validatedData['thumbnail'] = $thumbnailPath;
        $post = Post::create($validatedData);
        if (is_array($tags)) {
            $post->attachTags($tags);
        };


        return new PostResource($post);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        return new PostResource($post);
    }

    public function destroy($id)
    {
        $this->post->deletePost($id);

        return response()->json(null, 204);
    }

    public function update(UpdatePostRequest $request, Post $post, $id)
    {
        $post = Post::findOrFail($id);
        $validatedData = $request->validated();

        $post->update($validatedData);

        return response()->json($post);
    }

    /** Fovorites Logic **/
    public function favoritePost(Request $request, Post $post)
    {
        $user = auth()->user();
        $user->favorites()->attach($post->id);

        return response()->json(['message' => 'Post added to favorites.']);
    }

    public function unfavoritePost(Request $request, Post $post)
    {
        $user = auth()->user();
        $user->favorites()->detach($post->id);

        return response()->json(['message' => 'Post removed from favorites.']);
    }
}
