<?php

namespace App\Services;

use App\Models\Exam;

class ExamService
{
    public function paginate($perPage = 15)
    {
        return Exam::with(['schoolClass','subject','teacher'])->orderBy('date','asc')->paginate($perPage);
    }

    public function create(array $data)
    {
        return Exam::create($data);
    }

    public function update(Exam $exam, array $data)
    {
        $exam->update($data);
        return $exam;
    }

    public function delete(Exam $exam)
    {
        return $exam->delete();
    }
}
