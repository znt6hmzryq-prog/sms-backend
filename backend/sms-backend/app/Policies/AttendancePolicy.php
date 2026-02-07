<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Attendance;

class AttendancePolicy
{
    public function viewAny(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('teacher');
    }

    public function view(User $user, Attendance $attendance)
    {
        return $user->hasRole('admin') || $user->hasRole('teacher');
    }

    public function create(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('teacher');
    }

    public function update(User $user, Attendance $attendance)
    {
        return $user->hasRole('admin') || $user->hasRole('teacher');
    }

    public function delete(User $user, Attendance $attendance)
    {
        return $user->hasRole('admin');
    }
}
