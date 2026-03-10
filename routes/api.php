<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student;
use App\Http\Controllers\Teacher;
use App\Http\Controllers\Admin;

// ── PUBLIC ────────────────────────────────────────────────
Route::get('/popular-courses', [HomeController::class, 'index']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ── AUTHENTICATED ─────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // ── STUDENT ───────────────────────────────────────────
    Route::middleware('role:student')->prefix('student')->group(function () {
        Route::get('/courses', [Student\CourseController::class, 'index']);
        Route::get('/basket', [Student\BasketController::class, 'index']);
        Route::post('/enroll', [Student\EnrollmentController::class, 'store']);
        Route::get('/my-courses', [Student\MyCourseController::class, 'index']);
        Route::delete('/enrollment/{package}', [Student\EnrollmentController::class, 'destroy']);
    });

    // ── TEACHER ───────────────────────────────────────────
    Route::middleware('role:teacher')->prefix('teacher')->group(function () {
        Route::get('/courses', [Teacher\CourseController::class, 'index']);
        Route::post('/courses', [Teacher\CourseController::class, 'store']);
    });

    // ── ADMIN ─────────────────────────────────────────────
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/users', [Admin\UserController::class, 'index']);
        Route::put('/users/{user}', [Admin\UserController::class, 'update']);
        Route::delete('/users/{user}', [Admin\UserController::class, 'destroy']);

        Route::get('/courses', [Admin\CourseController::class, 'index']);
        Route::put('/courses/{course}', [Admin\CourseController::class, 'update']);
        Route::delete('/courses/{course}', [Admin\CourseController::class, 'destroy']);

        Route::get('/programs', [Admin\ProgramController::class, 'index']);
        Route::put('/programs/{program}', [Admin\ProgramController::class, 'update']);

        Route::get('/packages', [Admin\PackageController::class, 'index']);
        Route::put('/packages/{package}', [Admin\PackageController::class, 'update']);
    });
});