<?php

namespace App\Livewire\Concerns;

use Livewire\WithPagination;

trait WithAdminTableState
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    protected $paginationTheme = 'tailwind';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }
}