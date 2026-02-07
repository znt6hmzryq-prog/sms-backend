<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_and_me()
    {
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'testuser@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['data' => ['token', 'user']]);

        $token = $response->json('data.token');

        $this->withHeaders(['Authorization' => "Bearer $token"]) ->getJson('/api/user')
            ->assertStatus(200)
            ->assertJsonStructure(['data' => ['id', 'email']]);
    }
}
