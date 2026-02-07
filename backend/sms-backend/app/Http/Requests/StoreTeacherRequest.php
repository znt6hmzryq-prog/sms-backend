<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->can('create', \App\Models\Teacher::class);
    }

    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:teachers,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'hire_date' => ['nullable','date'],
            'department' => ['nullable','string','max:255'],
        ];
    }
}
