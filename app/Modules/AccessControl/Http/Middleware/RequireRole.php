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

    public function handle(Request $request, Closure $next, string $role)
    {
        $user = $request->user();

        // إذا لم يكن مسجل دخول
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        // إذا لا يملك الدور المطلوب
        if (!$this->roleService->userHasRole($user->id, $role)) {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        return $next($request);
    }
}