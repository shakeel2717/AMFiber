<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuotationController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('/dashboard', DashboardController::class);
    Route::get('/party/statement/{party}', [PartyController::class, 'statement'])->name('party.statement');
    Route::resource('/party', PartyController::class);
    Route::resource('/product', ProductController::class);
    Route::resource('/quotation', QuotationController::class);
    Route::resource('/invoice', InvoiceController::class);
    Route::resource('/payment', PaymentController::class);
});

require __DIR__ . '/auth.php';
