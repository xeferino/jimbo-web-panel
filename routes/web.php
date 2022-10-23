<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\CompetitorController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\RaffleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\PaymentController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

Route::get('/', function () {
    return redirect('login');
});

/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard'); */

Route::prefix('panel')->name('panel.')->middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('sellers', SellerController::class);
    Route::resource('competitors', CompetitorController::class);
    Route::resource('countries', CountryController::class);
    Route::resource('raffles', RaffleController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('sliders', SliderController::class);

    Route::prefix('ajax')->name('ajax.')->middleware('auth')->group(function () {
        Route::post('raffles/promotions', [RaffleController::class, 'promotions'])->name('raffle.promotions');
        Route::post('raffles/promotions/add', [RaffleController::class, 'promotionAdd'])->name('raffle.promotions.store');
        Route::post('raffles/promotions/delete', [RaffleController::class, 'promotionDelete'])->name('raffle.promotions.delete');
    });
});

