<?php

namespace App\Repositories;

use App\Models\CourseEnrollment;
use Illuminate\Support\Carbon;

class EnrollmentRepository
{
    public function enroll($userId, $courseId)
    {
        return CourseEnrollment::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'status' => 'active',
            'enrolled_at' => now()
        ]);
    }

    public function complete($enrollmentId)
    {
        return CourseEnrollment::where('id', $enrollmentId)
            ->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);
    }
}