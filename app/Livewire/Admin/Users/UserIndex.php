<?php

namespace App\Livewire\Admin\Users;

use App\Livewire\Concerns\WithAdminTableState;
use App\Models\User;
use Livewire\Component;

class UserIndex extends Component
{
    use WithAdminTableState;

    public function render()
    {
        return view('livewire.admin.users.index', [
            'rows' => User::with('roles')
                ->when($this->search, function ($q) {
                    $q->where(function ($inner) {
                        $inner->where('name', 'like', "%{$this->search}%")
                            ->orWhere('name', 'like', "%{$this->search}%")
                            ->orWhere('email', 'like', "%{$this->search}%");
                    });
                })
                ->latest()
                ->paginate($this->perPage),
        ])->layout('layouts.admin');
    }
}