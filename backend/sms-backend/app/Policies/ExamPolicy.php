<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Exam;

class ExamPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('teacher');
    }

    public function view(User $user, Exam $exam)
    {
        return $user->hasRole('admin') || $user->hasRole('teacher');
    }

    public function create(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('teacher');
    }

    public function update(User $user, Exam $exam)
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Exam $exam)
    {
        return $user->hasRole('admin');
    }
}
