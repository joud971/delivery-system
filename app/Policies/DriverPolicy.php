<?php

namespace App\Policies;

use App\Models\Driver;
use App\Models\User;

class DriverPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
    }

    public function view(User $user, Driver $driver): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
    }

    public function update(User $user, Driver $driver): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
    }

    public function delete(User $user, Driver $driver): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
    }
}
