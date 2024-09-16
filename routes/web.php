<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/party', PartyController::class);
});

require __DIR__ . '/auth.php';
