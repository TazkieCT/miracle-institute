<?php

namespace App\Policies;

use App\Models\User;

class PermissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('manage_users');
    }

    public function manage(User $user): bool
    {
        return $user->hasPermission('manage_users');
    }
}