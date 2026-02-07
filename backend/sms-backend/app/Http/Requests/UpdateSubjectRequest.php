<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubjectRequest extends FormRequest
{
    public function authorize()
    {
        $subject = $this->route('subject');

        return $this->user() && $this->user()->can('update', $subject);
    }

    public function rules()
    {
        $subjectId = $this->route('subject')?->id ?? null;

        return [
            'name' => ['sometimes','required','string','max:255'],
            'code' => ['nullable','string','max:100', Rule::unique('subjects', 'code')->ignore($subjectId)],
            'description' => ['nullable','string'],
            'teacher_id' => ['nullable','exists:teachers,id'],
            'class_id' => ['nullable','exists:classes,id'],
        ];
    }
}
