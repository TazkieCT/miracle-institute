<?php

namespace App\Livewire\Shared;

use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RoleSwitcher extends Component
{
    public $activeRole;
    public $roles = [];

    protected $listeners = [
        'roleSwitched' => '$refresh',
    ];

    public function mount(RoleService $roleService)
    {
        if (!Auth::check()) {
            return;
        }

        $user = Auth::user();

        $this->roles = $user
            ? $user->roles()->select('roles.id', 'roles.name', 'roles.label')->get()->toArray()
            : [];

        $this->activeRole = $roleService->getActiveRole($user);
    }

    public function switchRole(RoleService $roleService, string $roleName)
    {
        $roleService->switchRole(Auth::user(), $roleName);

        $this->activeRole = $roleName;
        // $this->emitUp('roleSwitched', $roleName);
        $this->dispatch('roleSwitched', role: $roleName);

        return redirect()->to(url()->previous());
    }

    public function render()
    {
        return view('livewire.shared.role-switcher');
    }
}