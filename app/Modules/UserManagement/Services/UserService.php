<?php

namespace App\Modules\UserManagement\Services;

use App\Modules\Identity\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Modules\UserManagement\Models\StudentProfile;
use App\Modules\UserManagement\Models\StaffProfile;

class UserService
{
  public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {

            // 1) إنشاء المستخدم
            $user = User::create([
                'university_id' => $data['university_id'],
                'type' => $data['type'],
                'password' => $data['password'],
                'must_change_password' => true,
                'is_active' => true,
            ]);

            // 2) إنشاء profile حسب النوع
            if ($data['type'] === 'student') {
                $this->createStudentProfile($user->id, $data);
            }

            if ($data['type'] === 'staff') {
                $this->createStaffProfile($user->id, $data);
            }

            return $user;
        });
    }

    protected function createStudentProfile(int $userId, array $data): void
    {
        StudentProfile::create([
            'user_id' => $userId,
            'name' => $data['name'],
            'college_id' => $data['college_id'],
            'department_id' => $data['department_id'],
            'study_level_id' => $data['study_level_id'],
        ]);
    }

    protected function createStaffProfile(int $userId, array $data): void
    {
        $staff = StaffProfile::create([
            'user_id' => $userId,
            'name' => $data['name'],
            'academic_rank_id' => $data['academic_rank_id'] ?? null,
            'specialization' => $data['specialization'] ?? null,
        ]);

        // ربط الأقسام إن وُجدت
        if (!empty($data['department_ids'])) {
            $staff->departments()->sync($data['department_ids']);
        }
    }

    // =============================
    // show all users
    // =============================

    public function getAllUsers()
{
    return User::with(['studentProfile', 'staffProfile'])
        ->select('id', 'university_id', 'type', 'email', 'is_active')
        ->get()
        ->map(function ($user) {
            $name = null;

            if ($user->type === 'student' && $user->studentProfile) {
                $name = $user->studentProfile->name;
            }

            if ($user->type === 'staff' && $user->staffProfile) {
                $name = $user->staffProfile->name;
            }

            return [
                'id' => $user->id,
                'university_id' => $user->university_id,
                'type' => $user->type,
                'email' => $user->email,
                'is_active' => $user->is_active,
                'name' => $name,
            ];
        });
}

// =============================
    // show one user
    // =============================

public function getUserById(int $id): array
{
    $user = User::with([
        'studentProfile.college',
        'studentProfile.department',
        'studentProfile.studyLevel',
        'staffProfile.academicRank',
    ])->findOrFail($id);

    if ($user->type === 'student' && $user->studentProfile) {
        $profile = $user->studentProfile;

        return [
            'id' => $user->id,
            'university_id' => $user->university_id,
            'type' => $user->type,
            'email' => $user->email,
            'is_active' => $user->is_active,
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
            'is_active' => $user->is_active,
            'profile' => [
                'name' => $profile->name,
                'academic_rank' => optional($profile->academicRank)->name,
                'specialization' => $profile->specialization,
                'photo' => $profile->photo,
            ],
        ];
    }

    return [
        'id' => $user->id,
        'university_id' => $user->university_id,
        'type' => $user->type,
        'email' => $user->email,
        'is_active' => $user->is_active,
        'profile' => null,
    ];
}

// =============================
    // Update user
    // =============================
public function updateUser(int $id, array $data): void
{
    DB::transaction(function () use ($id, $data) {

        $user = User::with(['studentProfile', 'staffProfile'])->findOrFail($id);

        // update state of count
        if (isset($data['is_active'])) {
            $user->is_active = $data['is_active'];
            $user->save();
        }

        // =============================
        // srtudent
        // =============================
        if ($user->type === 'student' && $user->studentProfile) {
            $profile = $user->studentProfile;

            if (isset($data['name'])) {
                $profile->name = $data['name'];
            }

            if (isset($data['college_id'])) {
                $profile->college_id = $data['college_id'];
            }

            if (isset($data['department_id'])) {
                $profile->department_id = $data['department_id'];
            }

            if (isset($data['study_level_id'])) {
                $profile->study_level_id = $data['study_level_id'];
            }

            $profile->save();
        }

        // =============================
        // Empoly
        // =============================
        if ($user->type === 'staff' && $user->staffProfile) {
            $profile = $user->staffProfile;

            if (isset($data['name'])) {
                $profile->name = $data['name'];
            }

            if (array_key_exists('academic_rank_id', $data)) {
                $profile->academic_rank_id = $data['academic_rank_id'];
            }

            if (isset($data['specialization'])) {
                $profile->specialization = $data['specialization'];
            }

            $profile->save();

            // update department
            if (isset($data['department_ids'])) {
                $profile->departments()->sync($data['department_ids']);
            }
        }
    });
}

// =============================
    // Update user state
    // =============================
public function updateUserStatus(int $id, bool $isActive): void
{
    $user = User::findOrFail($id);

    $user->is_active = $isActive;
    $user->save();
}


}
