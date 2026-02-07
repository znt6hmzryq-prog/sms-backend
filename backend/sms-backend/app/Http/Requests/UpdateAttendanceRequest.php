<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        $attendance = $this->route('attendance');
        return $this->user()->can('update', $attendance);
    }

    public function rules()
    {
        return [
            'status' => ['nullable','in:present,absent,late'],
            'notes' => ['nullable','string'],
        ];
    }
}
