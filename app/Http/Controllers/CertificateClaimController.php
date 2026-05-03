<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateCertificatePdfJob;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Topic;
use App\Models\TopicProgress;
use App\Services\CertificateService;
use Illuminate\Http\Request;

class CertificateClaimController extends Controller
{
    public function course(Request $request, Course $course, CertificateService $certificateService)
    {
        $user = $request->user();

        $certificate = Certificate::where('user_id', $user->id)
            ->where('type', 'course')
            ->where('course_id', $course->id)
            ->first();

        if ($certificate && $certificate->file_path) {
            return redirect()->route('certificates.download', $certificate->id);
        }

        $issued = $certificateService->issueCourseCertificateIfEligible($user->id, $course->id);

        if (! $issued) {
            return back()->with('error', 'Certificate belum bisa di-claim karena course belum selesai.');
        }

        GenerateCertificatePdfJob::dispatchSync($issued->id);

        return redirect()->route('certificates.download', $issued->id);
    }

    public function topic(Request $request, Topic $topic, CertificateService $certificateService)
    {
        $user = $request->user();

        $progress = TopicProgress::where('topic_id', $topic->id)
            ->whereHas('courseEnrollment', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->first();

        if (! $progress || $progress->status !== 'completed') {
            return back()->with('error', 'Certificate belum bisa di-claim karena topic belum selesai.');
        }

        $certificate = Certificate::where('user_id', $user->id)
            ->where('type', 'topic')
            ->where('topic_id', $topic->id)
            ->first();

        if ($certificate && $certificate->file_path) {
            return redirect()->route('certificates.download', $certificate->id);
        }

        $issued = $certificateService->issueTopicCertificate(
            $user->id,
            $topic->course_id,
            $topic->id
        );

        if (! $issued) {
            return back()->with('error', 'Certificate gagal dibuat.');
        }

        GenerateCertificatePdfJob::dispatchSync($issued->id);

        return redirect()->route('certificates.download', $issued->id);
    }
}