<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Identity\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Modules\Identity\Models\User;
use Illuminate\Support\Facades\URL;

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


/*
|--------------------------------------------------------------------------
| Email Verification Route (مهم جدًا)
|--------------------------------------------------------------------------
*/

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'message' => 'User not found',
        ], 404);
    }

    if (!URL::hasValidSignature($request)) {
        return response()->json([
            'message' => 'Invalid or expired verification link',
        ], 403);
    }

    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return response()->json([
            'message' => 'Invalid verification hash',
        ], 403);
    }

    if ($user->hasVerifiedEmail()) {
        return redirect('/dev-ui/login.html?verified=1');
    }

    $user->markEmailAsVerified();

    // note this is links in frontend just now for Testing
    return redirect('/dev-ui/login.html?verified=1');
})->middleware('signed')->name('verification.verify');


/*
|--------------------------------------------------------------------------
| Password Reset Route
|--------------------------------------------------------------------------
*/

Route::get('/reset-password', function (Request $request) {
    $token = $request->query('token');
    $email = $request->query('email');

// note this is links in frontend just now for Testing
    return redirect("/dev-ui/reset-password.html?token=$token&email=$email");
})->name('password.reset');