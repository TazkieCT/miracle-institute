<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TopicCompleted
{
    use Dispatchable, SerializesModels;

    public string $userId;
    public string $topicId;
    public string $courseId;
    public string $enrollmentId;
    public string $topicProgressId;

    public function __construct(
        string $userId,
        string $topicId,
        string $courseId,
        string $enrollmentId,
        string $topicProgressId
    ) {
        $this->userId = $userId;
        $this->topicId = $topicId;
        $this->courseId = $courseId;
        $this->enrollmentId = $enrollmentId;
        $this->topicProgressId = $topicProgressId;
    }
}