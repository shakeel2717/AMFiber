<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/party', PartyController::class);
    Route::resource('/product', ProductController::class);
});

require __DIR__ . '/auth.php';
