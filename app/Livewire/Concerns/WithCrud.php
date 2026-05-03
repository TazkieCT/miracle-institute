<?php

namespace App\Livewire\Concerns;

trait WithCrud
{
    public $search = '';
    public $perPage = 10;
    public $confirmingDelete = false;
    public $deleteId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->deleteId = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->deleteId = null;
    }
}