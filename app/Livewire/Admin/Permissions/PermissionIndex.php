<?php

namespace App\Livewire\Admin\Permissions;

use App\Livewire\Concerns\WithAdminTableState;
use App\Models\Permission;
use Livewire\Component;
use Illuminate\Support\Str;

class PermissionIndex extends Component
{
    use WithAdminTableState;

    public ?string $editingId = null;
    public string $name = '';

    public function create(): void
    {
        $this->resetForm();
    }

    public function edit(string $id): void
    {
        $row = Permission::findOrFail($id);
        $this->editingId = $row->id;
        $this->name = $row->name;
    }

    public function save(): void
    {
        $this->validate(['name' => 'required|string|max:255']);

        Permission::updateOrCreate(
            ['id' => $this->editingId],
            [
                'id' => $this->editingId ?? (string) Str::uuid(),
                'name' => $this->name,
            ]
        );

        $this->resetForm();
    }

    public function delete(string $id): void
    {
        Permission::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.permissions.index', [
            'rows' => Permission::when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
                ->latest()
                ->paginate($this->perPage),
        ])->layout('layouts.admin');
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'name']);
    }
}