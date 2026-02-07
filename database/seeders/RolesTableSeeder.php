<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Carbon;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $roles = [
            ['name' => 'super_admin', 'guard_name' => 'web', 'description' => 'Full system control', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'school_admin', 'guard_name' => 'web', 'description' => 'School-level administration', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'principal', 'guard_name' => 'web', 'description' => 'Principal', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'teacher', 'guard_name' => 'web', 'description' => 'Teacher', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'accountant', 'guard_name' => 'web', 'description' => 'Handles fees and accounting', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'librarian', 'guard_name' => 'web', 'description' => 'Library manager', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'transport_manager', 'guard_name' => 'web', 'description' => 'Transport manager', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'student', 'guard_name' => 'web', 'description' => 'Student account', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'parent', 'guard_name' => 'web', 'description' => 'Parent account', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('roles')->insertOrIgnore($roles);
    }
}
