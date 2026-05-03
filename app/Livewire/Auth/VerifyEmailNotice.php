<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class VerifyEmailNotice extends Component
{
    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        
        auth()->user()->sendEmailVerificationNotification();

        session()->flash('status', 'Link verifikasi sudah dikirim ulang.');
    }

    public function render()
    {
        return view('livewire.auth.verify-email-notice')->layout('layouts.guest');
    }
}