<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OffersCategory;
use Faker\Generator as Faker;

$factory->define(OffersCategory::class, function (Faker $faker) {
    return [
        "name" => $faker->text(),
        "description" => $faker->text(),
    ];
});
