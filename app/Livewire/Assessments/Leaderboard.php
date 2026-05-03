<?php

namespace App\Livewire\Assessments;

use Livewire\Component;
use App\Models\AssessmentAttempt;
use App\Models\User;

class Leaderboard extends Component
{
    public $assessmentId;

    public function render()
    {
        $leaders = AssessmentAttempt::with('user')
            ->where('assessment_id', $this->assessmentId)
            ->whereNotNull('score')
            ->orderByDesc('score')
            ->orderBy('duration_seconds')
            ->limit(10)
            ->get();

        return view('livewire.assessments.leaderboard', [
            'leaders' => $leaders
        ]);
    }
}