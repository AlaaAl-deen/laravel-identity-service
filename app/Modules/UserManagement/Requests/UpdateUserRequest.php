<?php

namespace App\Modules\UserManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_active' => ['sometimes', 'boolean'],

            // بيانات الطالب
            'name' => ['sometimes', 'string', 'max:255'],
            'college_id' => ['sometimes', 'exists:colleges,id'],
            'department_id' => ['sometimes', 'exists:departments,id'],
            'study_level_id' => ['sometimes', 'exists:study_levels,id'],

            // بيانات الموظف
            'academic_rank_id' => ['nullable', 'exists:academic_ranks,id'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'department_ids' => ['nullable', 'array'],
            'department_ids.*' => ['exists:departments,id'],
        ];
    }
}
