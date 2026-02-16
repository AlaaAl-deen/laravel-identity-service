<?php

namespace App\Modules\UserManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\UserManagement\Models\College;
use App\Modules\UserManagement\Models\Department;
use App\Modules\UserManagement\Models\StudyLevel;
use App\Modules\UserManagement\Models\AcademicRank;

class MetaController extends Controller
{
    public function colleges()
    {
        return response()->json(
            College::select('id', 'name')->get()
        );
    }

    public function departments()
    {
        return response()->json(
            Department::select('id', 'name', 'college_id')->get()
        );
    }

    public function studyLevels()
    {
        return response()->json(
            StudyLevel::select('id', 'name')->get()
        );
    }

    public function academicRanks()
    {
        return response()->json(
            AcademicRank::select('id', 'name')->get()
        );
    }
}
