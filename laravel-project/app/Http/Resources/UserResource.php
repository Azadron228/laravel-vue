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

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();
        //
        // $authorsIFollow = $user->followers()
        //     ->select('users.id', 'users.name')
        //     ->get();
        //
        // $favoritedPosts = $user->favorites()
        //     ->with('user')
        //     ->get();

        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'avatar' => Storage::url($this->avatar),
            'bio' => $this->bio,
            // 'authorsIFollow' => $authorsIFollow,
            // 'favoritedPosts' => $favoritedPosts,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
