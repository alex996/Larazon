<?php

namespace App\Observers;

use App\Models\User;

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
        // Whenever a user is created, auto-generate their uid, if needed
        if (! $user->isDirty('uid')) {
            $user->uid = str_random(14);
        }
    }
}