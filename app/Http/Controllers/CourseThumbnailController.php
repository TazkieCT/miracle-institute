<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CourseThumbnailController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $file = $validated['thumbnail'];
        $dir = public_path('images/thumbnail');

        File::ensureDirectoryExists($dir);

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug($originalName) . '-' . Str::lower(Str::random(6)) . '.' . $extension;

        $file->move($dir, $filename);

        return back()->with('success', 'Thumbnail berhasil diupload dan masuk ke library sistem.');
    }
}
