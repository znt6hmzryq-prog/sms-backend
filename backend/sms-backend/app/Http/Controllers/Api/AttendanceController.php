<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Services\AttendanceService;

class AttendanceController extends BaseApiController
{
    public function __construct(private AttendanceService $service)
    {
        $this->authorizeResource(Attendance::class, 'attendance');
    }

    public function index()
    {
        $paginated = $this->service->paginate(request('per_page', 15));
        return $this->success(AttendanceResource::collection($paginated)->response()->getData(true), 200, [], 'Attendances retrieved');
    }

    public function store(StoreAttendanceRequest $request)
    {
        $attendance = $this->service->create($request->validated());
        return $this->created(new AttendanceResource($attendance), 'Attendance created');
    }

    public function show(Attendance $attendance)
    {
        return $this->success(new AttendanceResource($attendance->load(['student','teacher','subject','schoolClass'])), 200, [], 'Attendance retrieved');
    }

    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        $attendance = $this->service->update($attendance, $request->validated());
        return $this->success(new AttendanceResource($attendance), 200, [], 'Attendance updated');
    }

    public function destroy(Attendance $attendance)
    {
        $this->service->delete($attendance);
        return $this->success([], 200, [], 'Attendance deleted');
    }
}
