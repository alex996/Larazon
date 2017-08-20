<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * Get the value of the model's route key.
     *
     * @return mixed
     */
    public function getRouteKey()
    {
        return $this->uuid;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function subtotal()
    {
        return $this->products->sum(function($product) {
            return $product->price * $product->pivot->quantity;
        });
    }

    /*public function addProduct(Product $product, int $quantity = 1)
    {
        return $this->products()->attach(
            $product->id, compact('quantity')
        );
    }

    public function updateProduct(Product $product, array $attributes)
    {
        return $this->products()->updateExistingPivot(
            $product->id, $attributes
        );
    }*/
}
