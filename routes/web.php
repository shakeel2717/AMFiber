<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlaiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\StoreImageController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('/dashboard', DashboardController::class);
    Route::get('/party/statement/{party}', [PartyController::class, 'statement'])->name('party.statement');
    Route::resource('/party', PartyController::class);
    Route::resource('/product', ProductController::class);
    Route::resource('/plai', PlaiController::class);
    Route::resource('/quotation', QuotationController::class);
    Route::get('/invoice/{invoice}/edit_product', [InvoiceController::class, 'edit_product'])->name('invoice.edit_product');
    Route::resource('/invoice', InvoiceController::class);
    Route::resource('/payment', PaymentController::class);
});

Route::post('/save-image', [StoreImageController::class, 'saveImage']);

require __DIR__ . '/auth.php';
