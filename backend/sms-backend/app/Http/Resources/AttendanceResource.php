<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'student' => new StudentResource($this->whenLoaded('student')),
            'teacher' => new \App\Http\Resources\TeacherResource($this->whenLoaded('teacher')),
            'subject' => new \App\Http\Resources\SubjectResource($this->whenLoaded('subject')),
            'class' => new \App\Http\Resources\ClassResource($this->whenLoaded('schoolClass')),
            'date' => optional($this->date)->toDateString(),
            'status' => $this->status,
            'notes' => $this->notes,
        ];
    }
}
