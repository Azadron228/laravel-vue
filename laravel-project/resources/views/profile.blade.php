<!-- profile.blade.php -->
@extends('layouts')

@section('title', 'Profile')

@section('content')
    <h1>Profile</h1>

    <div>
        <img src="{{ asset($user->avatar) }}" alt="Avatar" style="width: 150px; height: 150px;">
    </div>

    <div>
        <p>Name: {{ $user->name }}</p>
        <p>Email: {{ $user->email }}</p>
    </div>
    
<a href="{{ route('logout') }}"
   onclick="event.preventDefault();
             document.getElementById('logout-form').submit();">
    Logout
</a>

<!-- Example of a button -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
    
@endsection

