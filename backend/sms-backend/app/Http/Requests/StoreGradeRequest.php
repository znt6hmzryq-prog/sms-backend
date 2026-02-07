<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->hasRole('admin') || $this->user()->hasRole('teacher');
    }

    public function rules()
    {
        return [
            'student_id' => ['required','exists:students,id'],
            'exam_id' => ['required','exists:exams,id'],
            'marks_obtained' => ['required','numeric'],
            'remarks' => ['nullable','string'],
        ];
    }
}
