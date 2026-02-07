<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition()
    {
        $users = User::inRandomOrder()->take(2)->get();
        if ($users->count() < 2) {
            $users = User::factory()->count(2)->create();
        }

        return [
            'sender_id' => $users[0]->id,
            'receiver_id' => $users[1]->id,
            'subject' => $this->faker->sentence(4),
            'body' => $this->faker->paragraph(),
            'read_at' => $this->faker->optional()->dateTimeBetween('-7 days', 'now'),
        ];
    }
}
