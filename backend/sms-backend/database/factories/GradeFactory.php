<?php

namespace Database\Factories;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradeFactory extends Factory
{
    protected $model = Grade::class;

    public function definition()
    {
        $student = Student::inRandomOrder()->first() ?? Student::factory()->create();
        $exam = Exam::inRandomOrder()->first() ?? Exam::factory()->create();

        return [
            'student_id' => $student->id,
            'exam_id' => $exam->id,
            'marks_obtained' => $this->faker->numberBetween(0, $exam->total_marks ?? 100),
            'remarks' => $this->faker->optional()->sentence(),
        ];
    }
}
