<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Students
            'students.view',
            'students.create',
            'students.update',
            'students.delete',

            // Teachers
            'teachers.view',
            'teachers.create',
            'teachers.update',
            'teachers.delete',

            // Subjects
            'subjects.view',
            'subjects.create',
            'subjects.update',
            'subjects.delete',

            // Attendance
            'attendance.view',
            'attendance.mark',

            // Exams
            'exams.view',
            'exams.create',
            'exams.update',
            'exams.delete',

            // Grades
            'grades.view',
            'grades.manage',

            // Messaging
            'messaging.send',
            'messaging.view',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $student = Role::firstOrCreate(['name' => 'student']);
        $parent = Role::firstOrCreate(['name' => 'parent']);

        // Assign permissions
        $admin->syncPermissions($permissions);

        // Teachers: view students/teachers/subjects, mark attendance, view exams/grades, messaging
        $teacherPerms = [
            'students.view',
            'teachers.view',
            'subjects.view',
            'attendance.view',
            'attendance.mark',
            'exams.view',
            'grades.view',
            'messaging.send',
            'messaging.view',
        ];
        $teacher->syncPermissions($teacherPerms);

        // Students: view own records, view subjects, view exams/grades, messaging
        $studentPerms = [
            'students.view',
            'subjects.view',
            'exams.view',
            'grades.view',
            'messaging.view',
        ];
        $student->syncPermissions($studentPerms);

        // Parents: view students (their children), view exams/grades, messaging
        $parentPerms = [
            'students.view',
            'exams.view',
            'grades.view',
            'messaging.view',
        ];
        $parent->syncPermissions($parentPerms);
    }
}
