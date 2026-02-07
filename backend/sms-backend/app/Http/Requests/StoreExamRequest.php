<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->hasRole('admin') || $this->user()->hasRole('teacher');
    }

    public function rules()
    {
        return [
            'title' => ['required','string'],
            'date' => ['nullable','date'],
            'class_id' => ['nullable','exists:classes,id'],
            'subject_id' => ['nullable','exists:subjects,id'],
            'teacher_id' => ['nullable','exists:teachers,id'],
            'total_marks' => ['nullable','integer'],
            'instructions' => ['nullable','string'],
        ];
    }
}
