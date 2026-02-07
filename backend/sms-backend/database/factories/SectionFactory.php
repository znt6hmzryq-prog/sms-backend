<?php

namespace Database\Factories;

use App\Models\Section;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    protected $model = Section::class;

    public function definition()
    {
        $class = SchoolClass::inRandomOrder()->first() ?? SchoolClass::factory()->create();

        return [
            'class_id' => $class->id,
            'name' => $this->faker->randomElement(['A','B','C','D','E']),
            'code' => strtoupper($this->faker->bothify('SEC-??')),
        ];
    }
}
