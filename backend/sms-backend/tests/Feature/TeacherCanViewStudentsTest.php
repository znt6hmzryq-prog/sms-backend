<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TeacherCanViewStudentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_view_students_but_cannot_create()
    {
        Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'web']);

        $teacher = User::factory()->create([
            'email' => 'teacher@example.com',
            'password' => bcrypt('password'),
        ]);
        $teacher->assignRole('teacher');

        Student::factory()->count(3)->create();

        $login = $this->postJson('/api/login', ['email' => 'teacher@example.com', 'password' => 'password']);
        $token = $login->json('data.token');

        $this->withHeaders(['Authorization' => "Bearer $token"]) ->getJson('/api/students')
            ->assertStatus(200)->assertJsonStructure(['data']);

        $student = Student::first();
        $this->withHeaders(['Authorization' => "Bearer $token"]) ->getJson('/api/students/'.$student->id)
            ->assertStatus(200)->assertJsonStructure(['data' => ['id', 'first_name', 'last_name']]);

        $this->withHeaders(['Authorization' => "Bearer $token"]) ->postJson('/api/students', [
            'first_name' => 'Blocked',
            'last_name' => 'User',
        ])->assertStatus(403);
    }
}
