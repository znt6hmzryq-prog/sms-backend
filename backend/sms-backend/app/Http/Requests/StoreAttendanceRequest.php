<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', \App\Models\Attendance::class);
    }

    public function rules()
    {
        return [
            'student_id' => ['required','exists:students,id'],
            'teacher_id' => ['nullable','exists:teachers,id'],
            'subject_id' => ['nullable','exists:subjects,id'],
            'class_id' => ['nullable','exists:classes,id'],
            'date' => ['required','date'],
            'status' => ['nullable','in:present,absent,late'],
            'notes' => ['nullable','string'],
        ];
    }
}
