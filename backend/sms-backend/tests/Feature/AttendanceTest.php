<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\Message;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\PermissionsSeeder::class);
    }

    public function test_admin_can_crud_attendance()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        Sanctum::actingAs($admin);

        $student = Student::factory()->create();
        $teacher = Teacher::factory()->create();
        $subject = Subject::factory()->create();
        $class = SchoolClass::factory()->create();

        // Create
        $resp = $this->postJson('/api/attendances', [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'subject_id' => $subject->id,
            'class_id' => $class->id,
            'date' => now()->toDateString(),
            'status' => 'present',
        ]);
        $resp->assertStatus(201)->assertJson(['success' => true]);

        $id = $resp->json('data.id');

        // Read
        $this->getJson("/api/attendances/{$id}")->assertStatus(200)->assertJson(['success' => true]);

        // Update
        $this->putJson("/api/attendances/{$id}", ['status' => 'absent'])->assertStatus(200)->assertJsonPath('data.status','absent');

        // Delete
        $this->deleteJson("/api/attendances/{$id}")->assertStatus(200)->assertJson(['success' => true]);
    }

    public function test_teacher_can_create_and_view_but_not_delete_attendance()
    {
        $teacherUser = User::factory()->create();
        $teacherUser->assignRole('teacher');
        Sanctum::actingAs($teacherUser);

        $student = Student::factory()->create();
        $class = SchoolClass::factory()->create();

        $resp = $this->postJson('/api/attendances', [
            'student_id' => $student->id,
            'date' => now()->toDateString(),
            'class_id' => $class->id,
        ]);
        $resp->assertStatus(201);

        $id = $resp->json('data.id');
        $this->getJson("/api/attendances/{$id}")->assertStatus(200);
        $this->deleteJson("/api/attendances/{$id}")->assertStatus(403);
    }

    public function test_validation_on_create_attendance()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        Sanctum::actingAs($admin);

        $this->postJson('/api/attendances', [])->assertStatus(422)->assertJsonStructure(['message','errors']);
    }
}
