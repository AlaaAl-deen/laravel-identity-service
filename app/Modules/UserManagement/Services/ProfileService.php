<?php

namespace App\Modules\UserManagement\Services;

use App\Modules\Identity\Models\User;

use Illuminate\Support\Facades\Storage;
use App\Modules\UserManagement\Models\StudentProfile;
use App\Modules\UserManagement\Models\StaffProfile;

class ProfileService
{
    public function getProfile(User $user): array
    {
        if ($user->type === 'student' && $user->studentProfile) {
            $profile = $user->studentProfile;

            return [
                'id' => $user->id,
                'university_id' => $user->university_id,
                'type' => $user->type,
                'email' => $user->email,
                'profile' => [
                    'name' => $profile->name,
                    'college' => optional($profile->college)->name,
                    'department' => optional($profile->department)->name,
                    'study_level' => optional($profile->studyLevel)->name,
                    'photo' => $profile->photo,
                ],
            ];
        }

        if ($user->type === 'staff' && $user->staffProfile) {
            $profile = $user->staffProfile;

            return [
                'id' => $user->id,
                'university_id' => $user->university_id,
                'type' => $user->type,
                'email' => $user->email,
                'profile' => [
                    'name' => $profile->name,
                    'academic_rank' => optional($profile->academicRank)->name,
                    'specialization' => $profile->specialization,
                    'photo' => $profile->photo,
                ],
            ];
        }

        // في حال لا يوجد profile
        return [
            'id' => $user->id,
            'university_id' => $user->university_id,
            'type' => $user->type,
            'email' => $user->email,
            'profile' => null,
        ];
    }

   public function updateProfile(User $user, array $data): void
{
    if (!isset($data['photo'])) {
        return;
    }

    // الطالب
    if ($user->type === 'student' && $user->studentProfile) {
        $profile = $user->studentProfile;

        // حذف الصورة القديمة إن وجدت
        if ($profile->photo) {
            Storage::disk('public')->delete($profile->photo);
        }

        $path = $data['photo']->store('profiles', 'public');
        $profile->photo = $path;
        $profile->save();
    }

    // الموظف
    if ($user->type === 'staff' && $user->staffProfile) {
        $profile = $user->staffProfile;

        // حذف الصورة القديمة إن وجدت
        if ($profile->photo) {
            Storage::disk('public')->delete($profile->photo);
        }

        $path = $data['photo']->store('profiles', 'public');
        $profile->photo = $path;
        $profile->save();
    }
}


public function deletePhoto(User $user): void
{
    if ($user->type === 'student' && $user->studentProfile) {
        $profile = $user->studentProfile;

        if ($profile->photo) {
            Storage::disk('public')->delete($profile->photo);
            $profile->photo = null;
            $profile->save();
        }
    }

    if ($user->type === 'staff' && $user->staffProfile) {
        $profile = $user->staffProfile;

        if ($profile->photo) {
            Storage::disk('public')->delete($profile->photo);
            $profile->photo = null;
            $profile->save();
        }
    }
}
}
