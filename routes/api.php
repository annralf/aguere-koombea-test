<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileContactController;
use App\Http\Controllers\DetailContactController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\AuthController;
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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/get/{status}', [FileContactController::class, 'getFiles']);
Route::get('/file/{filename}', [FileContactController::class, 'readFile']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/upload', [FileContactController::class, 'upload']);
    Route::get('/list', [FileContactController::class, 'listAll']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
