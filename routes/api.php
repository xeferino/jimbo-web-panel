<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\RaffleController;
use App\Http\Controllers\Api\JibController;
use App\Http\Controllers\Api\BalanceController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\ShoppingController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\AccountController;

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
Route::post('/resend-code-verified-email', [AuthController::class, 'sendCodeVerifiedEmail']);
Route::post('/verified-email', [AuthController::class, 'verifiedEmail']);
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

    Route::name('cards')->group(function () {
        Route::get('cards/user/{user}', [CardController::class, 'index'])->name('index');
        Route::get('cards/{card}', [CardController::class, 'show'])->name('show');
        Route::post('cards', [CardController::class, 'store'])->name('store');
        Route::put('cards/{card}', [CardController::class, 'update'])->name('update');
        Route::delete('cards/{card}', [CardController::class, 'destroy'])->name('destroy');
    });

    Route::name('accounts')->group(function () {
        Route::get('accounts/user/{user}', [AccountController::class, 'index'])->name('index');
        Route::get('accounts/{account}', [AccountController::class, 'show'])->name('show');
        Route::post('accounts', [AccountController::class, 'store'])->name('store');
        Route::put('accounts/{account}', [AccountController::class, 'update'])->name('update');
        Route::delete('accounts/{account}', [AccountController::class, 'destroy'])->name('destroy');
    });
});


Route::get('payment', [PaymentController::class, 'payment'])->name('payment');
Route::get('payment/{user}', [PaymentController::class, 'paymentHistory'])->name('payment.user');


Route::post('sales', [SaleController::class, 'saleTicketCard'])->name('ticket.pay.card');

Route::get('shoppings/{user}', [ShoppingController::class, 'index'])->name('shopping.tickets');
Route::get('shoppings/tickets/{shopping}', [ShoppingController::class, 'show'])->name('shopping.detail.ticket');



