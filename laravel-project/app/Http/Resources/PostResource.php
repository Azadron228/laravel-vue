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
            'body' => $this->body,
            'thumbnail_url' => asset('storage/' . $this->thumbnail),
            //'favorite_count' => $this->favoritedBy->count(),
            'tags' => TagsResource::collection($this->tags),
            'author' => new UserResource($this->resource->user),
        ];
    }
}
