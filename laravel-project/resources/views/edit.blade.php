<!-- edit.blade.php -->
@extends('layouts')

@section('title', 'Edit Profile')

@section('content')
    <h1>Edit Profile</h1>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ $user->name }}">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ $user->email }}">
        </div>

        <div>
            <label for="avatar">Avatar</label>
            <input type="file" name="avatar" id="avatar">
        </div>

        <button type="submit">Update Profile</button>
    </form>
@endsection

