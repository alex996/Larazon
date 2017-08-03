<?php

use App\Models;
use Faker\Generator as Faker;

$factory->define(Models\CartItem::class, function (Faker $faker) {
    return [
        'cart_id' => factory(Models\Cart::class)->create()->id,
        'product_id' => factory(Models\Product::class)->create()->id,
        'quantity' => $faker->randomDigit
    ];
});
