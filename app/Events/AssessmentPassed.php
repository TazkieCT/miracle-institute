<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssessmentPassed
{
    use Dispatchable, SerializesModels;

    public string $userId;
    public string $assessmentId;
    public string $topicId;
    public string $courseId;
    public string $attemptId;
    public int $score;

    public function __construct(
        string $userId,
        string $assessmentId,
        string $topicId,
        string $courseId,
        string $attemptId,
        int $score
    ) {
        $this->userId = $userId;
        $this->assessmentId = $assessmentId;
        $this->topicId = $topicId;
        $this->courseId = $courseId;
        $this->attemptId = $attemptId;
        $this->score = $score;
    }
}