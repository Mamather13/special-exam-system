<?php

use Illuminate\Support\Facades\Route;


// 1. Root Redirect (Prevents 404 on the home page)
Route::get('/', function () {
    return redirect()->route('landing.page');
});

// 2. The Landing Page
Route::get('/landing', function () {
    return view('landing-page');
})->name('landing.page'); 


// 4. Portal Routes (Consider adding 'auth' middleware later)
Route::get('/student', function () {
    return view('student-dashboard');
})->name('student.dashboard');

Route::get('/teacher', function () {
    return view('teacher-dashboard');
})->name('teacher.dashboard');

Route::get('/subject', function () {
    return view('teacher-subject');
})->name('teacher.subject');

Route::get('/head', function () {
    return view('head-dashboard');
})->name('head.dashboard');

Route::get('/registrar/dashboard', function () {
    return view('registrar.dashboard'); // Points to registrar/dashboard.blade.php
})->name('registrar.dashboard');

Route::get('/registrar/courses', function () {
    return view('registrar.courses');
})->name('registrar.courses');

Route::get('/registrar/submissions/{course}', function ($course) {
    return view('registrar.submissions', ['course' => $course]);
})->name('registrar.submissions');

require __DIR__.'/settings.php';