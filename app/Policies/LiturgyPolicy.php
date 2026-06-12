<?php

namespace App\Policies;

use App\Models\User;

class LiturgyPolicy
{
    
    public function manage(User $user): bool
    {
        return $user->hasPermission('manage-liturgies');
    }
}
