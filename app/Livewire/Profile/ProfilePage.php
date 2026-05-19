<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ProfilePage extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $gender = '';
    public string $dob = '';

    public function mount(): void
    {
        $user = Auth::user();

        abort_unless($user, 401);

        $this->name = (string) $user->name;
        $this->email = (string) $user->email;
        $this->phone = (string) ($user->phone ?? '');
        $this->gender = (string) ($user->gender ?? '');
        $this->dob = $user->dob?->format('Y-m-d') ?? '';
    }

    protected function rules(): array
    {
        $userId = Auth::id();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'dob' => ['nullable', 'date', 'before_or_equal:today'],
        ];
    }

    public function save(): mixed
    {
        $validated = $this->validate();
        $user = Auth::user();

        abort_unless($user, 401);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?: null,
            'gender' => $validated['gender'] ?: null,
            'dob' => $validated['dob'] ?: null,
        ]);

        session()->flash('success', __('general.profile.flash.saved'));

        return null;
    }

    public function render()
    {
        $user = Auth::user()?->loadMissing('roles');
        $activeRole = session('active_role');
        $layout = $activeRole === 'admin' ? 'layouts.app' : 'layouts.learning';

        return view('livewire.profile.profile-page', [
            'user' => $user,
            'activeRole' => $activeRole,
        ])->layout($layout);
    }
}
