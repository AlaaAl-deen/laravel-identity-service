<?php

namespace App\Modules\UserManagement\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\UserManagement\Services\ProfileService;
use App\Modules\UserManagement\Requests\UpdateProfileRequest;



class ProfileController extends Controller
{
    
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show(Request $request)
    {
        $user = $request->user();

        $data = $this->profileService->getProfile($user);

        return response()->json($data);
    }

      public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $this->profileService->updateProfile(
            $user,
            $request->validated()
        );

        return response()->json([
            'message' => 'Profile updated successfully'
        ]);
    }

    public function deletePhoto(Request $request)
{
    $user = $request->user();

    $this->profileService->deletePhoto($user);

    return response()->json([
        'message' => 'Profile photo deleted successfully'
    ]);
}

}
