<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize()
    {
        $student = $this->route('student');

        return $this->user() && $this->user()->can('update', $student);
    }

    public function rules()
    {
        $studentId = $this->route('student')?->id ?? null;

        return [
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($studentId),
            ],
            'phone' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date'],
            'class' => ['nullable', 'string', 'max:100'],
        ];
    }
}
