<?php

namespace App\Livewire\Admin\Articles;

use App\Livewire\Concerns\WithAdminTableState;
use App\Models\Article;
use Livewire\Component;

class ArticleIndex extends Component
{
    use WithAdminTableState;

    public string $statusFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function delete(string $id): void
    {
        Article::findOrFail($id)->delete();
        session()->flash('success', 'Artikel berhasil dihapus.');
    }

    public function toggleStatus(string $id): void
    {
        $article = Article::findOrFail($id);

        $article->update([
            'status' => $article->status === 'active' ? 'inactive' : 'active',
        ]);

        session()->flash('success', 'Status artikel diperbarui.');
    }

    public function render()
    {
        $rows = Article::query()
            ->when($this->search, function ($q) {
                $q->where(function ($inner) {
                    $inner->where('title', 'like', "%{$this->search}%")
                        ->orWhere('author', 'like', "%{$this->search}%")
                        ->orWhere('content', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.articles.index', [
            'rows' => $rows,
            'stats' => [
                'total' => Article::count(),
                'active' => Article::where('status', 'active')->count(),
                'inactive' => Article::where('status', 'inactive')->count(),
                'draft' => Article::where('status', 'draft')->count(),
                'clicks' => (int) Article::sum('clicked'),
            ],
        ])->layout('layouts.admin');
    }
}