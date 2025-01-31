<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function isDeveloper(User $user): bool
    {
        return $user->role === 'developer';
    }

    public function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function isOperator(User $user): bool
    {
        return $user->role === 'operator';
    }
}
