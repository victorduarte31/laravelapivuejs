<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'category_id'   => 1,
        'name'          => $faker->unique()->word,
        'description'   => $faker->sentence(),
    ];
});
