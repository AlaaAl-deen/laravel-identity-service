<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitialMetaSeeder extends Seeder
{
    public function run(): void
    {
         // =============================
    // الجامعة
    // =============================
    $universityId = DB::table('universities')->insertGetId([
        'name' => 'جامعة تجريبية',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // =============================
    // الكلية
    // =============================
    $collegeId = DB::table('colleges')->insertGetId([
        'name' => 'كلية علوم وهندسة الحاسوب',
        'university_id' => $universityId,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
        // =============================
        // الأقسام
        // =============================
        DB::table('departments')->insert([
            [
                'name' => 'تقنية معلومات',
                'college_id' => $collegeId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'علوم حاسوب',
                'college_id' => $collegeId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'هندسة حاسوب',
                'college_id' => $collegeId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // =============================
        // المرحلة الدراسية
        // =============================
        DB::table('study_levels')->insert([
            'name' => 'بكالوريوس',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // =============================
        // الدرجات العلمية
        // =============================
        DB::table('academic_ranks')->insert([
            [
                'name' => 'بروفيسور',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'أستاذ مشارك',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'أستاذ مساعد',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'محاضر',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

                // =============================
        // إنشاء مستخدم Admin
        // =============================
        $adminId = DB::table('users')->insertGetId([
            'university_id' => 'admin2026',
            'type' => 'staff',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'must_change_password' => false,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('staff_profiles')->insert([
            'user_id' => $adminId,
            'name' => 'System Admin',
            'academic_rank_id' => null,
            'specialization' => null,
            'photo' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
