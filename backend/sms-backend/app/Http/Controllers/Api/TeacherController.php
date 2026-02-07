<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\StudentCollection;
use App\Models\Teacher;
use App\Services\TeacherService;
use Illuminate\Http\Request;
use Spatie\Permission\Middleware\RoleMiddleware;

class TeacherController extends BaseApiController
{
    public function __construct(protected TeacherService $service)
    {
        $this->middleware('auth:sanctum');
        // Allow teacher and admin to view, only admin to manage
        $this->middleware(RoleMiddleware::class . ':teacher|admin')->only(['index', 'show']);
        $this->middleware(RoleMiddleware::class . ':admin')->except(['index', 'show']);

        $this->authorizeResource(Teacher::class, 'teacher');
    }

    public function index(Request $request)
    {
        $params = $request->only(['per_page', 'search', 'sort_by', 'sort_dir', 'department']);
        $teachers = $this->service->paginate($params);

        $payload = (new StudentCollection($teachers))->response()->getData(true);

        return $this->success($payload['data'] ?? [], 200, $payload['meta'] ?? []);
    }

    public function store(StoreTeacherRequest $request)
    {
        $teacher = $this->service->create($request->validated());

        $payload = (new TeacherResource($teacher))->response()->getData(true);

        return $this->created($payload['data'] ?? []);
    }

    public function show(Teacher $teacher)
    {
        $payload = (new TeacherResource($teacher))->response()->getData(true);

        return $this->success($payload['data'] ?? []);
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $teacher = $this->service->update($teacher, $request->validated());

        $payload = (new TeacherResource($teacher))->response()->getData(true);

        return $this->success($payload['data'] ?? []);
    }

    public function destroy(Teacher $teacher)
    {
        $this->service->delete($teacher);

        return $this->success((object) [], 200, ['message' => 'Teacher deleted']);
    }
}
