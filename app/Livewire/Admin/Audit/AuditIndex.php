<?php

namespace App\Livewire\Admin\Audit;

use App\Livewire\Concerns\WithAdminTableState;
use App\Models\ActivityLog;
use App\Models\User;
use Livewire\Component;

class AuditIndex extends Component
{
    use WithAdminTableState;

    public string $action = '';
    public string $userId = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'action' => ['except' => ''],
        'userId' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function render()
    {
        $rows = ActivityLog::with('user')
            ->when($this->search, fn ($q) => $q->where('action', 'like', "%{$this->search}%"))
            ->when($this->action, fn ($q) => $q->where('action', $this->action))
            ->when($this->userId, fn ($q) => $q->where('user_id', $this->userId))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.audit.index', [
            'rows' => $rows,
            'users' => User::orderBy('name')->get(),
        ])->layout('layouts.admin');
    }
}