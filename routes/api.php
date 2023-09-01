<?php

use App\Http\Controllers\Controller;
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
Route::group(['prefix' => ''], function () {
    Route::get('/', function () {
        return Response()->json([
            'status' => false, 'errorCode' => 401, 'errorDescription' => 'N/A - Bad Link'], 200)->header('Content-Type', 'application/json');

    });

    Route::post('/', function () {
        return Response()->json(['status' => false, 'errorCode' => 401, 'errorDescription' => 'N/A - Bad Links'], 200)->header('Content-Type', 'application/json');

    });

    Route::get('/btc', [Controller::class, 'index']);


});
Route::prefix('/api/coin/v2')->middleware(['auth'])->group(function (){
    Route::get('/btc', [Controller::class, 'index']);
});
