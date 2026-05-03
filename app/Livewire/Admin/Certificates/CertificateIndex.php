<?php

namespace App\Livewire\Admin\Certificates;

use App\Livewire\Concerns\WithAdminTableState;
use App\Models\Certificate;
use Livewire\Component;

class CertificateIndex extends Component
{
    use WithAdminTableState;

    public string $type = '';
    public string $status = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'status' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function render()
    {
        $rows = Certificate::with(['user', 'course', 'topic'])
            ->when($this->search, fn ($q) => $q->where('certificate_number', 'like', "%{$this->search}%"))
            ->when($this->type, fn ($q) => $q->where('type', $this->type))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.certificates.index', compact('rows'))->layout('layouts.admin');
    }

    public function delete(string $id): void
    {
        Certificate::findOrFail($id)->delete();
    }
}