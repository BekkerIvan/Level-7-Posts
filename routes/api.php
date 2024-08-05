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
Route::get('/dashboard/posts/{user_id}', [PostController::class, 'getDashboardPosts']);
Route::post('/dashboard/posts/{user_id}', [PostController::class, 'createPost']);
Route::post('/dashboard/posts/{post_id}/{user_id}', [PostController::class, 'createComment']);
