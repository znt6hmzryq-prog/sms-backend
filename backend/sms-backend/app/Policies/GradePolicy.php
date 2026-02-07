<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Grade;

class GradePolicy
{
    public function viewAny(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('teacher');
    }

    public function view(User $user, Grade $grade)
    {
        return $user->hasRole('admin') || $user->hasRole('teacher');
    }

    public function create(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('teacher');
    }

    public function update(User $user, Grade $grade)
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Grade $grade)
    {
        return $user->hasRole('admin');
    }
}
