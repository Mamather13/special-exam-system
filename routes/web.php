<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LoginController;

//login
Route::post('/login', [LoginController::class, 'login']);

// Root redirect
Route::get('/', function () {
    return redirect()->route('landing.page');
});

// Landing page
Route::get('/landing', function () {
    return view('landing-page');
})->name('landing.page');

// Student
Route::get('/student', [StudentController::class, 'dashboard'])->name('student.dashboard');
Route::get('/student/get-subjects', [StudentController::class, 'getSubjects']);
Route::get('/get-subjects', [SubjectController::class, 'getSubjects']);
Route::get('/get-sections', [SubjectController::class, 'getSections']);
Route::post('/student/submit-request', [RequestController::class, 'store']);
Route::get('/get-programs', [SubjectController::class, 'getPrograms']);

// Teacher
Route::get('/teacher', function () {
    return view('teacher-dashboard');
})->name('teacher.dashboard');
Route::get('/subject', function () {
    return view('teacher-subject');
})->name('teacher.subject');

// Program Head
Route::get('/head', function () {
    return view('head-dashboard');
})->name('head.dashboard');

// Registrar
Route::get('/registrar/dashboard', function () {
    return view('registrar.dashboard');
})->name('registrar.dashboard');
Route::get('/registrar/courses', function () {
    return view('registrar.courses');
})->name('registrar.courses');
Route::get('/registrar/submissions/{course}', function ($course) {
    return view('registrar.submissions', ['course' => $course]);
})->name('registrar.submissions');

// Subjects API
Route::get('/get-subjects', [SubjectController::class, 'getSubjects']);

require __DIR__.'/settings.php';