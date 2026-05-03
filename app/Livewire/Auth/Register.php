<?php

namespace App\Livewire\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'first_name' => 'required|string|min:2|max:100',
        'last_name' => 'required|string|min:2|max:100',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required|string|min:8',
    ];

    protected $messages = [
        'first_name.required' => 'Nama depan wajib diisi.',
        'last_name.required' => 'Nama belakang wajib diisi.',
        'email.unique' => 'Email sudah terdaftar.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ];

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'email_verified_at' => now(),
        ]);

        $studentRole = Role::where('name', 'student')->firstOrFail();
        if ($studentRole) {
            $user->roles()->attach($studentRole->id, [
                'assigned_at' => now(),
            ]);
        }

        Auth::login($user);

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $user->sendEmailVerificationNotification();

        session()->flash('status', 'Silakan verifikasi email Anda.');
        return redirect()->route('verification.notice');
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.guest')->layout('layouts.guest');
    }
}