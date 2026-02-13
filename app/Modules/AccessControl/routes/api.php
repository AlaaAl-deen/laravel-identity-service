<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {

    // =============================
    // Student
    // =============================
    Route::middleware('role:student')->prefix('student')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'student',
            'message' => 'Student access granted'
        ]));
    });

    // =============================
    // Supervisor
    // =============================
    Route::middleware('role:supervisor')->prefix('supervisor')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'supervisor',
            'message' => 'Supervisor access granted'
        ]));
    });

    // =============================
    // Project Committee
    // =============================
    Route::middleware('role:project_committee')->prefix('committee')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'project_committee',
            'message' => 'Committee access granted'
        ]));
    });

    // =============================
    // Head of Department
    // =============================
    Route::middleware('role:head_of_department')->prefix('hod')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'head_of_department',
            'message' => 'Head of Department access granted'
        ]));
    });

    // =============================
    // College Admin
    // =============================
    Route::middleware('role:college_admin')->prefix('college')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'college_admin',
            'message' => 'College Admin access granted'
        ]));
    });

    // =============================
    // University Presidency
    // =============================
    Route::middleware('role:university_presidency')->prefix('presidency')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'university_presidency',
            'message' => 'University Presidency access granted'
        ]));
    });

    // =============================
    // Admin
    // =============================
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'admin',
            'message' => 'Admin access granted'
        ]));
    });

    // =============================
    // Guest
    // =============================
    Route::middleware('role:guest')->prefix('guest')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'guest',
            'message' => 'Guest access granted'
        ]));
    });

});