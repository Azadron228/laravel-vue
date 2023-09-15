<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
Route::get('/listTags', [PostController::class, 'listTags'])->name('tags');

// Guest accessible routes
Route::get('/posts', [PostController::class, 'showAll'])->name('posts.index');
Route::get('post/{id}', [PostController::class, 'show'])->name('posts.show');


// Verify email
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// // Resend link to verify email
// Route::post('/email/verify/resend', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();
//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
//
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('profiles/{username}', [ProfileController::class, 'show'])->name('get');
// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {

    Route::get('api/user', [UserController::class, 'show'])->name('current');
    Route::put('api/user', [UserController::class, 'update'])->name('update');

    Route::post('profiles/{username}/follow', [ProfileController::class, 'follow'])
        ->name('follow');
    Route::delete('profiles/{username}/follow', [ProfileController::class, 'unfollow'])
        ->name('unfollow');

    Route::get('/profile', [UserController::class, 'profile'])->name('profile.show');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::post('/user/{user}/follow', [UserController::class, 'follow'])->name('users.follow');
    Route::post('/user/{user}/unfollow', [UserController::class, 'unfollow'])->name('users.unfollow');

    Route::post('comments', [CommentController::class, 'create']);
    Route::delete('comments/{comment}', [CommentController::class, 'delete']);
    Route::get('posts/{post_id}/comments', [CommentController::class, 'getAll']);

    Route::post('/post/create', [PostController::class, 'createPost'])->name('post.create');
    Route::put('/post/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('post/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/feed', [PostController::class, 'getFeed'])->name('post.feed');
    Route::post('/posts/{post}/favorite', [PostController::class, 'favoritePost'])->name('posts.favorite');
    Route::delete('/posts/{post}/unfavorite', [PostController::class, 'unfavoritePost'])->name('posts.unfavorite');
});
