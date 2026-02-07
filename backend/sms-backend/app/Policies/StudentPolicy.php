<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['admin','teacher']);
    }

    public function view(User $user, Student $student)
    {
        return $user->hasAnyRole(['admin','teacher']) || $user->id === $student->user_id;
    }

    public function create(User $user)
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Student $student)
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Student $student)
    {
        return $user->hasRole('admin');
    }
}
