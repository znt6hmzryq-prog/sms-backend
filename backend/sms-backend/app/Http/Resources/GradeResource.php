<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'student' => new StudentResource($this->whenLoaded('student')),
            'exam' => new ExamResource($this->whenLoaded('exam')),
            'marks_obtained' => $this->marks_obtained,
            'remarks' => $this->remarks,
        ];
    }
}
