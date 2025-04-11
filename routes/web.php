<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
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

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
