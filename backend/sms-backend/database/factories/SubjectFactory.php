<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition()
    {
        $class = SchoolClass::inRandomOrder()->first() ?? SchoolClass::factory()->create();
        $teacher = Teacher::inRandomOrder()->first() ?? Teacher::factory()->create();

        return [
            'name' => $this->faker->unique()->word() . ' ' . $this->faker->randomElement(['101','201','301']),
            'code' => strtoupper($this->faker->bothify('SUB-??')),
            'description' => $this->faker->optional()->sentence(),
            'teacher_id' => $teacher->id,
            'class_id' => $class->id,
        ];
    }
}
