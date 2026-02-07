<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StudentCollection extends ResourceCollection
{
    public $collects = StudentResource::class;

    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
        ];
    }

    public function with($request): array
    {
        return [
            'meta' => [
                'count' => $this->count(),
                'total' => $this->resource->total() ?? null,
                'per_page' => $this->resource->perPage() ?? null,
                'current_page' => $this->resource->currentPage() ?? null,
                'last_page' => $this->resource->lastPage() ?? null,
            ],
        ];
    }
}
