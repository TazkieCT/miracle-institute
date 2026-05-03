<?php

namespace App\Livewire\Admin\Roles;

use App\Livewire\Concerns\WithAdminTableState;
use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class RoleIndex extends Component
{
    use WithAdminTableState;

    public ?string $editingId = null;
    public string $name = '';
    public string $label = '';
    public ?string $description = null;
    public array $permissionIds = [];

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
        $this->resetForm();
    }

    public function edit(string $id): void
    {
        $row = Role::with('permissions')->findOrFail($id);

        $this->editingId = $row->id;
        $this->name = $row->name;
        $this->label = $row->label;
        $this->description = $row->description;
        $this->permissionIds = $row->permissions->pluck('id')->toArray();
    }

    public function save(): void
    {
        $this->validate();

        $role = Role::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $this->name,
                'label' => $this->label,
                'description' => $this->description,
            ]
        );

        $role->permissions()->sync($this->permissionIds);

        $this->resetForm();
    }

    public function delete(string $id): void
    {
        Role::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.roles.index', [
            'rows' => Role::with('permissions')->latest()->paginate($this->perPage),
            'permissions' => Permission::orderBy('name')->get(),
        ])->layout('layouts.admin');
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'label', 'description', 'permissionIds']);
    }
}