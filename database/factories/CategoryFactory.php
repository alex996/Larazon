<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Category::class, function (Faker $faker) {
    $slug = $faker->word;
    return [
        'slug' => $slug,
        'name' => ucfirst($slug)
    ];
});
