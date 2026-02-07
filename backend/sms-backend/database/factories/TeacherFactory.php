<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'hire_date' => $this->faker->optional()->dateTimeBetween('-10 years', 'now')?->format('Y-m-d'),
            'department' => $this->faker->optional()->randomElement(['Mathematics','Science','English','Arts','Physical Education']),
        ];
    }
}
