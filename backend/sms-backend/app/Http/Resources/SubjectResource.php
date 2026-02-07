<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'teacher_id' => $this->teacher_id,
            'teacher' => $this->whenLoaded('teacher', function () {
                return new TeacherResource($this->teacher);
            }),
            'class_id' => $this->class_id,
            'class' => $this->whenLoaded('schoolClass', function () {
                return new ClassResource($this->schoolClass);
            }),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
