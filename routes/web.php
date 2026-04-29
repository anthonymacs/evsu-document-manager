<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;

Route::get('/', function () {
    return redirect()->route('homepage');
})->name('homepage');

//Route::get('/', function () {
//    return redirect()->route('dashboard.index');
//});

Route::get('/home', function () {
    return redirect()->route('dashboard.index');
})->name('home');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Categories
Route::resource('categories', CategoryController::class)->except(['show']);

// Documents
Route::resource('documents', DocumentController::class)->except(['show']);

Route::get('/audit-logs', function () {
    return view('auditlogs.index');
})->name('audit-logs.index');

Route::get('/profile', function () {
    return view('dashboard.index');
})->name('profile');

Route::get('/users', function () {
    return view('dashboard.index');
})->name('users.index');

Route::get('/approvals', function () {
    return view('dashboard.index');
})->name('approvals.index');

Route::get('/uploads', function () {
    return view('dashboard.index');
})->name('uploads.index');

Route::get('/read-later', function () {
    return view('dashboard.index');
})->name('read-later.index');