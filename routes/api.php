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
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\LegalityController;
use App\Http\Controllers\Api\RouletteController;

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
//access
Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/forgot', [AuthController::class, 'forgot']);
Route::post('/recovery-password', [AuthController::class, 'recoveryPassword']);
Route::post('/resend-code-verified-email', [AuthController::class, 'sendCodeVerifiedEmail']);
Route::post('/verified-email', [AuthController::class, 'verifiedEmail']);
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/sliders', [SliderController::class, 'index']);
Route::get('/terms-conditions', [LegalityController::class, 'legality']);
//Route::get('/profile/{id}', [AuthController::class, 'profile'])->middleware('auth:sanctum');

Route::prefix('user')->middleware(['auth:sanctum', 'check.user'])->group(function () {
    //informations
    Route::get('/profile/{id}', [AuthController::class, 'profile']);
    Route::post('/profile/{id}', [AuthController::class, 'settingProfile']);
    Route::post('/logout/{user}', [AuthController::class, 'logout']);
    Route::get('/balance/{user}', [BalanceController::class, 'balance']);
    //to sellers
    Route::post('/to/seller/{id}', [AuthController::class, 'competitor_to_seller']);
    //cards
    Route::get('/cards/all/{user}', [CardController::class, 'index']);
    Route::get('/cards/{card}', [CardController::class, 'show']);
    Route::post('/cards', [CardController::class, 'store']);
    Route::put('/cards/{card}', [CardController::class, 'update']);
    Route::delete('cards/{card}', [CardController::class, 'destroy']);
    //accounts
    Route::get('/accounts/all/{user}', [AccountController::class, 'index']);
    Route::get('/accounts/{account}', [AccountController::class, 'show']);
    Route::post('/accounts', [AccountController::class, 'store']);
    Route::put('/accounts/{account}', [AccountController::class, 'update']);
    Route::delete('accounts/{account}', [AccountController::class, 'destroy']);
    //notifications
    Route::get('/notifications/all/{user}', [NotificationController::class, 'index']);
    //graphics
    Route::get('/shoppings/graphics/{user}', [ShoppingController::class, 'graphics']);
    Route::get('/sales/graphics/{user}', [SaleController::class, 'graphics']);
});

Route::middleware(['auth:sanctum', 'check.user'])->group(function () {
    //raffles
    Route::post('/raffles/ticket', [RaffleController::class, 'ticket']);
    Route::get('/raffles/favorites/{user?}', [RaffleController::class, 'index']);
    Route::get('/raffles', [RaffleController::class, 'index']);
    Route::get('/raffles/detail/{raffle}', [RaffleController::class, 'show']);
    Route::post('/raffles/favorites', [RaffleController::class, 'store']);
    Route::get('/raffles/winners', [RaffleController::class, 'winners']);
    Route::get('/raffles/winner/show/{id}', [RaffleController::class, 'showWinner']);

    //payments
    Route::get('/payment/{user}', [PaymentController::class, 'paymentHistory']);
    Route::post('/payment/detail', [PaymentController::class, 'paymentDetail']);
    Route::get('/payment/methods/all', [PaymentController::class, 'paymentMethod']);
    //sales
    Route::post('/sales/payment', [SaleController::class, 'saleTicket']);
    Route::get('/sales/{user}', [SaleController::class, 'index']);
    Route::get('/sales/tickets/{sale}', [SaleController::class, 'show']);
    Route::get('/sales/sellers/rankings', [SaleController::class, 'topSellers']);

    //shoppings
    Route::get('/shoppings/{user}', [ShoppingController::class, 'index']);
    Route::get('/shoppings/tickets/{shopping}', [ShoppingController::class, 'show']);
    //jibs
    Route::get('/jibs', [JibController::class, 'index']);
    Route::post('/jibs/recharge', [JibController::class, 'recharge']);
    Route::post('/jibs/exchange', [JibController::class, 'exchange']);
    //cash request
    Route::post('/cash/request', [PaymentController::class, 'cashRequest']);
    Route::get('/cash/request/{user}', [PaymentController::class, 'cashRequestUser']);

     //roulettes
     Route::get('/roulettes', [RouletteController::class, 'index']);
     Route::post('/roulettes/wager', [RouletteController::class, 'wager']);
     //Route::post('/roulettes/exchange', [RouletteController::class, 'exchange']);
});

/*Route::get('/foo', function () {
    return Artisan::call('storage:link');
});*/
