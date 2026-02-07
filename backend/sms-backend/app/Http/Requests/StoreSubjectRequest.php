<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->can('create', \App\Models\Subject::class);
    }

    public function rules()
    {
        return [
            'name' => ['required','string','max:255'],
            'code' => ['nullable','string','max:100','unique:subjects,code'],
            'description' => ['nullable','string'],
            'teacher_id' => ['nullable','exists:teachers,id'],
            'class_id' => ['nullable','exists:classes,id'],
        ];
    }
}
