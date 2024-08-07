<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/dashboard/posts/', [PostController::class, 'getPosts']);
Route::get('/dashboard/posts/{id}', [PostController::class, 'getSinglePost']);
Route::get('/dashboard/comments/', [PostController::class, 'getComments']);
Route::get('/dashboard/post/comments/{post_id}', [PostController::class, 'getPostComments']);
Route::post('/dashboard/posts/', [PostController::class, 'createPost']);
Route::post('/dashboard/comments/', [PostController::class, 'createComment']);
Route::delete('/dashboard/comments/{id}', [PostController::class, 'deleteComments']);
Route::delete('/dashboard/posts/{id}', [PostController::class, 'deletePosts']);
Route::post('/dashboard/posts/update', [PostController::class, 'EditPost']);
