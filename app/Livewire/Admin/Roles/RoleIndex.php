<?php

namespace App\Livewire\Admin\Roles;

use App\Livewire\Concerns\WithAdminTableState;
use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class RoleIndex extends Component
{
    use WithAdminTableState;

    public bool $readOnly = true;

    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public ?string $deleteId = null;

    public ?string $editingId = null;
    public string $name = '';
    public string $label = '';
    public ?string $description = null;
    public array $permissionIds = [];

    public function mount(): void
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissionIds' => 'array',
        ];
    }

    public function create(): void
    {
        $this->toast('info', 'Role bersifat read-only dan tidak bisa diubah.');
    }

    public function edit(string $id): void
    {
        $this->toast('info', 'Role bersifat read-only dan tidak bisa diubah.');
    }

    public function confirmDelete(string $id): void
    {
        $this->toast('info', 'Role bersifat read-only dan tidak bisa dihapus.');
    }

    private function toast(string $type, string $message): void
    {
        $this->dispatch('toast', type: $type, message: $message);
    }

    public function save(): void
    {
        $this->toast('warning', 'Role bersifat read-only dan tidak bisa disimpan.');
    }

    public function delete(): void
    {
        $this->toast('warning', 'Role bersifat read-only dan tidak bisa dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.roles.index', [
            'rows' => Role::with('permissions')->latest()->paginate($this->perPage),
            'permissions' => Permission::all()->sortBy('name')->values(),
        ])->layout('layouts.admin');
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'label', 'description', 'permissionIds']);
    }
}
