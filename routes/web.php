<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::get('/teacher', function () {
    return view('teacher-dashboard');
})->name('teacher.dashboard');

Route::get('/subject', function () {
    return view('teacher-subject');
})->name('teacher.subject');

Route::get('/head', function () {
    return view('head-dashboard');
})->name('head.dashboard');

require __DIR__.'/settings.php';
