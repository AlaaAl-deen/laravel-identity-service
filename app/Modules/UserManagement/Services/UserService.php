<?php

namespace App\Modules\UserManagement\Services;

use App\Modules\Identity\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(array $data): array
    {
        $user = User::create([
            'university_id' => $data['universityId'],
            'password' => Hash::make($data['password']),
            'must_change_password' => true,
        ]);

        return [
            'status' => true,
            'message' => 'User created successfully',
            'userId' => $user->id,
        ];
    }
}
