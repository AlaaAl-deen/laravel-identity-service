<?php

namespace App\Modules\UserManagement\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\Identity\Models\User;


class StaffProfile extends Model
{
    protected $table = 'staff_profiles';

    protected $fillable = [
        'user_id',
        'name',
        'academic_rank_id',
        'specialization',
        'photo',
    ];

    public function departments()
    {
        return $this->belongsToMany(
            Department::class,
            'staff_departments',
            'staff_profile_id',
            'department_id'
        );
    }

    public function user()
{
    return $this->belongsTo(User::class);
}
}
