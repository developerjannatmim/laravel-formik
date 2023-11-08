<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::controller(PostController::class)->group(function () {
 Route::group(['prefix' => 'posts'], function() {
    Route::get('', 'post_list');
    Route::post('', 'post_store');
    Route::group(['prefix' => '{post}'], function () {
        Route::get('', 'post_show');
        Route::put('', 'post_update');
        Route::delete('', 'post_delete');
    });
 });
});
