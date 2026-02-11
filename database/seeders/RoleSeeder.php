<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'slug' => 'Administrator',
                'name' => 'مسئول',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'Student',
                'name' => 'طالب',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'Supervisor',
                'name' => 'مشرف',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'slug'  => 'project_committee',
                'name' => 'لجنة موافقة مشاريع',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'slug'  => 'head_of_department',
                'name' => 'رئيس قسم',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'slug'  => 'college_admin',
                'name' => 'كلية',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'slug'  => 'university_presidency',
                'snameg' => 'رئاسة الجامعة',
                'created_at' => now(),
                'updated_at' => now(),
            ],
              [
                'slug'  => 'guest',
                'name' => 'زائر',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            
        ]);
    }
}