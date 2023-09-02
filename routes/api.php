<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PostController;
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

Route::group(['prefix' => ''], function () {
    Route::get('/', function () {
        return Response()->json([
            'status' => false, 'errorCode' => 401, 'errorDescription' => 'N/A - Bad Link'], 200)->header('Content-Type', 'application/json');

    });

    Route::post('/', function () {
        return Response()->json(['status' => false, 'errorCode' => 401, 'errorDescription' => 'N/A - Bad Links'], 200)->header('Content-Type', 'application/json');

    });

    Route::get('/test', [Controller::class, 'index']);


});
Route::prefix('/v2/blog/')->middleware(['auth:sanctum'])->group(function () {
    Route::post('/post', [PostController::class, 'createPost']);
    Route::get('/blog/{id}', [PostController::class, 'getPost']);
    Route::patch('/update/{id}', [PostController::class, 'updatePost']);
    Route::delete('/remove/{id}', [PostController::class, 'deletePost']);

});
Route::prefix('/v2/authorize')->middleware(['throttle'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});
