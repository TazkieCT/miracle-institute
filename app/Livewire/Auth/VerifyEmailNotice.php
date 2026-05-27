<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class VerifyEmailNotice extends Component
{
    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->to(localized_route('dashboard'));
        }

        auth()->user()->sendEmailVerificationNotification();

        session()->flash('status', __('auth.verification_link_resent'));
    }

    public function render()
    {
        return view('livewire.auth.verify-email-notice')->layout('layouts.guest');
    }
}
