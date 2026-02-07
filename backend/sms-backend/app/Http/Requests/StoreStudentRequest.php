<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->can('create', \App\Models\Student::class);
    }

    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:students,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date'],
            'class' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages()
    {
        return [];
    }
}
