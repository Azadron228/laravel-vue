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
        // $user = $request->user();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'thumbnail' => asset('storage/'.$this->thumbnail),
            'description' => $this->description,
            'favorite_count' => $this->favorited->count(),
                        'updated_at' => $this->updated_at,


            //'favorite_count' => $this->favoritedBy->count(),
            'tags' => TagsResource::collection($this->tags),
            'author' => new UserResource($this->resource->user),

        ];
    }
}
