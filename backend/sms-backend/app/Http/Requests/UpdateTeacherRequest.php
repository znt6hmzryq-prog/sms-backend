<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends FormRequest
{
    public function authorize()
    {
        $teacher = $this->route('teacher');

        return $this->user() && $this->user()->can('update', $teacher);
    }

    public function rules()
    {
        $teacherId = $this->route('teacher')?->id ?? null;

        return [
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('teachers', 'email')->ignore($teacherId),
            ],
            'phone' => ['nullable', 'string', 'max:50'],
            'hire_date' => ['nullable','date'],
            'department' => ['nullable','string','max:255'],
        ];
    }
}
