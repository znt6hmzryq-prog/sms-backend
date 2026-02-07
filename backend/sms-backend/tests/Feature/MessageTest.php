<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\PermissionsSeeder::class);
    }

    public function test_send_and_read_message()
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        Sanctum::actingAs($sender);

        $resp = $this->postJson('/api/messages', [
            'receiver_id' => $receiver->id,
            'subject' => 'Hello',
            'body' => 'This is a test message',
        ]);

        $resp->assertStatus(201)->assertJson(['success' => true]);
        $id = $resp->json('data.id');

        // receiver can view message
        Sanctum::actingAs($receiver);
        $this->getJson("/api/messages/{$id}")->assertStatus(200);

        // receiver can mark read
        $resp = $this->putJson("/api/messages/{$id}", ['read_at' => now()->toDateTimeString()]);
        $resp->assertStatus(200);
        $this->assertNotNull($resp->json('data.read_at'));
    }

    public function test_validation_for_message()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $this->postJson('/api/messages', [])->assertStatus(422);
    }
}
