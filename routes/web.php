<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\Auth\LoginController;
use Carbon\Carbon;

// Home
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Routes (Only accessible when NOT logged in)
Route::middleware('guest')->group(function () {

    // Login Page
    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    // Login Submit
    Route::post('/login', [LoginController::class, 'store']);
});

// Protected Routes (Must login first)
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index');

    // Categories
    Route::resource('categories', CategoryController::class)
        ->except(['show']);

    // Documents
    Route::resource('documents', DocumentController::class)
        ->except(['show']);

    // Audit Logs
    Route::get('/audit-logs', [AuditLogController::class, 'index'])
        ->name('audit-logs.index');

    // About
    Route::get('/about', fn() => view('about.index'))
        ->name('about');

    // Users
    Route::get('/users', function () {
        return view('dashboard.index');
    })->name('users.index');

    // Approvals
    Route::get('/approvals', function () {
        return view('dashboard.index');
    })->name('approvals.index');

    // Uploads
    Route::get('/uploads', function () {
        return view('dashboard.index');
    })->name('uploads.index');

    // Read Later
    Route::get('/read-later', function () {
        return view('dashboard.index');
    })->name('read-later.index');

    // Debug
    Route::get('/debug', function () {
        dd(Carbon::now());
    });
});

// Logout
Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');