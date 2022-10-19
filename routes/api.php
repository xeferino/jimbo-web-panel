<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\RaffleController;
use App\Http\Controllers\Api\JibController;
use App\Http\Controllers\Api\BalanceController;

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
Route::post('/recovery-password', [AuthController::class, 'recoveryPassword']);
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/sliders', [SliderController::class, 'index']);
//Route::get('/profile/{id}', [AuthController::class, 'profile'])->middleware('auth:sanctum');

Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('/profile/{id}', [AuthController::class, 'profile']);
    Route::post('/profile/{id}', [AuthController::class, 'settingProfile']);
    Route::post('/logout/{user}', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/raffles', [RaffleController::class, 'index']);
    Route::get('/raffles/{raffle}', [RaffleController::class, 'show']);
    Route::get('/jibs', [JibController::class, 'index']);
    Route::get('/balance/{user}', [BalanceController::class, 'balance']);
});
