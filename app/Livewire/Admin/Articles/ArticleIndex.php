<?php

namespace App\Livewire\Admin\Articles;

use App\Livewire\Concerns\WithAdminTableState;
use App\Models\Article;
use Livewire\Component;

class ArticleIndex extends Component
{
    use WithAdminTableState;

    public ?string $editingId = null;
    public string $title = '';
    public string $author = '';
    public string $content = '';
    public string $status = 'active';

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|string|max:50',
        ];
    }

    public function edit(string $id): void
    {
        $row = Article::findOrFail($id);
        $this->editingId = $row->id;
        $this->title = $row->title;
        $this->author = $row->author;
        $this->content = $row->content;
        $this->status = $row->status;
    }

    public function save(): void
    {
        $this->validate();

        Article::updateOrCreate(
            ['id' => $this->editingId],
            [
                'title' => $this->title,
                'author' => $this->author,
                'content' => $this->content,
                'status' => $this->status,
            ]
        );

        $this->reset(['editingId', 'title', 'author', 'content', 'status']);
        $this->status = 'active';
    }

    public function delete(string $id): void
    {
        Article::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.articles.index', [
            'rows' => Article::when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
                ->latest()
                ->paginate($this->perPage),
        ])->layout('layouts.admin');
    }
}