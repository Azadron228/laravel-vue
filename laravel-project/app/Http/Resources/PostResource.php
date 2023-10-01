<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'post';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'thumbnail' => asset('storage/'.$this->thumbnail),
            'description' => $this->description,
            'favoritesCount' => $this->favorited->count(),
            'updated_at' => $this->updated_at,
            'favorited' => $this->when($user !== null, fn() =>
                // $this->resource->favoredBy($user)
                $this->favorited->contains($user)
            ),
            'tags' => TagsResource::collection($this->tags),
            'author' => new UserResource($this->resource->user),

        ];
    }
}
