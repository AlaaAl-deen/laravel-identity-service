<?php

namespace App\Modules\Identity\Services;

use App\Modules\Identity\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthService
{
    public function login(array $data): array
    {
        $user = User::where('university_id', $data['universityId'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return [
                'message' => 'Invalid credentials',
            ];
        }

        if ($user->must_change_password) {
            $token = $user->createToken('setup-token')->plainTextToken;

            return [
                'status' => 'mustChangePassword',
                'setupToken' => $token,
            ];
        }

        if (!$user->hasVerifiedEmail()) {
            $token = $user->createToken('setup-token')->plainTextToken;

            return [
                'status' => 'emailNotVerified',
                'setupToken' => $token,
            ];
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'status' => 'ok',
            'token' => $token,
            'userId' => $user->id,
        ];
    }

    public function changePassword(array $data): array
    {
        $user = auth()->user();

        $user->password = $data['newPassword'];
        $user->must_change_password = false;
        $user->save();

        return [
            'status' => 'mustAddEmail',
            'message' => 'Password changed successfully',
        ];
    }

    public function addEmail(array $data): array
    {
        $user = auth()->user();

        $user->email = $data['email'];
        $user->email_verified_at = null;
        $user->save();

        $user->sendEmailVerificationNotification();

        return [
            'status' => 'emailVerificationRequired',
            'message' => 'Please verify your email',
        ];
    }

    public function resendVerification(): array
    {
        $user = auth()->user();

        if (!$user->email) {
            return [
                'message' => 'Invalid request',
            ];
        }

        if ($user->hasVerifiedEmail()) {
            return [
                'status' => 'alreadyVerified',
            ];
        }

        $user->sendEmailVerificationNotification();

        return [
            'status' => 'emailVerificationRequired',
            'message' => 'Verification link resent',
        ];
    }

    public function updateEmail(array $data): array
    {
        $user = auth()->user();

        if ($user->hasVerifiedEmail()) {
            return [
                'status' => 'alreadyVerified',
            ];
        }

        $user->email = $data['email'];
        $user->email_verified_at = null;
        $user->save();

        $user->sendEmailVerificationNotification();

        return [
            'status' => 'emailVerificationRequired',
            'message' => 'Email updated. Verification link sent.',
        ];
    }

    public function forgotPassword(array $data): array
    {
        $user = User::where('university_id', $data['universityId'])->first();

        if ($user && $user->email) {
            Password::sendResetLink([
                'email' => $user->email,
            ]);
        }

        return [
            'status' => 'ok',
            'message' => 'If the account exists, a reset link has been sent.',
        ];
    }

    public function resetPassword(array $data): array
    {
        $status = Password::reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $data['password_confirmation'],
                'token' => $data['token'],
            ],
            function ($user, $password) {
                $user->password = $password;
                $user->must_change_password = false;
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return [
                'status' => 'passwordReset',
                'message' => 'Password has been reset successfully.',
            ];
        }

        return [
            'message' => 'Invalid or expired reset link.',
        ];
    }

    public function logout(): array
    {
        $user = auth()->user();
        $user->currentAccessToken()->delete();

        return [
            'status' => 'loggedOut',
            'message' => 'Logged out successfully',
        ];
    }

    public function logoutAll(): array
    {
        $user = auth()->user();
        $user->tokens()->delete();

        return [
            'status' => 'loggedOutAll',
            'message' => 'Logged out from all devices',
        ];
    }
}
