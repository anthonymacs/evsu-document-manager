<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BackupController;

// ── AUTH ROUTES ──
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});
 
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

// Dashboard
Route::get('/', function () {
    return redirect()->route('dashboard.index');
})->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Categories
Route::resource('categories', CategoryController::class)->except(['show']);

// Documents
Route::resource('documents', DocumentController::class)->except(['show']);

// Audit Logs
Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');

// About
Route::get('/about', function () {
    return view('dashboard.index');
})->name('about');

// Backup

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

Route::get('/about', fn() => view('about.index'))->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/backups',          [BackupController::class, 'index'])->name('backup.index');
    Route::post('/backups/restore', [BackupController::class, 'restore'])->name('backup.restore');
});