<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// عملية الربط

require app_path('Modules/Identity/Routes/api.php');

require base_path('app/Modules/UserManagement/routes/api.php');

