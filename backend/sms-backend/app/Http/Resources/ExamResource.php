<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => optional($this->date)->toDateString(),
            'class' => new ClassResource($this->whenLoaded('schoolClass')),
            'subject' => new SubjectResource($this->whenLoaded('subject')),
            'teacher' => new TeacherResource($this->whenLoaded('teacher')),
            'total_marks' => $this->total_marks,
            'instructions' => $this->instructions,
        ];
    }
}
