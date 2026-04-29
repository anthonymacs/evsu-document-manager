<?php

// routes/web.php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/home', function () {
    return redirect()->route('dashboard.index');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard.index');

Route::get('/categories', function () {
    return view('categories.index');
})->name('categories.index');

Route::get('/documents', function () {
    return view('documents.index');
})->name('documents.index');

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