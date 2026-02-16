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
}
