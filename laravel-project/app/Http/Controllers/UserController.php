<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    public function update(UpdateUserRequest $request)
    {
        $validatedData = $request->validated();
        $thumbnailPath = $request->file('avatar')->store('avatars', 'public');
        $user = $request->user();
        $validatedData['avatar'] = $thumbnailPath;

        $user->update($validatedData);

        return new UserResource($user);
    }
}
