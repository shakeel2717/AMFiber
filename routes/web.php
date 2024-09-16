<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PartyController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/party', PartyController::class);
});

require __DIR__ . '/auth.php';
