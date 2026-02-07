<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition()
    {
        $student = Student::inRandomOrder()->first() ?? Student::factory()->create();
        $teacher = Teacher::inRandomOrder()->first() ?? Teacher::factory()->create();
        $subject = Subject::inRandomOrder()->first() ?? Subject::factory()->create();
        $class = SchoolClass::inRandomOrder()->first() ?? SchoolClass::factory()->create();

        return [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'subject_id' => $subject->id,
            'class_id' => $class->id,
            'date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'status' => $this->faker->randomElement(['present', 'absent', 'late']),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
