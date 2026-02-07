<?php

namespace App\Services;

use App\Models\Teacher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class TeacherService
{
    public function paginate(array $params = []): LengthAwarePaginator
    {
        $perPage = (int) ($params['per_page'] ?? 15);
        $query = Teacher::query();

        if (! empty($params['search'])) {
            $search = trim($params['search']);
            $query->where(function (Builder $q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        $sortBy = $params['sort_by'] ?? 'last_name';
        $sortDir = strtolower($params['sort_dir'] ?? 'asc') === 'desc' ? 'desc' : 'asc';

        $query->orderBy($sortBy, $sortDir);

        return $query->paginate($perPage);
    }

    public function create(array $data): Teacher
    {
        return Teacher::create($data);
    }

    public function update(Teacher $teacher, array $data): Teacher
    {
        $teacher->update($data);
        return $teacher->refresh();
    }

    public function delete(Teacher $teacher): void
    {
        $teacher->delete();
    }
}
