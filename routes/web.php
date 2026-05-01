<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProgramHeadController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Student\ReceiptUploadController;
use App\Http\Controllers\ProgramHead\FinalApprovalController;


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

Route::prefix('student')->name('student.')->group(function () {
    Route::get('/applications/{id}/upload-receipt',
        [ReceiptUploadController::class, 'show'])
        ->name('application.upload-receipt');
    Route::post('/applications/{id}/submit-receipt',
        [ReceiptUploadController::class, 'store'])
        ->name('application.submit-receipt');
});
Route::post('/student/upload-receipt/{id}', [App\Http\Controllers\StudentController::class, 'uploadReceipt'])
    ->name('student.upload.receipt');
/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/
Route::prefix('teacher')->group(function () {

    Route::get('/', [TeacherController::class, 'dashboard'])
        ->name('teacher.dashboard');

    Route::get('/approve/{id}', [TeacherController::class, 'approve'])
        ->name('teacher.approve');

    Route::get('/reject/{id}', [TeacherController::class, 'reject'])
        ->name('teacher.reject');

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
    Route::get('/approve/{id}', [ProgramHeadController::class, 'approve'])
    ->name('head.approve');
    Route::get('/final-approve/{id}', [ProgramHeadController::class, 'finalApprove'])
        ->name('head.approve');
    Route::get('/reject/{id}', [ProgramHeadController::class, 'reject'])
        ->name('head.reject');
});

Route::middleware(['auth', 'role:program_head'])->prefix('program-head')->name('program_head.')->group(function () {
 
    // ... your existing routes ...
 
    // Final approval — receipt review
    Route::get('/applications/{application}/review-receipt',
        [FinalApprovalController::class, 'show'])
        ->name('applications.review-receipt');
 
    // Serve the receipt image/PDF securely
    Route::get('/applications/{application}/receipt',
        [FinalApprovalController::class, 'serveReceipt'])
        ->name('applications.receipt');
 
    // Handle approve / reject
    Route::patch('/applications/{application}/final-decision',
        [FinalApprovalController::class, 'decision'])
        ->name('applications.final-decision');
 
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
    Route::get('/approve/{id}', [RegistrarController::class, 'approve'])
    ->name('registrar.approve');
    Route::get('/reject/{id}', [RegistrarController::class, 'reject'])
    ->name('registrar.reject');
    Route::get('/final-approve/{id}', [ProgramHeadController::class, 'finalApprove'])
    ->name('head.final-approve');

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
