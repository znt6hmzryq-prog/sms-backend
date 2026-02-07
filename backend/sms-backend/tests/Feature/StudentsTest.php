<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StudentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_and_list_students()
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->roles()->attach($role->id);

        $login = $this->postJson('/api/login', ['email' => 'admin@example.com', 'password' => 'password']);
        $token = $login->json('data.token');

        $this->withHeaders(['Authorization' => "Bearer $token"]) ->postJson('/api/students', [
            'first_name' => 'Test',
            'last_name' => 'Student',
            'email' => 'student@example.com',
        ])->assertStatus(201)->assertJsonStructure(['data' => ['id', 'first_name', 'last_name']]);

        $this->withHeaders(['Authorization' => "Bearer $token"]) ->getJson('/api/students')
            ->assertStatus(200)->assertJsonStructure(['data']);
    }
}
