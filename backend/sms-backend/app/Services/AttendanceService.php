<?php

namespace App\Services;

use App\Models\Attendance;

class AttendanceService
{
    public function paginate($perPage = 15)
    {
        return Attendance::with(['student', 'teacher', 'subject', 'schoolClass'])->orderBy('date', 'desc')->paginate($perPage);
    }

    public function create(array $data)
    {
        return Attendance::create($data);
    }

    public function update(Attendance $attendance, array $data)
    {
        $attendance->update($data);
        return $attendance;
    }

    public function delete(Attendance $attendance)
    {
        return $attendance->delete();
    }
}
