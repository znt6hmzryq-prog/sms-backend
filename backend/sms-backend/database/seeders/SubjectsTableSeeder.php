<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    public function run(): void
    {
        Subject::factory()->count(20)->create();
    }
}
