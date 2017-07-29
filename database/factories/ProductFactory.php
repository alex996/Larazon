<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(5),
        'description' => $faker->paragraph,
        'price' => $faker->randomFloat(2, 0, 1000000),
        'quantity' => $faker->randomNumber,
    ];
});
