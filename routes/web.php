<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');


Route::get('dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::resource('posts', PostController::class);

Route::post('/comment/{post}', [CommentController::class, 'store'])->name('comments.store');

Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::resource('markers', MarkerController::class);

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Cart Routes
Route::post('/cart/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::patch('/cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/{productId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'processPayment'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/checkout/failed', [CheckoutController::class, 'paymentFailed'])->name('payment.failed');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
