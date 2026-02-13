<?php

namespace App\Modules\AccessControl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Modules\AccessControl\Services\RoleService;

class RequireRole
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function handle(Request $request, Closure $next, string $roles)
{
    $user = $request->user();

    if (!$user) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    $rolesArray = explode('|', $roles);

    foreach ($rolesArray as $role) {
        if ($this->roleService->userHasRole($user->id, $role)) {
            return $next($request);
        }
    }

    return response()->json(['message' => 'Forbidden'], 403);
}

}