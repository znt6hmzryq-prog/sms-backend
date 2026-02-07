<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'me']);

    // Example protected route for admins only
    Route::get('/admin-only', function () {
        return response()->json(['message' => 'admin access granted']);
    })->middleware(RoleMiddleware::class . ':admin');
    
    // Students API - controller enforces role protection (admin full CRUD, teacher read)
    Route::apiResource('students', \App\Http\Controllers\Api\StudentController::class);
    Route::apiResource('teachers', \App\Http\Controllers\Api\TeacherController::class);
    Route::apiResource('subjects', \App\Http\Controllers\Api\SubjectController::class);
    Route::apiResource('attendances', \App\Http\Controllers\Api\AttendanceController::class);
    Route::apiResource('exams', \App\Http\Controllers\Api\ExamController::class);
    Route::apiResource('grades', \App\Http\Controllers\Api\GradeController::class);
    Route::apiResource('messages', \App\Http\Controllers\Api\MessageController::class);
});
