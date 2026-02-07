<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // create users
        $users = [
            ['name' => 'Super Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'phone' => null, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sample Teacher', 'email' => 'teacher@example.com', 'password' => Hash::make('password'), 'phone' => null, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sample Student', 'email' => 'student@example.com', 'password' => Hash::make('password'), 'phone' => null, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($users as $u) {
            DB::table('users')->insertOrIgnore($u);
        }

        $userMap = DB::table('users')->whereIn('email', ['admin@example.com','teacher@example.com','student@example.com'])->pluck('id', 'email');
        $roleMap = DB::table('roles')->pluck('id', 'name');

        // assign roles (legacy pivot `role_user` kept for compatibility)
        if (isset($userMap['admin@example.com']) && isset($roleMap['super_admin'])) {
            DB::table('role_user')->insertOrIgnore(['user_id' => $userMap['admin@example.com'], 'role_id' => $roleMap['super_admin'], 'created_at' => $now, 'updated_at' => $now]);
            DB::table('model_has_roles')->insertOrIgnore(['role_id' => $roleMap['super_admin'], 'model_type' => 'App\\Models\\User', 'model_id' => $userMap['admin@example.com']]);
        }

        if (isset($userMap['teacher@example.com']) && isset($roleMap['teacher'])) {
            DB::table('role_user')->insertOrIgnore(['user_id' => $userMap['teacher@example.com'], 'role_id' => $roleMap['teacher'], 'created_at' => $now, 'updated_at' => $now]);
            DB::table('model_has_roles')->insertOrIgnore(['role_id' => $roleMap['teacher'], 'model_type' => 'App\\Models\\User', 'model_id' => $userMap['teacher@example.com']]);
        }

        if (isset($userMap['student@example.com']) && isset($roleMap['student'])) {
            DB::table('role_user')->insertOrIgnore(['user_id' => $userMap['student@example.com'], 'role_id' => $roleMap['student'], 'created_at' => $now, 'updated_at' => $now]);
            DB::table('model_has_roles')->insertOrIgnore(['role_id' => $roleMap['student'], 'model_type' => 'App\\Models\\User', 'model_id' => $userMap['student@example.com']]);

            // create a minimal student record linked to the user
            $studentId = DB::table('students')->insertGetId([
                'user_id' => $userMap['student@example.com'],
                'enrollment_no' => 'ENR-' . uniqid(),
                'first_name' => 'Sample',
                'last_name' => 'Student',
                'status' => 'active',
                'admission_date' => $now->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // create a minimal teacher record linked to teacher user
        if (isset($userMap['teacher@example.com'])) {
            DB::table('teachers')->insertOrIgnore([
                'user_id' => $userMap['teacher@example.com'],
                'employee_no' => 'EMP-' . uniqid(),
                'first_name' => 'Sample',
                'last_name' => 'Teacher',
                'status' => 'active',
                'hire_date' => $now->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
