<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StorefrontController::class, 'home'])->name('home');
Route::get('/shop', [StorefrontController::class, 'shop'])->name('shop');
Route::get('/product/{slug}', [StorefrontController::class, 'show'])->name('product.show');

Route::view('/license', 'static.license')->name('license');
Route::view('/terms', 'static.terms')->name('terms');
Route::view('/privacy', 'static.privacy')->name('privacy');
Route::get('/support', [SupportController::class, 'create'])->name('support');
Route::post('/support', [SupportController::class, 'store'])->name('support.send');

Route::post('/webhooks/stripe', StripeWebhookController::class)->name('webhooks.stripe');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/checkout/{product:slug}', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/purchase/success/{order}', [CheckoutController::class, 'success'])->name('purchase.success');

    Route::get('/dashboard', [AccountController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders/{order}', [AccountController::class, 'order'])->name('account.orders.show');

    Route::get('/download/{order}/{productFile}', DownloadController::class)
        ->middleware('signed')
        ->name('downloads.file');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
