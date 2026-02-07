<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'date_of_birth' => $this->when($this->date_of_birth, fn () => $this->date_of_birth->toDateString()),
            'class' => $this->when($this->class, $this->class),
            'class_id' => $this->class_id,
            'school_class' => $this->whenLoaded('schoolClass', function () {
                return new \App\Http\Resources\ClassResource($this->schoolClass);
            }),
            'section_id' => $this->section_id,
            'section' => $this->whenLoaded('section', function () {
                return new \App\Http\Resources\SectionResource($this->section);
            }),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
