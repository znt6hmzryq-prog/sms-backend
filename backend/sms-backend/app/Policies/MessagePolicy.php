<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Message;

class MessagePolicy
{
    public function viewAny(User $user)
    {
        return $user != null;
    }

    public function view(User $user, Message $message)
    {
        return $user->id === $message->sender_id || $user->id === $message->receiver_id || $user->hasRole('admin');
    }

    public function create(User $user)
    {
        return $user != null;
    }

    public function update(User $user, Message $message)
    {
        return $user->id === $message->receiver_id || $user->hasRole('admin');
    }

    public function delete(User $user, Message $message)
    {
        return $user->id === $message->sender_id || $user->hasRole('admin');
    }
}
