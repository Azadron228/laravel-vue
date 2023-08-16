<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
  public function show()
  {
    $user = Auth::user();

    if (!$user) {
      return response()->json(['error' => 'User not found'], 404);
    }

    return view('profile', ['user' => $user]);
  }

  public function edit(Request $request)
  {
    // $path = Storage::putFile('avatars', $request->file('avatar'));
    $user = Auth::user();
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    // Update other user fields as needed


    return response()->json($user);

    $avatarPath = $request->file('avatar')->store('avatars', 'public');
    $user->avatar = $avatarPath;
    
    $user->save();
    return view('edit', ['user' => $user]);
    // return redirect()->route('profile.show');
    // return response()->json($user);
  }
  
  public function profile(Request $request)
  {
    $user = Auth::user();

    $data = [
      'name' => $user->name,
      'email' => $user->email,
    ];

    return response()->json($data);
  }


  public function updateUser(Request $request)
    {
        $user = Auth::user(); // Assuming the user is authenticated
        
        // Validate the incoming data (you can customize validation rules)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Update user data
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        return response()->json(['message' => 'Profile updated successfully']);
    }

}
