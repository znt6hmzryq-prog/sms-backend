<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    public function run(): void
    {
        Student::factory()->count(50)->create();
    }
}
