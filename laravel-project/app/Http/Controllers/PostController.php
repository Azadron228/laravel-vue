<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Http\Resources\TagsCollection;
use App\Http\Resources\TagsResource;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Storage;

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

        if ($request->has('tags')) {
            $tagName = $request->input('tags');

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
            $favoritedName = $request->input('favorited');

            $user = User::where('username', $favoritedName)->first();

            if ($user) {
                // If the user exists, filter posts that are favorited by the user.
                $query->whereIn('id', $user->favorites->pluck('id'));
            } else {
                // Handle the case where the favorited user doesn't exist.
                return response()->json(['message' => 'Favorited user not found'], 404);
            }
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

    public function listTags(Request $request)
    {
        // return new TagsRes;ource(Tag::all());
        // return Tag::all();
        $tags = Tag::all();

        return TagsResource::collection($tags);
        // return new TagsCollection(Tag::all());
    }

    public function createPost(StorePostRequest $request)
    {
        $user = auth()->user();
        // $tags = Arr::pull($attributes, 'tagList');
        $tags = $request->input('tags');

        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = Storage::disk('public')->put('thumbnails', $request->file('thumbnail'));
        }
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;
        $validatedData['thumbnail'] = $thumbnailPath;
        $post = Post::create($validatedData);
        if (is_array($tags)) {
            $post->attachTags($tags);
        }

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

    /**
     * Update the given blog post.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdatePostRequest $request, Post $post, $id)
    {
        $this->authorize('update', $post);
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
