<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager', 'Employee']);
    }

    public function view(User $user, Order $order): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager', 'Employee'])
            || ($user->hasRole('Driver') && $user->driverProfile?->id === $order->driver_id);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager', 'Employee']);
    }

    public function update(User $user, Order $order): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager', 'Employee'])
            || ($user->hasRole('Driver') && $user->driverProfile?->id === $order->driver_id);
    }

    public function delete(User $user, Order $order): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
    }
}
