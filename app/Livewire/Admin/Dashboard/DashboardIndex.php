<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Assessment;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\StudyProgram;
use App\Models\Topic;
use App\Models\User;
use Livewire\Component;

class DashboardIndex extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard.index', [
            'usersCount' => User::count(),
            'studyProgramsCount' => StudyProgram::count(),
            'coursesCount' => Course::count(),
            'topicsCount' => Topic::count(),
            'assessmentsCount' => Assessment::count(),
            'certificatesCount' => Certificate::count(),
            'latestCertificates' => Certificate::with(['user', 'course', 'topic'])->latest()->take(8)->get(),
            'latestCourses' => Course::with('studyProgram')->latest()->take(6)->get(),
        ])->layout('layouts.admin');
    }
}