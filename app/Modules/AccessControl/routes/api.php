<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'admin',
            'message' => 'Admin access granted'
        ]));
    });

    Route::middleware('role:student')->prefix('student')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'student',
            'message' => 'Student access granted'
        ]));
    });

    Route::middleware('role:supervisor')->prefix('supervisor')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'supervisor',
            'message' => 'Supervisor access granted'
        ]));
    });

    Route::middleware('role:project_committee')->prefix('committee')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'project_committee',
            'message' => 'Committee access granted'
        ]));
    });

    Route::middleware('role:head_of_department')->prefix('hod')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'head_of_department',
            'message' => 'Head of Department access granted'
        ]));
    });

    Route::middleware('role:college_admin')->prefix('college')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'college_admin',
            'message' => 'College Admin access granted'
        ]));
    });

    Route::middleware('role:university_presidency')->prefix('presidency')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'university_presidency',
            'message' => 'University Presidency access granted'
        ]));
    });

    Route::middleware('role:guest')->prefix('guest')->group(function () {
        Route::get('/dashboard', fn () => response()->json([
            'role' => 'guest',
            'message' => 'Guest access granted'
        ]));
    });

});