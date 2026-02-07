<?php

namespace App\Policies;

use App\Models\Teacher;
use App\Models\User;

class TeacherPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['admin','teacher']);
    }

    public function view(User $user, Teacher $teacher)
    {
        return $user->hasAnyRole(['admin','teacher']) || $user->id === $teacher->user_id;
    }

    public function create(User $user)
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Teacher $teacher)
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Teacher $teacher)
    {
        return $user->hasRole('admin');
    }
}
