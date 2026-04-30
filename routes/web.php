<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProgramHeadController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::post('/login', [LoginController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('landing.page');
});

Route::get('/landing', function () {
    return view('landing-page');
})->name('landing.page');

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/
Route::prefix('student')->group(function () {
    Route::get('/', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/get-subjects', [StudentController::class, 'getSubjects']);
    Route::post('/submit-request', [RequestController::class, 'store']);
});

Route::get('/get-subjects', [SubjectController::class, 'getSubjects']);
Route::get('/get-sections', [SubjectController::class, 'getSections']);
Route::get('/get-programs', [SubjectController::class, 'getPrograms']);

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/
Route::prefix('teacher')->group(function () {
    Route::get('/', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::post('/approve/{id}', [TeacherController::class, 'approve'])->name('teacher.approve');
    Route::post('/reject/{id}', [TeacherController::class, 'reject'])->name('teacher.reject');
});

/*
|--------------------------------------------------------------------------
| Program Head Routes
|--------------------------------------------------------------------------
*/
Route::prefix('head')->group(function () {
    Route::get('/', [ProgramHeadController::class, 'dashboard'])->name('head.dashboard');
    Route::get('/course/{program}', [ProgramHeadController::class, 'course'])->name('head.course');
    Route::get('/department-data', [ProgramHeadController::class, 'departmentData']);
    Route::get('/export-excel', [ProgramHeadController::class, 'exportExcel']);
});

/*
|--------------------------------------------------------------------------
| Registrar Routes
|--------------------------------------------------------------------------
*/
Route::prefix('registrar')->group(function () {

    Route::get('/dashboard', [RegistrarController::class, 'dashboard'])
        ->name('registrar.dashboard');

    Route::get('/courses/{type}', [RegistrarController::class, 'courses'])
        ->name('registrar.courses');

    Route::get('/submissions/{course}', [RegistrarController::class, 'submissions'])
        ->name('registrar.submissions');

});
/*
|--------------------------------------------------------------------------
| logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Settings
|--------------------------------------------------------------------------
*/
require __DIR__.'/settings.php';