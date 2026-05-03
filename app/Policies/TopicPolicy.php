<?php

namespace App\Policies;

use App\Models\Topic;
use App\Models\User;

class TopicPolicy
{
    public function view(User $user, Topic $topic): bool
    {
        return true;
    }

    public function access(User $user, Topic $topic): bool
    {
        return $user->hasPermission('access_topic');
    }

    public function manage(User $user): bool
    {
        return $user->hasPermission('manage_topics');
    }
}