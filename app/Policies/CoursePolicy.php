<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function viewAny(User $user): bool
    {
        // return $user->hasPermission('manage_courses');
        return true;
    }

    public function view(?User $user, Course $course): bool
    {
        return true;
    }

    public function enroll(User $user, Course $course): bool
    {
        return $user->hasPermission('enroll_course');
    }

    public function manage(User $user): bool
    {
        return $user->hasPermission('manage_courses');
    }
}