<?php

namespace App\Services;

use App\Models\Message;

class MessageService
{
    public function paginate($perPage = 15)
    {
        return Message::with(['sender','receiver'])->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        return Message::create($data);
    }

    public function markRead(Message $message)
    {
        $message->update(['read_at' => now()]);
        return $message;
    }

    public function delete(Message $message)
    {
        return $message->delete();
    }
}
