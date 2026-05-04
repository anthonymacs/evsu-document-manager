<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AuditLogController;


Route::get('/', function () {
    return view('homepage.index');
})->name('homepage');

// Optional: redirect /home to dashboard
Route::get('/home', function () {
    return redirect()->route('dashboard.index');
})->name('home');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Categories
Route::resource('categories', CategoryController::class)->except(['show']);

// Documents
Route::resource('documents', DocumentController::class)->except(['show']);

// Audit Logs
Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');

// Profile
Route::get('/profile', function () {
    return view('dashboard.index');
})->name('profile');

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