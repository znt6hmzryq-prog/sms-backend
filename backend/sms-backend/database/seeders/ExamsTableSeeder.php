<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;

class ExamsTableSeeder extends Seeder
{
    public function run()
    {
        Exam::factory()->count(10)->create();
    }
}
