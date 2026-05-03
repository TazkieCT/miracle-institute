<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;

class CertificateDownloadController extends Controller
{
    public function __invoke(Certificate $certificate)
    {
        $this->authorize('download', $certificate);

        abort_unless(
            $certificate->file_path && Storage::disk('public')->exists($certificate->file_path),
            404,
            'Certificate file not found.'
        );

        return Storage::disk('public')->download(
            $certificate->file_path,
            basename($certificate->file_path)
        );
    }
}