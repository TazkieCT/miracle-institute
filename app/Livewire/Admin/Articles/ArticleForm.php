<?php

namespace App\Livewire\Admin\Articles;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ArticleForm extends Component
{
    use WithFileUploads;

    public ?Article $article = null;
    public ?string $articleId = null;

    public string $title = '';
    public string $author = '';
    public string $content = '';
    public string $status = 'draft';

    public ?string $currentImage = null;
    
    public bool $showPreview = false;
    
    public $imageFile = null;
    public $imageUrl;

    public function updatedImageUrl($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            $this->imageFile = null;
        }
    }


    public function mount(?Article $article = null): void
    {
        $this->article = $article;
        $this->articleId = $article?->id;

        if ($article) {
            $this->title = $article->title;
            $this->author = $article->author;
            $this->content = $article->content;
            $this->status = $article->status;
            $this->currentImage = $article->image;
        } else {
            $this->author = Auth::user()?->full_name
                ?? Auth::user()?->name
                ?? '';
            $this->status = 'draft';
        }
    }

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'content' => 'required|string|min:20',
            'status' => 'required|in:draft,active,inactive',
            'imageFile' => $this->articleId
                ? 'nullable|image|max:4096'
                : 'required|image|max:4096',
        ];
    }

    public function getImagePreviewUrlProperty(): ?string
    {
        try {
            if ($this->imageFile) {
                return $this->imageFile->temporaryUrl();
            }

            if ($this->currentImage && Storage::disk('public')->exists($this->currentImage)) {
                return Storage::disk('public')->url($this->currentImage);
            }
        } catch (\Throwable $e) {
            return null;
        }

        return null;
    }

    public function updatedImageFile(): void
    {
        $this->validateOnly('imageFile');
    }

    public function openPreview(): void
    {
        $this->showPreview = true;
    }

    public function closePreview(): void
    {
        $this->showPreview = false;
    }

    public function save()
    {
        $this->validate();

        $imagePath = $this->currentImage;

        if ($this->imageFile) {
            if ($this->currentImage && Storage::disk('public')->exists($this->currentImage)) {
                Storage::disk('public')->delete($this->currentImage);
            }

            $imagePath = $this->imageFile->store('articles', 'public');
        }

        Article::updateOrCreate(
            ['id' => $this->articleId],
            [
                'title' => $this->title,
                'image' => $imagePath,
                'author' => $this->author,
                'content' => $this->content,
                'status' => $this->status,
            ]
        );

        session()->flash('success', 'Artikel berhasil disimpan.');

        return redirect()->route('admin.articles.index');
    }

    public function render()
    {
        return view('livewire.admin.articles.form')->layout('layouts.admin');
    }
}