<?php

namespace App\Http\Middleware;

use App\Models\Course;
use App\Models\Topic;
use Closure;
use Illuminate\Http\Request;

class EnsureCourseEnrollment
{
    public function handle(Request $request, Closure $next, string $param = 'course')
    {
        if (!auth()->check()) {
            abort(401);
        }

        $activeRole = session('active_role');

        // Admin dan disciples diberi akses penuh ke area learning sesuai requirement.
        if (in_array($activeRole, ['admin', 'disciples'], true)) {
            return $next($request);
        }

        $subject = $request->route($param);

        $course = null;

        if ($subject instanceof Course) {
            $course = $subject;
        } elseif ($subject instanceof Topic) {
            $course = $subject->course;
        } elseif (is_string($subject)) {
            $course = Course::where('slug', $subject)->first();
        }

        if (!$course) {
            abort(404);
        }

        $enrolled = $request->user()
            ->courseEnrollments()
            ->where('course_id', $course->id)
            ->exists();

        if (!$enrolled) {
            abort(403, 'Anda belum terdaftar pada course ini.');
        }

        return $next($request);
    }
}