<?php

namespace App\Listeners;

use App\Events\AssessmentPassed;
use App\Services\ProgressService;

class HandleAssessmentPassed
{
    public function handle(AssessmentPassed $event, ProgressService $progressService): void
    {
        $progressService->markTopicCompleted(
            $event->userId,
            $event->topicId,
            $event->courseId
        );
    }
}