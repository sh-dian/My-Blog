<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BlogPostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //to logout
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum', 'verified')->group(function () {

    // List blog post
    Route::get('blog-post', [BlogPostController::class, 'index']);
    Route::get('blog-post/{blog_post}', [BlogPostController::class, 'show']);

    Route::get('blog-post/create/post', [BlogPostController::class, 'create']); //shows create post form
    Route::post('blog-post/create/post', [BlogPostController::class, 'store']); //saves the created post to the databse
    Route::get('blog-post/{blog_post}/edit', [BlogPostController::class, 'edit']); //shows edit post form
    Route::put('blog-post/{blog_post}/edit', [BlogPostController::class, 'update']); //commits edited post to the database 
    Route::delete('blog-post/{blog_post}', [BlogPostController::class, 'destroy']);
});
