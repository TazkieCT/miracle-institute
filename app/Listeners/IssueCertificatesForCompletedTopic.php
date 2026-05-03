<?php

namespace App\Listeners;

use App\Events\TopicCompleted;
use App\Jobs\GenerateCertificatePdfJob;
use App\Services\CertificateService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IssueCertificatesForCompletedTopic implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'certificates';

    public function handle(TopicCompleted $event, CertificateService $certificateService): void
    {
        $topicCertificate = $certificateService->issueTopicCertificate(
            $event->userId,
            $event->courseId,
            $event->topicId
        );

        if ($certificateService->needsPdfGeneration($topicCertificate)) {
            GenerateCertificatePdfJob::dispatch($topicCertificate->id)->afterCommit();
        }

        $courseCertificate = $certificateService->issueCourseCertificateIfEligible(
            $event->userId,
            $event->courseId
        );

        if ($courseCertificate && $certificateService->needsPdfGeneration($courseCertificate)) {
            GenerateCertificatePdfJob::dispatch($courseCertificate->id)->afterCommit();
        }
    }
}