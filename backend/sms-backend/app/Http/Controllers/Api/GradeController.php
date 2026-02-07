<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Http\Resources\GradeResource;
use App\Models\Grade;
use App\Services\GradeService;

class GradeController extends BaseApiController
{
    public function __construct(private GradeService $service)
    {
        $this->authorizeResource(Grade::class, 'grade');
    }

    public function index()
    {
        $paginated = $this->service->paginate(request('per_page', 15));
        return $this->success(GradeResource::collection($paginated)->response()->getData(true), 200, [], 'Grades retrieved');
    }

    public function store(StoreGradeRequest $request)
    {
        $grade = $this->service->create($request->validated());
        return $this->created(new GradeResource($grade), 'Grade created');
    }

    public function show(Grade $grade)
    {
        return $this->success(new GradeResource($grade->load(['student','exam'])), 200, [], 'Grade retrieved');
    }

    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $grade = $this->service->update($grade, $request->validated());
        return $this->success(new GradeResource($grade), 200, [], 'Grade updated');
    }

    public function destroy(Grade $grade)
    {
        $this->service->delete($grade);
        return $this->success([], 200, [], 'Grade deleted');
    }
}
