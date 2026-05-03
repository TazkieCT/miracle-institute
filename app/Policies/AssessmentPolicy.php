<?php

namespace App\Policies;

use App\Models\Assessment;
use App\Models\User;

class AssessmentPolicy
{
    public function take(User $user, Assessment $assessment): bool
    {
        return $user->hasPermission('take_assessment');
    }

    public function manage(User $user): bool
    {
        return $user->hasPermission('manage_assessments');
    }
}