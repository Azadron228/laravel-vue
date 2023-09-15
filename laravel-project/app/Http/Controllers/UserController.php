<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Storage;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    public function update(UpdateUserRequest $request)
    {
        $validatedData = $request->validated();
        // $avatarPath = $request->file('avatar')->store('avatars', 'public');
        if ($request->hasFile('avatar')) {
            $avatarPath = Storage::disk('public')->put('avatars', $request->file('avatar'));
        }
        $user = $request->user();
        $validatedData['avatar'] = $avatarPath;

        $user->update($validatedData);

        return new UserResource($user);
    }
}
