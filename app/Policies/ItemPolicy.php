<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any items.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the item.
     */
    public function view(User $user, Item $item)
    {
        return true; // Anyone can view items
    }

    /**
     * Determine whether the user can create items.
     */
    public function create(User $user)
    {
        return true; // Any authenticated user can create items
    }

    /**
     * Determine whether the user can update the item.
     */
    public function update(User $user, Item $item)
    {
        return $user->id === $item->user_id || $user->is_admin;
    }

    /**
     * Determine whether the user can delete the item.
     */
    public function delete(User $user, Item $item)
    {
        return $user->id === $item->user_id || $user->is_admin;
    }

    /**
     * Determine whether the user can restore the item.
     */
    public function restore(User $user, Item $item)
    {
        return $user->id === $item->user_id || $user->is_admin;
    }

    /**
     * Determine whether the user can permanently delete the item.
     */
    public function forceDelete(User $user, Item $item)
    {
        return $user->id === $item->user_id || $user->is_admin;
    }
}
