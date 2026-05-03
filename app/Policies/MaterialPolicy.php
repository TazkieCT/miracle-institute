<?php

namespace App\Policies;

use App\Models\Material;
use App\Models\User;

class MaterialPolicy
{
    public function view(User $user, Material $material): bool
    {
        return $user->hasPermission('access_topic');
    }

    public function upload(User $user): bool
    {
        return $user->hasPermission('manage_topics');
    }

    public function delete(User $user, Material $material): bool
    {
        return $user->hasPermission('manage_topics');
    }

    public function manage(User $user): bool
    {
        return $user->hasPermission('manage_topics');
    }
}