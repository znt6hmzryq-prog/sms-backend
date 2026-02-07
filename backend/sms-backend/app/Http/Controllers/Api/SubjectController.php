<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\StudentCollection;
use App\Models\Subject;
use App\Services\SubjectService;
use Illuminate\Http\Request;
use Spatie\Permission\Middleware\RoleMiddleware;

class SubjectController extends BaseApiController
{
    public function __construct(protected SubjectService $service)
    {
        $this->middleware('auth:sanctum');
        $this->middleware(RoleMiddleware::class . ':teacher|admin')->only(['index', 'show']);
        $this->middleware(RoleMiddleware::class . ':admin')->except(['index', 'show']);

        $this->authorizeResource(Subject::class, 'subject');
    }

    public function index(Request $request)
    {
        $params = $request->only(['per_page', 'search', 'sort_by', 'sort_dir', 'class_id']);
        $subjects = $this->service->paginate($params);

        $payload = (new StudentCollection($subjects))->response()->getData(true);

        return $this->success($payload['data'] ?? [], 200, $payload['meta'] ?? []);
    }

    public function store(StoreSubjectRequest $request)
    {
        $subject = $this->service->create($request->validated());

        $payload = (new SubjectResource($subject))->response()->getData(true);

        return $this->created($payload['data'] ?? []);
    }

    public function show(Subject $subject)
    {
        $payload = (new SubjectResource($subject))->response()->getData(true);

        return $this->success($payload['data'] ?? []);
    }

    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $subject = $this->service->update($subject, $request->validated());

        $payload = (new SubjectResource($subject))->response()->getData(true);

        return $this->success($payload['data'] ?? []);
    }

    public function destroy(Subject $subject)
    {
        $this->service->delete($subject);

        return $this->success((object) [], 200, ['message' => 'Subject deleted']);
    }
}
