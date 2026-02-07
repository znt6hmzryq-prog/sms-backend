<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamRequest extends FormRequest
{
    public function authorize()
    {
        $exam = $this->route('exam');
        return $this->user()->hasRole('admin') || $this->user()->hasRole('teacher');
    }

    public function rules()
    {
        return [
            'title' => ['nullable','string'],
            'date' => ['nullable','date'],
            'total_marks' => ['nullable','integer'],
            'instructions' => ['nullable','string'],
        ];
    }
}
