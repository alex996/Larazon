<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Billing\{ActsAsCustomer, HasCreditCards};

class User extends Authenticatable
{
    use Notifiable, ActsAsCustomer, HasCreditCards;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the value of the model's route key.
     *
     * @return mixed
     */
    public function getRouteKey()
    {
        return $this->uid;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uid';
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /*public function owns($entity)
    {
        return $this->id == $entity->user_id;
    }*/
}
