<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;

class AttendancesTableSeeder extends Seeder
{
    public function run()
    {
        Attendance::factory()->count(30)->create();
    }
}
