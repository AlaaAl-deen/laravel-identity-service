<?php

namespace App\Modules\UserManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\UserManagement\Requests\StoreUserRequest;
use App\Modules\UserManagement\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function store(StoreUserRequest $request, UserService $service): JsonResponse
    {
        $result = $service->create($request->validated());

        return response()->json($result);
    }
}
