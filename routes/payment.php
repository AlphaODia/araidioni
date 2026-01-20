<?php

use App\Http\Controllers\Client\PaymentController;
use Illuminate\Support\Facades\Route;

Route::prefix('payment')->group(function () {
    Route::get('/test', [PaymentController::class, 'testConnection'])->name('payment.test');
    Route::post('/initiate', [PaymentController::class, 'initPayment'])->name('payment.initiate');
    Route::get('/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    //Route::get('/cancel', [PaymentController::class, 'paymentCancel']->name('payment.cancel');
    Route::post('/webhook', [PaymentController::class, 'paymentWebhook'])->name('payment.webhook');
    Route::get('/status/{paymentId}', [PaymentController::class, 'checkPaymentStatus'])->name('payment.status');
    Route::get('/test', [PaymentController::class, 'testConnection'])->name('payment.test'); 
    Route::get('/test-connection', [PaymentController::class, 'testPaydunyaConnection'])->name('payment.test.connection'); // ← AJOUTEZ CETTE LIGNE
    Route::post('/initiate', [PaymentController::class, 'initPayment'])->name('payment.initiate');
    // Routes de diagnostic
Route::get('/payment/test-network', [PaymentController::class, 'testNetwork']);
Route::get('/payment/fallback', [PaymentController::class, 'fallbackPayment'])->middleware('local');
});