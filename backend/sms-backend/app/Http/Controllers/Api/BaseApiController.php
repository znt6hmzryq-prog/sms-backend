<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    protected function success(mixed $data = null, int $status = 200, array $meta = [], string $message = ''): JsonResponse
    {
        $payload = [
            'success' => true,
            'data' => $data ?? (object) [],
            'message' => $message,
        ];

        if (! empty($meta)) {
            $payload['meta'] = $meta;
        }

        return response()->json($payload, $status);
    }

    protected function created(mixed $data = null, mixed $metaOrMessage = []): JsonResponse
    {
        if (is_string($metaOrMessage)) {
            return $this->success($data, 201, [], $metaOrMessage);
        }

        return $this->success($data, 201, (array) $metaOrMessage);
    }

    protected function error(string $message, int $status = 400, array $errors = []): JsonResponse
    {
        $payload = [
            'success' => false,
            'data' => (object) [],
            'message' => $message,
        ];

        if (! empty($errors)) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }
}
