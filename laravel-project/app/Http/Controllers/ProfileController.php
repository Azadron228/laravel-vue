<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfileController extends Controller
{
    public function show(string $username)
    {
        $profile = User::where('username', $username)
            ->firstOrFail();

        return new UserResource($profile);
    }

    public function follow(Request $request, string $username)
    {
        $profile = User::whereUsername($username)
            ->firstOrFail();

        $user = $request->user();
        $user->followers()
            ->syncWithoutDetaching($profile);

        return new UserResource($profile);
    }

    public function aaafollow(Request $request, $username)
    {
        $user = $request->user();
        $profile = User::whereUsername($username)
            ->firstOrFail();

        $user->followers()
            ->syncWithoutDetaching($profile);

        return new UserResource($user);
                // return new ProfileResource($profile);


    }

    public function unfollow(User $user)
    {
        $User = auth()->user();

        $User->followers()->detach($user);

                return new UserResource($profile);


        // return response()->json(['message' => 'You have unfollowed '.$user->name]);
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
