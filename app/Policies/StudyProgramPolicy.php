<?php

namespace App\Policies;

use App\Models\User;

class StudyProgramPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('manage_courses');
    }

    public function manage(User $user): bool
    {
        return $user->hasPermission('manage_courses');
    }
}