<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Http\Resources\ExamResource;
use App\Models\Exam;
use App\Services\ExamService;

class ExamController extends BaseApiController
{
    public function __construct(private ExamService $service)
    {
        $this->authorizeResource(Exam::class, 'exam');
    }

    public function index()
    {
        $paginated = $this->service->paginate(request('per_page', 15));
        return $this->success(ExamResource::collection($paginated)->response()->getData(true), 200, [], 'Exams retrieved');
    }

    public function store(StoreExamRequest $request)
    {
        $exam = $this->service->create($request->validated());
        return $this->created(new ExamResource($exam), 'Exam created');
    }

    public function show(Exam $exam)
    {
        return $this->success(new ExamResource($exam->load(['schoolClass','subject','teacher'])), 200, [], 'Exam retrieved');
    }

    public function update(UpdateExamRequest $request, Exam $exam)
    {
        $exam = $this->service->update($exam, $request->validated());
        return $this->success(new ExamResource($exam), 200, [], 'Exam updated');
    }

    public function destroy(Exam $exam)
    {
        $this->service->delete($exam);
        return $this->success([], 200, [], 'Exam deleted');
    }
}
