<?php

namespace App\Modules\Identity\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Modules\UserManagement\Models\StudentProfile;
use App\Modules\UserManagement\Models\StaffProfile;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;
    use HasFactory;
    protected $fillable = [
        'university_id',
        'type',
        'email',
        'password',
        'must_change_password',
        'is_active',
    ];

    protected static function newFactory()
{
    return \Database\Factories\UserFactory::new();
}


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'must_change_password' => 'boolean',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function studentProfile()
{
    return $this->hasOne(StudentProfile::class);
}

public function staffProfile()
{
    return $this->hasOne(StaffProfile::class);
}


}