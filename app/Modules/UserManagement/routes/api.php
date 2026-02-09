<?php

use Illuminate\Support\Facades\Route;
use App\Modules\UserManagement\Controllers\UserController;

Route::prefix('v1/auth')->group(function () {
    Route::post('users', [UserController::class, 'store']);
});