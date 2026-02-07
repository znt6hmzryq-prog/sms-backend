<?php

namespace App\Services;

use App\Models\Grade;

class GradeService
{
    public function paginate($perPage = 15)
    {
        return Grade::with(['student','exam'])->paginate($perPage);
    }

    public function create(array $data)
    {
        return Grade::create($data);
    }

    public function update(Grade $grade, array $data)
    {
        $grade->update($data);
        return $grade;
    }

    public function delete(Grade $grade)
    {
        return $grade->delete();
    }
}
