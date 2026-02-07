<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Services\MessageService;

class MessageController extends BaseApiController
{
    public function __construct(private MessageService $service)
    {
        $this->authorizeResource(Message::class, 'message');
    }

    public function index()
    {
        $paginated = $this->service->paginate(request('per_page', 15));
        return $this->success(MessageResource::collection($paginated)->response()->getData(true), 200, [], 'Messages retrieved');
    }

    public function store(StoreMessageRequest $request)
    {
        $payload = array_merge($request->validated(), ['sender_id' => $request->user()->id]);
        $message = $this->service->create($payload);
        return $this->created(new MessageResource($message), 'Message sent');
    }

    public function show(Message $message)
    {
        return $this->success(new MessageResource($message->load(['sender','receiver'])), 200, [], 'Message retrieved');
    }

    public function update(UpdateMessageRequest $request, Message $message)
    {
        if ($request->has('read_at')) {
            $message = $this->service->markRead($message);
        }
        return $this->success(new MessageResource($message), 200, [], 'Message updated');
    }

    public function destroy(Message $message)
    {
        $this->service->delete($message);
        return $this->success([], 200, [], 'Message deleted');
    }
}
