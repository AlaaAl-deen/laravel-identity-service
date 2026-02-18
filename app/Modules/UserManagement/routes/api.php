<?php

use Illuminate\Support\Facades\Route;
use App\Modules\UserManagement\Controllers\UserController;
use App\Modules\UserManagement\Controllers\MetaController;
use App\Modules\UserManagement\Controllers\ProfileController;

/*
Route::prefix('api/v1')
    ->middleware(['auth:sanctum'])
   // ->middleware(['auth:sanctum', 'role:admin']) after aboody add permision
    ->group(function () {

        Route::post('/users', [UserController::class, 'store']);
    });
    */

    Route::prefix('api/v1')->group(function () {

    // =============================
    // Meta data (بدون توكن)
    // =============================
    Route::get('/meta/colleges', [MetaController::class, 'colleges']);
    Route::get('/meta/departments', [MetaController::class, 'departments']);
    Route::get('/meta/study-levels', [MetaController::class, 'studyLevels']);
    Route::get('/meta/academic-ranks', [MetaController::class, 'academicRanks']);

    // =============================
    // عمليات المستخدم نفسه
    // =============================
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::put('/profile/photo', [ProfileController::class, 'update']);
        Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto']);
    });

    // =============================
    // عمليات مدير النظام
    // =============================
   // Route::middleware(['auth:sanctum', 'permission:manage users'])->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::patch('/users/{id}/status', [UserController::class, 'updateStatus']);

    });

});
