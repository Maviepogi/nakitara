<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any messages.
     */
    public function viewAny(User $user)
    {
        return true; // Any authenticated user can view their messages
    }

    /**
     * Determine whether the user can view the message.
     */
    public function view(User $user, Message $message)
    {
        // User can view the message if they are either the sender or receiver
        return $user->id === $message->sender_id || $user->id === $message->receiver_id;
    }

    /**
     * Determine whether the user can create messages.
     */
    public function create(User $user)
    {
        return true; // Any authenticated user can create messages
    }

    /**
     * Determine whether the user can update the message.
     */
    public function update(User $user, Message $message)
    {
        // Only the receiver can update (mark as read)
        return $user->id === $message->receiver_id;
    }

    /**
     * Determine whether the user can delete the message.
     */
    public function delete(User $user, Message $message)
    {
        // Both sender and receiver can delete
        return $user->id === $message->sender_id || $user->id === $message->receiver_id;
    }

    /**
     * Determine whether the user can restore the message.
     */
    public function restore(User $user, Message $message)
    {
        return $this->delete($user, $message);
    }

    /**
     * Determine whether the user can permanently delete the message.
     */
    public function forceDelete(User $user, Message $message)
    {
        return $this->delete($user, $message);
    }
}