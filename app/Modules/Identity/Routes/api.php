<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Identity\Controllers\AuthController;

Route::prefix('v1/auth')->group(function () {

    Route::post('login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1');

    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])
        ->middleware('throttle:3,1');

    Route::post('reset-password', [AuthController::class, 'resetPassword'])
        ->middleware('throttle:5,1');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::post('add-email', [AuthController::class, 'addEmail']);
        Route::post('email/resend', [AuthController::class, 'resendVerification']);
        Route::post('email/update', [AuthController::class, 'updateEmail']);

        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('logout-all', [AuthController::class, 'logoutAll']);
    });
});
