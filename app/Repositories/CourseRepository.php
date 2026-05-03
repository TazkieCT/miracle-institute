<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository
{
    public function getPublishedCourses()
    {
        return Course::with('studyProgram')
            ->where('status', 'active')
            ->get();
    }

    public function getCourseWithTopics($courseId)
    {
        return Course::with(['topics.materials', 'topics.sessions'])
            ->findOrFail($courseId);
    }

    public function isUserEnrolled($userId, $courseId)
    {
        return \App\Models\CourseEnrollment::where([
            'user_id' => $userId,
            'course_id' => $courseId
        ])->exists();
    }
}