<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('manage_users');
    }

    public function view(User $user, User $target): bool
    {
        return $user->hasPermission('manage_users');
    }

    public function assignRole(User $user): bool
    {
        return $user->hasPermission('manage_users');
    }

    public function manage(User $user): bool
    {
        return $user->hasPermission('manage_users');
    }
}