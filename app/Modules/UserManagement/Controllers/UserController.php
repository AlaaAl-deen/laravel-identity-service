<?php

namespace App\Modules\UserManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\UserManagement\Requests\StoreUserRequest;
use App\Modules\UserManagement\Requests\UpdateUserRequest;
use App\Modules\UserManagement\Requests\UpdateUserStatusRequest;
use App\Modules\UserManagement\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // =============================
    // create users
    // =============================

    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->createUser(
            $request->validated()
        );

        return response()->json([
            'message' => 'User created successfully',
            'user_id' => $user->id,
        ], 201);
    }

    // =============================
    // show all users
    // =============================

     public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();

        return response()->json($users);
    }

     // =============================
    // show one user
    // =============================

    public function show(int $id): JsonResponse
{
    $user = $this->userService->getUserById($id);

    return response()->json($user);
}


     // =============================
    // Update user
    // =============================
public function update(UpdateUserRequest $request, int $id): JsonResponse
{
    $this->userService->updateUser(
        $id,
        $request->validated()
    );

    return response()->json([
        'message' => 'User updated successfully'
    ]);
}

  // =============================
    // Update user state
    // =============================

public function updateStatus(UpdateUserStatusRequest $request, int $id): JsonResponse
{
    $this->userService->updateUserStatus(
        $id,
        $request->validated()['is_active']
    );

    return response()->json([
        'message' => 'User status updated successfully'
    ]);
}

}
