<?php

namespace App\Modules\UserManagement\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\Identity\Models\User;


class StudentProfile extends Model
{
    protected $table = 'student_profiles';

  protected $fillable = [
    'user_id',
    'name',
    'college_id',
    'department_id',
    'study_level_id',
    'photo',
];
 
  public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function studyLevel()
    {
        return $this->belongsTo(StudyLevel::class);
    }

}
