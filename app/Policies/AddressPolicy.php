<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Address;
use Illuminate\Auth\Access\HandlesAuthorization;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AddressPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the address.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Address  $address
     * @return mixed
     */
    public function delete(User $user, Address $address)
    {
        return $user->id == $address->addressable_id && $address->addressable_type = 'users';
    }
}
