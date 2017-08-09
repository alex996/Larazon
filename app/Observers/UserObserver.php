<?php

namespace App\Observers;

use App\Models\User;
use Ramsey\Uuid\Uuid;

class UserObserver
{
    /**
     * Listen to the User creating event.
     *
     * @param  User  $user
     * @return void
     */
    public function creating(User $user)
    {
        // Whenever a user is created, auto-generate their uuid, if needed
        if (! $user->isDirty('uuid')) {
            $user->uuid = Uuid::uuid4()->toString();
        }
    }
}