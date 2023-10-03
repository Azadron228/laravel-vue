<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = 'user';

    // /**
    //  * Transform the resource into an array.
    //  *
    //  * @return array<string, mixed>
    //  */
    // public function toArray(Request $request): array
    // {
    //     /** @var \App\Models\User|null $user */
    //     $user = $request->user();
    //     $followedAuthors = $user->authors;
    //     $following = $user->authors()
    //         ->whereKey($user->getKey())
    //         ->exists();
    //
    //     // $favoritedPosts = $user->favorites()
    //     //     ->with('user')
    //     //     ->get();
    //     return [
    //         'id' => $this->id,
    //         'username' => $this->username,
    //         'email' => $this->email,
    //         'avatar' => Storage::url($this->avatar),
    //         'bio' => $this->bio,
    //         'followedAuthors' => $followedAuthors,
    //         // 'favoritedPosts' => $favoritedPosts,
    //         'is_following' => optional(auth()->user())->isFollowing($this->resource),
    //         'created_at' => $this->created_at,
    //         'updated_at' => $this->updated_at,
    //     ];
    // }
    //

    public function toArray($request)
    {
        /** @var \App\Models\User|null $user */
        // $user = $request->user();
                $user = $this->resource;

        $followedAuthors = $user->authors;
        $isFollowing = auth()->check() ? auth()->user()->isFollowing($user) : false;
        $following = $user->authors()
            ->whereKey($user->getKey())
            ->exists();

        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'avatar' => Storage::url($this->avatar),
            'bio' => $this->bio,
            'followedAuthors' => $followedAuthors,
            'isFollowing' => $isFollowing,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
