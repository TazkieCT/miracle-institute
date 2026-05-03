<?php

namespace App\Policies;

use App\Models\Certificate;
use App\Models\User;

class CertificatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('manage_certificates');
    }

    public function view(User $user, Certificate $certificate): bool
    {
        return $certificate->user_id === $user->id;
    }

    public function update(User $user): bool
    {
        return $user->hasPermission('manage_certificates');
    }

    public function download(User $user, Certificate $certificate): bool
    {
        return $this->view($user, $certificate);
    }
}