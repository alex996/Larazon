<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'street', 'street_2', 'city', 'state', 'country', 'zip', 
    ];

    public function addressable()
    {
        return $this->morphTo();
    }
}
