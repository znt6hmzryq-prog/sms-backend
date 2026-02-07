<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGradeRequest extends FormRequest
{
    public function authorize()
    {
        $grade = $this->route('grade');
        return $this->user()->hasRole('admin') || $this->user()->hasRole('teacher');
    }

    public function rules()
    {
        return [
            'marks_obtained' => ['nullable','numeric'],
            'remarks' => ['nullable','string'],
        ];
    }
}
