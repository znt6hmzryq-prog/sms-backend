<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create some example permissions and an admin role
        $permissions = [
            'manage users',
            'manage roles',
            'manage permissions',
            'view reports',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo($permissions);

        // Ensure legacy admin email exists
        $admin = User::where('email', 'admin@example.com')->first();
        if (! $admin) {
            $admin = User::factory()->create([
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);
        }

        // Also ensure admin@sms.local exists for local development
        $adminLocal = User::where('email', 'admin@sms.local')->first();
        if (! $adminLocal) {
            $adminLocal = User::firstOrCreate(
                ['email' => 'admin@sms.local'],
                [
                    'name' => 'Administrator',
                    'password' => Hash::make('password'),
                ]
            );
        }

        $admin->assignRole($adminRole);
        $adminLocal->assignRole($adminRole);

        // Create demo classes and sections
        $classes = [
            ['name' => 'Grade 1', 'code' => 'G1'],
            ['name' => 'Grade 2', 'code' => 'G2'],
            ['name' => 'Grade 3', 'code' => 'G3'],
        ];

        foreach ($classes as $cls) {
            \App\Models\SchoolClass::firstOrCreate(['code' => $cls['code']], $cls);
        }

        // Ensure some sections exist
        foreach (\App\Models\SchoolClass::all() as $class) {
            \App\Models\Section::firstOrCreate([
                'class_id' => $class->id,
                'name' => 'A',
            ]);
            \App\Models\Section::firstOrCreate([
                'class_id' => $class->id,
                'name' => 'B',
            ]);
        }

        // Seed demo students
        $this->call(StudentsTableSeeder::class);

        // Seed demo teachers
        $this->call(TeachersTableSeeder::class);

        // Granular permissions and role mapping
        $this->call(\Database\Seeders\PermissionsSeeder::class);

        // Seed demo subjects if none exist
        if (\App\Models\Subject::count() === 0) {
            $this->call(SubjectsTableSeeder::class);
        }

        // Seed exams, grades, attendance and messages only if not present
        if (\App\Models\Exam::count() === 0) {
            $this->call(ExamsTableSeeder::class);
        }

        if (\App\Models\Grade::count() === 0) {
            $this->call(GradesTableSeeder::class);
        }

        if (\App\Models\Attendance::count() === 0) {
            $this->call(AttendancesTableSeeder::class);
        }

        if (\App\Models\Message::count() === 0) {
            $this->call(MessagesTableSeeder::class);
        }
    }
}
