<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Course;
use App\Models\Topic;
use App\Models\User;
use App\Models\VideoSession;
use App\Models\Attendance;
use App\Models\Certificate;
use App\Models\StudyProgram;
use App\Models\Assessment;
use Livewire\Component;

class DashboardIndex extends Component
{
    public int $weeks = 1;

    public function setWeeks($weeks)
    {
        $this->weeks = (int) $weeks;
    }

    public function render()
    {
        $now = now();
        $startDate = $now->copy()->subWeeks($this->weeks)->startOfWeek();

        $recentSessions = VideoSession::with('topic.course')
            ->where('start_at', '<=', $now)
            ->latest('start_at')
            ->take(5)
            ->get();

        $upcomingSessions = VideoSession::with('topic.course')
            ->where('start_at', '>', $now)
            ->orderBy('start_at')
            ->take(5)
            ->get();

        $sessionsInRange = VideoSession::whereBetween('start_at', [$startDate, $now])->pluck('id');

        $attendanceStats = Attendance::whereIn('video_session_id', $sessionsInRange)
            ->selectRaw("status, COUNT(*) as total")
            ->groupBy('status')
            ->pluck('total', 'status');

        $total = $attendanceStats->sum();

        $attendance = [
            'present' => $attendanceStats['present'] ?? 0,
            'late' => $attendanceStats['late'] ?? 0,
            'absent' => $attendanceStats['absent'] ?? 0,
            'total' => $total,
            'present_pct' => $total ? round(($attendanceStats['present'] ?? 0) / $total * 100, 2) : 0,
            'late_pct' => $total ? round(($attendanceStats['late'] ?? 0) / $total * 100, 2) : 0,
            'absent_pct' => $total ? round(($attendanceStats['absent'] ?? 0) / $total * 100, 2) : 0,
        ];

        $problemSessions = VideoSession::with('topic.course')
            ->withCount([
                'attendances as total_attendance',
                'attendances as absent_count' => fn ($q) => $q->where('status', 'absent')
            ])
            ->whereBetween('start_at', [$startDate, $now])
            ->having('absent_count', '>', 0)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard.index', [
            'usersCount' => User::count(),
            'studyProgramsCount' => StudyProgram::count(),
            'coursesCount' => Course::count(),
            'topicsCount' => Topic::count(),
            'assessmentsCount' => Assessment::count(),
            'certificatesCount' => Certificate::count(),

            'latestCertificates' => Certificate::with(['user', 'course', 'topic'])
                ->latest()->take(5)->get(),

            'latestCourses' => Course::with('studyProgram')
                ->latest()->take(5)->get(),

            'attendance' => $attendance,
            'recentSessions' => $recentSessions,
            'upcomingSessions' => $upcomingSessions,
            'problemSessions' => $problemSessions,
        ])->layout('layouts.admin');
    }
}