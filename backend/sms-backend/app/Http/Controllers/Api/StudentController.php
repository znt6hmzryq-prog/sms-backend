<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Spatie\Permission\Middleware\RoleMiddleware;

class StudentController extends BaseApiController
{
    public function __construct(protected StudentService $service)
    {
        $this->middleware('auth:sanctum');
        // Allow teachers and admins to view students, only admins can create/update/delete
        $this->middleware(RoleMiddleware::class . ':teacher|admin')->only(['index', 'show']);
        $this->middleware(RoleMiddleware::class . ':admin')->except(['index', 'show']);

        // Wire up policy resource authorization
        $this->authorizeResource(\App\Models\Student::class, 'student');
    }

    public function index(Request $request)
    {
        $params = $request->only(['per_page', 'search', 'sort_by', 'sort_dir', 'class']);
        $students = $this->service->paginate($params);
        $payload = (new StudentCollection($students))->response()->getData(true);

        return $this->success($payload['data'] ?? [], 200, $payload['meta'] ?? []);
    }

    public function store(StoreStudentRequest $request)
    {
        $student = $this->service->create($request->validated());
        $payload = (new StudentResource($student))->response()->getData(true);

        return $this->created($payload['data'] ?? []);
    }

    public function show(Student $student)
    {
        $payload = (new StudentResource($student))->response()->getData(true);

        return $this->success($payload['data'] ?? []);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student = $this->service->update($student, $request->validated());
        $payload = (new StudentResource($student))->response()->getData(true);

        return $this->success($payload['data'] ?? []);
    }

    public function destroy(Student $student)
    {
        $this->service->delete($student);
        return $this->success((object) [], 200, ['message' => 'Student deleted']);
    }
}
