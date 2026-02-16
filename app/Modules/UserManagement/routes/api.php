<?php

use Illuminate\Support\Facades\Route;
use App\Modules\UserManagement\Controllers\UserController;
use App\Modules\UserManagement\Controllers\MetaController;
/*
Route::prefix('api/v1')
    ->middleware(['auth:sanctum'])
   // ->middleware(['auth:sanctum', 'role:admin']) after aboody add permision
    ->group(function () {

        Route::post('/users', [UserController::class, 'store']);
    });
    */

    Route::prefix('api/v1')->group(function () {
         // Meta data
    Route::get('/meta/colleges', [MetaController::class, 'colleges']);
    Route::get('/meta/departments', [MetaController::class, 'departments']);
    Route::get('/meta/study-levels', [MetaController::class, 'studyLevels']);
    Route::get('/meta/academic-ranks', [MetaController::class, 'academicRanks']);

    // Users
    Route::post('/users', [UserController::class, 'store']);
});