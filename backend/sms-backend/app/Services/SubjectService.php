<?php

namespace App\Services;

use App\Models\Subject;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class SubjectService
{
    public function paginate(array $params = []): LengthAwarePaginator
    {
        $perPage = (int) ($params['per_page'] ?? 15);
        $query = Subject::with(['teacher', 'schoolClass']);

        if (! empty($params['search'])) {
            $search = trim($params['search']);
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (! empty($params['class_id'])) {
            $query->where('class_id', $params['class_id']);
        }

        $sortBy = $params['sort_by'] ?? 'name';
        $sortDir = strtolower($params['sort_dir'] ?? 'asc') === 'desc' ? 'desc' : 'asc';

        $query->orderBy($sortBy, $sortDir);

        return $query->paginate($perPage);
    }

    public function create(array $data): Subject
    {
        return Subject::create($data);
    }

    public function update(Subject $subject, array $data): Subject
    {
        $subject->update($data);
        return $subject->refresh();
    }

    public function delete(Subject $subject): void
    {
        $subject->delete();
    }
}
