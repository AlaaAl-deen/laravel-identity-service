<?php

namespace App\Modules\AccessControl\Services;

use Illuminate\Support\Facades\DB;

class RoleService
{
    public function userHasRole(int $userId, string $roleSlug): bool
    {
        return DB::table('user_roles')
            ->join('roles', 'roles.id', '=', 'user_roles.role_id')
            ->where('user_roles.user_id', $userId)
            ->where('roles.slug', $roleSlug)
            ->exists();
    }

    public function getUserRoles(int $userId): array
    {
        return DB::table('user_roles')
            ->join('roles', 'roles.id', '=', 'user_roles.role_id')
            ->where('user_roles.user_id', $userId)
            ->pluck('roles.slug')
            ->toArray();
    }
}