<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class StudentService
{
    /**
     * Paginate and search students.
     */
    public function paginate(array $params = []): LengthAwarePaginator
    {
        $perPage = (int) ($params['per_page'] ?? 15);
        $query = Student::with(['schoolClass', 'section']);

        if (! empty($params['search'])) {
            $search = trim($params['search']);
            $query->where(function (Builder $q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('class', 'like', "%{$search}%");
            });
        }

        if (! empty($params['class'])) {
            $query->where('class', $params['class']);
        }

        $sortBy = $params['sort_by'] ?? 'last_name';
        $sortDir = strtolower($params['sort_dir'] ?? 'asc') === 'desc' ? 'desc' : 'asc';

        $query->orderBy($sortBy, $sortDir);

        return $query->paginate($perPage);
    }

    public function create(array $data): Student
    {
        return Student::create($data);
    }

    public function update(Student $student, array $data): Student
    {
        $student->update($data);
        return $student->refresh();
    }

    public function delete(Student $student): void
    {
        $student->delete();
    }
}
