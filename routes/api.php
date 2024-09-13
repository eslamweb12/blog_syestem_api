<?php

use App\Http\Controllers\Auth\UserController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);


Route::middleware('auth:api')->group(function () {
    Route::put('posts/{id}', [\App\Http\Controllers\PostControllerResource::class, 'update']);
    Route::delete('posts/{id}', [\App\Http\Controllers\PostControllerResource::class, 'destroy']);
    Route::get('posts/{id}', [\App\Http\Controllers\PostControllerResource::class, 'show']);
    Route::get('/search11', [\App\Http\Controllers\PostControllerResource::class, 'search']);

    Route::middleware('role:admin')->group(function () {
        Route::apiResource('posts', \App\Http\Controllers\PostControllerResource::class);
    });

    Route::middleware('role:author')->group(function () {
     Route::post('/posts', [\App\Http\Controllers\PostControllerResource::class, 'store']);
        Route::post('posts/{id}/comments', [\App\Http\Controllers\CommentController::class, 'StoreComment']);
//        Route::delete('posts/{post}', [PostController::class, 'destroy']);
    });


});

