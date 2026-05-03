<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Topic;
use App\Models\TopicProgress;
use Illuminate\Support\Str;

class CertificateService
{
    public function issueTopicCertificate(string $userId, string $courseId, string $topicId): Certificate
    {
        $certificate = Certificate::firstOrCreate(
            [
                'user_id' => $userId,
                'type' => 'topic',
                'course_id' => $courseId,
                'topic_id' => $topicId,
            ],
            [
                'certificate_number' => $this->generateNumber('TOPIC'),
                'status' => 'draft',
                'issued_at' => null,
                'file_path' => null,
            ]
        );

        return $certificate->fresh();
    }

    public function issueCourseCertificateIfEligible(string $userId, string $courseId): ?Certificate
    {
        if (!$this->isCourseEligible($userId, $courseId)) {
            return null;
        }

        $certificate = Certificate::firstOrCreate(
            [
                'user_id' => $userId,
                'type' => 'course',
                'course_id' => $courseId,
                'topic_id' => null,
            ],
            [
                'certificate_number' => $this->generateNumber('COURSE'),
                'status' => 'draft',
                'issued_at' => null,
                'file_path' => null,
            ]
        );

        return $certificate->fresh();
    }

    public function isCourseEligible(string $userId, string $courseId): bool
    {
        $topicIds = Topic::where('course_id', $courseId)->pluck('id');

        if ($topicIds->isEmpty()) {
            return false;
        }

        $completedCount = TopicProgress::whereHas('courseEnrollment', function ($query) use ($userId, $courseId) {
            $query->where('user_id', $userId)
                ->where('course_id', $courseId);
        })
            ->whereIn('topic_id', $topicIds)
            ->where('status', 'completed')
            ->count();

        return $completedCount === $topicIds->count();
    }

    public function needsPdfGeneration(Certificate $certificate): bool
    {
        return empty($certificate->file_path) || $certificate->status !== 'issued';
    }

    public function generateNumber(string $prefix): string
    {
        return sprintf(
            'CERT-%s-%s-%s',
            $prefix,
            now()->format('Ymd'),
            Str::upper(Str::random(8))
        );
    }

    public function pdfPathFor(Certificate $certificate): string
    {
        return 'certificates/' . $certificate->certificate_number . '.pdf';
    }
}