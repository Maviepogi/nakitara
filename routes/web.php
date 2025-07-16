<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Google OAuth
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// 2FA routes
Route::get('/2fa/verify', [AuthController::class, 'show2FAForm'])->name('2fa.verify');
Route::post('/2fa/verify', [AuthController::class, 'verify2FA']);

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/filter', [DashboardController::class, 'filter'])->name('dashboard.filter');
    
    Route::resource('items', ItemController::class);
    
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create/{item}', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/items', [AdminController::class, 'items'])->name('admin.items');
    Route::get('/logs', [AdminController::class, 'logs'])->name('admin.logs');
    Route::get('/success-stories', [AdminController::class, 'successStories'])->name('admin.success-stories');
    Route::post('/success-stories', [AdminController::class, 'createSuccessStory'])->name('admin.create-success-story');
    Route::get('/download-success-stories', [AdminController::class, 'downloadSuccessStories'])->name('admin.download-success-stories');
});