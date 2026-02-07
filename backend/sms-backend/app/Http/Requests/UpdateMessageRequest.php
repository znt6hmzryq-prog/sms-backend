<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMessageRequest extends FormRequest
{
    public function authorize()
    {
        $message = $this->route('message');
        return $this->user()->id === optional($message)->receiver_id || $this->user()->hasRole('admin');
    }

    public function rules()
    {
        return [
            'read_at' => ['nullable','date'],
        ];
    }
}
