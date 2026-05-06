<?php

namespace App\Policies;

use App\Models\VideoSession;
use App\Models\User;

class AttendancePolicy
{
    public function checkIn(User $user, VideoSession $session): bool
    {
        if ($user->roles()->whereIn('name', ['admin', 'disciples'])->exists()) {
            return true;
        }

        return $user->courseEnrollments()
            ->where('course_id', $session->topic->course_id)
            ->exists();
    }
}