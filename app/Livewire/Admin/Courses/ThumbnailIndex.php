<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ThumbnailIndex extends Component
{
    use WithFileUploads;

    public ?TemporaryUploadedFile $thumbnailUpload = null;

    protected function rules(): array
    {
        return [
            'thumbnailUpload' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ];
    }

    public function upload(): void
    {
        $this->validate();

        if (! $this->thumbnailUpload) {
            return;
        }

        $dir = public_path('images/thumbnail');
        File::ensureDirectoryExists($dir);

        $originalName = pathinfo($this->thumbnailUpload->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $this->thumbnailUpload->getClientOriginalExtension();
        $filename = Str::slug($originalName) . '-' . Str::lower(Str::random(6)) . '.' . $extension;

        $this->thumbnailUpload->move($dir, $filename);

        $this->thumbnailUpload = null;
        $this->resetValidation();

        $this->dispatch('toast', type: 'success', message: 'Thumbnail berhasil diupload dan siap dipakai.');
    }

    public function delete(string $path): void
    {
        if (! Str::startsWith($path, 'images/thumbnail/')) {
            $this->dispatch('toast', type: 'error', message: 'Path thumbnail tidak valid.');
            return;
        }

        $usageCount = Course::where('poster', $path)->count();

        if ($usageCount > 0) {
            $this->dispatch('toast', type: 'error', message: "Thumbnail sedang dipakai {$usageCount} course dan tidak bisa dihapus.");
            return;
        }

        $fullPath = public_path($path);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }

        $this->dispatch('toast', type: 'success', message: 'Thumbnail berhasil dihapus.');
    }

    public function render()
    {
        $dir = public_path('images/thumbnail');
        $usageMap = Course::query()
            ->selectRaw('poster, COUNT(*) as aggregate')
            ->whereNotNull('poster')
            ->groupBy('poster')
            ->pluck('aggregate', 'poster');

        $thumbnails = collect(File::exists($dir) ? File::files($dir) : [])
            ->filter(fn ($file) => in_array(Str::lower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true))
            ->sortByDesc(fn ($file) => $file->getMTime())
            ->map(function ($file) use ($usageMap) {
                $path = 'images/thumbnail/' . $file->getFilename();

                return [
                    'path' => $path,
                    'name' => $file->getFilename(),
                    'size_kb' => (int) ceil($file->getSize() / 1024),
                    'updated_at' => $file->getMTime(),
                    'usage_count' => (int) ($usageMap[$path] ?? 0),
                ];
            })
            ->values();

        return view('livewire.admin.courses.thumbnails', [
            'thumbnails' => $thumbnails,
            'stats' => [
                'total' => $thumbnails->count(),
                'used' => $thumbnails->where('usage_count', '>', 0)->count(),
                'unused' => $thumbnails->where('usage_count', 0)->count(),
            ],
        ])->layout('layouts.admin');
    }
}
