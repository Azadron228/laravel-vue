<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(string $username)
    {
        $profile = User::where('username', $username)
            ->firstOrFail();

        return new UserResource($profile);
    }

    public function follow(User $user)
    {
        $authenticatedUser = auth()->user();

        if (! $authenticatedUser->followers()->where('follower_id', $user->id)->exists()) {
            $authenticatedUser->followers()->syncWithoutDetaching($user->id);

            return response()->json(['message' => 'You are now following '.$user->name]);
        }

        return response()->json(['message' => 'You are already following '.$user->name]);
    }

    public function unfollow(User $user)
    {
        $User = auth()->user();

        $User->followers()->detach($user);

        return response()->json(['message' => 'You have unfollowed '.$user->name]);
    }

    public function afollow(Request $request, string $username)
    {
        $profile = User::where('username', $username)
            ->firstOrFail();

        $profile->followers()
            ->syncWithoutDetaching($request->user());

        return new UserResource($profile);
    }

    public function aunfollow(Request $request, string $username)
    {
        $profile = User::where('username', $username)
            ->firstOrFail();

        $profile->followers()->detach($request->user());

        return new UserResource($profile);
    }
}
