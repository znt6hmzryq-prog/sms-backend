<?php

namespace Tests\Feature;

use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ExamTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\PermissionsSeeder::class);
    }

    public function test_admin_can_crud_exams()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        Sanctum::actingAs($admin);

        $class = SchoolClass::factory()->create();
        $subject = Subject::factory()->create();
        $teacher = Teacher::factory()->create();

        $resp = $this->postJson('/api/exams', [
            'title' => 'Midterm',
            'date' => now()->addDays(7)->toDateString(),
            'class_id' => $class->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'total_marks' => 100,
        ]);

        $resp->assertStatus(201)->assertJson(['success' => true]);
        $id = $resp->json('data.id');

        $this->getJson("/api/exams/{$id}")->assertStatus(200);
        $this->putJson("/api/exams/{$id}", ['title' => 'Final'])->assertStatus(200)->assertJsonPath('data.title','Final');
        $this->deleteJson("/api/exams/{$id}")->assertStatus(200);
    }

    public function test_validation_for_exam_creation()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        Sanctum::actingAs($admin);

        $this->postJson('/api/exams', [])->assertStatus(422);
    }
}
