<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Meme\MemeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/meme', [MemeController::class, 'index'])->name('meme.index');
    Route::post('/meme/store', [MemeController::class, 'store'])->name('meme.store');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
