<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OfferCategory;
use Faker\Generator as Faker;

$factory->define(OfferCategory::class, function (Faker $faker) {
    return [
        "name" => $faker->text(),
        "description" => $faker->text(),
    ];
});
