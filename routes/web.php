<?php

use App\Domains\Betting\Controllers\CoinFlipController;
use App\Domains\Currency\Controllers\CurrencyController;
use App\Domains\Deposit\Controllers\TransactionController;
use App\Domains\User\Controllers\UpdateActiveBalanceController;
use App\Http\Controllers\Affiliate\AffiliateController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Deposit\DepositController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(AffiliateController::class)->group(function () {
        Route::get('/affiliate', 'index')
            ->name('affiliate.index');
        Route::get('/affiliate/{user:id}', 'show');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/deposit', [DepositController::class, 'index'])->name('deposit.index');

    Route::post('/transaction', TransactionController::class);
    Route::post('/update-active-balance', UpdateActiveBalanceController::class)->name('update-active-balance');

    // Betting games
    Route::get('/coinflip', [CoinFlipController::class, 'index'])->name('coinflip.index');
    Route::post('/coinflip/bet', [CoinFlipController::class, 'bet'])->name('coinflip.bet');

    Route::controller(CurrencyController::class)->group(function () {
        Route::get('/currency', 'index')
            ->name('currency.index');

        Route::post('/currency', 'store')
            ->name('currency.store');
    });
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
