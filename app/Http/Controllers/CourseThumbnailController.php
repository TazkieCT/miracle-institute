<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CourseThumbnailController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $file = $validated['thumbnail'];
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug($originalName) . '-' . Str::lower(Str::random(6)) . '.' . Str::lower($extension);

        $stored = false;
        $lastErrorMessage = null;

        foreach (course_thumbnail_path_candidates($filename) as $targetPath) {
            try {
                File::ensureDirectoryExists(dirname($targetPath));
                File::put($targetPath, File::get($file->getRealPath()));
                $stored = true;
                break;
            } catch (\Throwable $exception) {
                $lastErrorMessage = $exception->getMessage();
            }
        }

        if (! $stored) {
            report(new \RuntimeException('Gagal menyimpan thumbnail course. ' . ($lastErrorMessage ?: 'Direktori penyimpanan tidak tersedia.')));

            return back()->withErrors([
                'thumbnail' => 'Thumbnail gagal diupload ke server. Periksa permission folder penyimpanan.',
            ])->withInput();
        }

        return back()->with('success', 'Thumbnail berhasil diupload dan masuk ke library sistem.');
    }

    public function show(string $path): BinaryFileResponse
    {
        $filePath = course_thumbnail_existing_path($path);

        abort_unless($filePath, 404);

        return response()->file($filePath, [
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
