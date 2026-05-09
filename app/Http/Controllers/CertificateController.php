<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Services\CertificateService;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function claimCourse(Course $course, CertificateService $service)
    {
        abort_unless(auth()->check(), 403);

        $certificate = $service->issueCourseCertificate($course, auth()->user());

        return redirect()->route('certificates.download', $certificate->id);
    }

    public function download(Certificate $certificate, CertificateService $service)
    {
        abort_unless(auth()->check(), 403);

        abort_unless(
            auth()->id() === $certificate->user_id ||
            auth()->user()->can('manage_certificates'),
            403
        );

        abort_unless($certificate->status === 'issued', 404);

        $filename = Str::slug($certificate->certificate_number) . '.pdf';

        return $service->downloadCourseCertificate($certificate, $filename);
    }
}