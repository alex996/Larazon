<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function address()
    {
        return $this->belongsTo(Address::clas);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
