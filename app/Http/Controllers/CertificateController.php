<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Services\CertificateService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function claimCourse(Request $request, CertificateService $service)
    {
        $courseId = (string) $request->route('courseId', '');
        $course = Course::query()
            ->whereKey($courseId)
            ->first();

        abort_unless($course instanceof Course, 404);

        abort_unless(auth()->check(), 401);

        try {
            $certificate = $service->issueCourseCertificate($course, auth()->user());

            return redirect()->to(localized_route('certificates.download', $certificate->id));
            
        } catch (\RuntimeException $e) {

            return back()->with('error', $e->getMessage());
        }
    }

    public function download(Request $request, CertificateService $service)
    {
        $certificateId = (string) $request->route('certificateId', '');
        $certificate = Certificate::query()
            ->whereKey($certificateId)
            ->first();

        abort_unless($certificate instanceof Certificate, 404);

        abort_unless(auth()->check(), 401);

        abort_unless(
            auth()->id() == $certificate->user_id || auth()->user()->can('manage_certificates'),
            403
        );

        abort_unless($certificate->status === 'issued', 404);

        $filename = Str::slug($certificate->certificate_number) . '.pdf';

        return $service->downloadCourseCertificate($certificate, $filename);
    }
}
