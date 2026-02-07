<?php

namespace Tests\Feature;

use App\Models\Exam;
use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GradeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\PermissionsSeeder::class);
    }

    public function test_teacher_can_create_and_admin_can_manage_grades()
    {
        $teacherUser = User::factory()->create();
        $teacherUser->assignRole('teacher');
        Sanctum::actingAs($teacherUser);

        $student = Student::factory()->create();
        $exam = Exam::factory()->create();

        $resp = $this->postJson('/api/grades', [
            'student_id' => $student->id,
            'exam_id' => $exam->id,
            'marks_obtained' => 80,
        ]);

        $resp->assertStatus(201);
        $id = $resp->json('data.id');

        // teacher cannot update after creation (policy restricts to admin)
        $this->putJson("/api/grades/{$id}", ['marks_obtained' => 85])->assertStatus(403);

        // admin can update
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        Sanctum::actingAs($admin);
        $this->putJson("/api/grades/{$id}", ['marks_obtained' => 90])->assertStatus(200)->assertJsonPath('data.marks_obtained',90);
    }

    public function test_validation_on_create_grade()
    {
        $teacherUser = User::factory()->create();
        $teacherUser->assignRole('teacher');
        Sanctum::actingAs($teacherUser);

        $this->postJson('/api/grades', [])->assertStatus(422);
    }
}
