<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;

class SubjectPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['admin','teacher']);
    }

    public function view(User $user, Subject $subject)
    {
        return $user->hasAnyRole(['admin','teacher','student','parent']);
    }

    public function create(User $user)
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Subject $subject)
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Subject $subject)
    {
        return $user->hasRole('admin');
    }
}
