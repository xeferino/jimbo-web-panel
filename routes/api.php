<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/forgot', [AuthController::class, 'forgot']);
//Route::get('/profile/{id}', [AuthController::class, 'profile'])->middleware('auth:sanctum');

Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('/profile/{id}', [AuthController::class, 'profile']);
    Route::post('/profile/{id}', [AuthController::class, 'settingProfile']);
    Route::post('/logout/{user}', [AuthController::class, 'logout']);
});

