<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sender' => new \App\Http\Resources\UserResource($this->whenLoaded('sender')),
            'receiver' => new \App\Http\Resources\UserResource($this->whenLoaded('receiver')),
            'subject' => $this->subject,
            'body' => $this->body,
            'read_at' => optional($this->read_at)->toDateTimeString(),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
