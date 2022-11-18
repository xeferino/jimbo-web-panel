<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\CompetitorController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\RaffleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CashRequestController;
use App\Http\Controllers\EgressController;
use Illuminate\Http\Request;




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

Route::get('/', [LandingPageController::class, 'home'])->name('landing.home');
Route::get('/terms_and_conditions', [LandingPageController::class, 'term'])->name('landing.terms_conditions');
Route::get('/faq', [LandingPageController::class, 'faq'])->name('landing.faq');

Route::prefix('panel')->name('panel.')->middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('actions', [ActionController::class, 'index'])->name('actions.index');
    Route::resource('users', UserController::class);
    Route::post('sellers/recharge/jib/{seller}', [SellerController::class, 'rechargeJib'])->name('sellers.recharge.jib');
    Route::resource('sellers', SellerController::class);
    Route::resource('sales', SaleController::class);
    Route::get('cash-request', [CashRequestController::class, 'index'])->name('cash.request');
    Route::get('cash-request/{id}', [CashRequestController::class, 'show'])->name('cash.request.show');
    Route::post('cash-request/status/change/{id}', [CashRequestController::class, 'changeStatu'])->name('cash.request.change.statu');
    Route::get('egress', [EgressController::class, 'index'])->name('egress.index');
    Route::get('egress/cash', [EgressController::class, 'cash'])->name('egress.cash');
    Route::get('egress/jib', [EgressController::class, 'jib'])->name('egress.jib');
    Route::get('egress/{id}', [EgressController::class, 'show'])->name('egress.show');
    Route::get('competitors/winners', [CompetitorController::class, 'winners'])->name('competitors.winners');
    Route::get('competitors/winners/{competitor}', [CompetitorController::class, 'showWinner'])->name('competitors.winners.show');
    Route::resource('competitors', CompetitorController::class);
    Route::resource('countries', CountryController::class);
    Route::resource('raffles', RaffleController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('sliders', SliderController::class);
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::prefix('ajax')->name('ajax.')->middleware('auth')->group(function () {
        Route::post('raffles/promotions', [RaffleController::class, 'promotions'])->name('raffle.promotions');
        Route::post('raffles/promotions/add', [RaffleController::class, 'promotionAdd'])->name('raffle.promotions.store');
        Route::post('raffles/promotions/delete', [RaffleController::class, 'promotionDelete'])->name('raffle.promotions.delete');
    });
});

