<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ProjectImageController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::get('/check-login', [LoginController::class, 'checkLogin']);
Route::apiResource('category', CategoryController::class);
Route::apiResource('project', ProjectController::class);
Route::apiResource('project-image', ProjectImageController::class);
Route::apiResource('tag', TagController::class);
Route::apiResource('posts', BlogController::class);
Route::post('posts-update/{id}', [BlogController::class, 'updatePost']);

