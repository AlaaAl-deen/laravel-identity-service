<?php

namespace App\Modules\UserManagement\Requests;
use Illuminate\Validation\Rules\Password;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         $rules = [
            'university_id' => ['required', 'string', 'max:50', 'unique:users,university_id'],
            'type' => ['required', 'in:student,staff'],
            'password' => ['required', 'string', 'min:6'],
            'name' => ['required', 'string', 'max:255'],
        ];

        // قواعد الطالب
        if ($this->input('type') === 'student') {
            $rules = array_merge($rules, [
                'college_id' => ['required', 'exists:colleges,id'],
                'department_id' => ['required', 'exists:departments,id'],
                'study_level_id' => ['required', 'exists:study_levels,id'],
            ]);
        }

        // قواعد الموظف
        if ($this->input('type') === 'staff') {
            $rules = array_merge($rules, [
                'academic_rank_id' => ['nullable', 'exists:academic_ranks,id'],
                'specialization' => ['nullable', 'string', 'max:255'],
                'department_ids' => ['nullable', 'array'],
                'department_ids.*' => ['exists:departments,id'],
            ]);
        }

        return $rules;
    
    }
}
