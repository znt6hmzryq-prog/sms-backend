<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        $first = $this->faker->firstName();
        $last = $this->faker->lastName();

        return [
            'first_name' => $first,
            'last_name' => $last,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'date_of_birth' => $this->faker->optional()->dateTimeBetween('-18 years', '-6 years')?->format('Y-m-d'),
            'class' => $this->faker->optional()->randomElement(['A', 'B', 'C', 'D']),
            'class_id' => SchoolClass::inRandomOrder()->first()?->id ?? SchoolClass::factory()->create()->id,
            'section_id' => Section::inRandomOrder()->first()?->id ?? Section::factory()->for(SchoolClass::factory(), 'schoolClass')->create()->id,
        ];
    }
}
