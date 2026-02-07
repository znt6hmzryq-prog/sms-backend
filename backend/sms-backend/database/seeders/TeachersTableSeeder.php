<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeachersTableSeeder extends Seeder
{
    public function run(): void
    {
        Teacher::factory()->count(10)->create();
    }
}
