<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    protected $model = Exam::class;

    public function definition()
    {
        $class = SchoolClass::inRandomOrder()->first() ?? SchoolClass::factory()->create();
        $subject = Subject::inRandomOrder()->first() ?? Subject::factory()->create();
        $teacher = Teacher::inRandomOrder()->first() ?? Teacher::factory()->create();

        return [
            'title' => $this->faker->sentence(3),
            'date' => $this->faker->dateTimeBetween('+1 days', '+30 days')->format('Y-m-d'),
            'class_id' => $class->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'total_marks' => $this->faker->randomElement([50, 100, 75]),
            'instructions' => $this->faker->optional()->paragraph(),
        ];
    }
}
