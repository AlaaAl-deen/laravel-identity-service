<?php

namespace App\Modules\Identity\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Modules\Identity\Services\AuthService;

use App\Modules\Identity\Requests\LoginRequest;
use App\Modules\Identity\Requests\ChangePasswordRequest;
use App\Modules\Identity\Requests\AddEmailRequest;
use App\Modules\Identity\Requests\ResendEmailRequest;
use App\Modules\Identity\Requests\UpdateEmailRequest;
use App\Modules\Identity\Requests\ForgotPasswordRequest;
use App\Modules\Identity\Requests\ResetPasswordRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request, AuthService $authService): JsonResponse
    {
        return response()->json(
            $authService->login($request->validated())
        );
    }

    public function changePassword(ChangePasswordRequest $request, AuthService $authService): JsonResponse
    {
        return response()->json(
            $authService->changePassword($request->validated())
        );
    }

    public function addEmail(AddEmailRequest $request, AuthService $authService): JsonResponse
    {
        return response()->json(
            $authService->addEmail($request->validated())
        );
    }

    public function resendVerification(AuthService $authService): JsonResponse
    {
        return response()->json(
            $authService->resendVerification()
        );
    }

    public function updateEmail(UpdateEmailRequest $request, AuthService $authService): JsonResponse
    {
        return response()->json(
            $authService->updateEmail($request->validated())
        );
    }

    public function forgotPassword(ForgotPasswordRequest $request, AuthService $authService): JsonResponse
    {
        return response()->json(
            $authService->forgotPassword($request->validated())
        );
    }

    public function resetPassword(ResetPasswordRequest $request, AuthService $authService): JsonResponse
    {
        return response()->json(
            $authService->resetPassword($request->validated())
        );
    }

    public function logout(AuthService $authService): JsonResponse
    {
        return response()->json(
            $authService->logout()
        );
    }

    public function logoutAll(AuthService $authService): JsonResponse
    {
        return response()->json(
            $authService->logoutAll()
        );
    }
}