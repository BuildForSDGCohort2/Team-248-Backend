<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Offer;
use App\Models\OfferCategory;
use App\Models\Status;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Offer::class, function (Faker $faker) {
    return [
        "user_id" => factory(User::class)->create(),
        "category_id" => factory(OfferCategory::class)->create(),
        "start_at" => $faker->dateTimeInInterval("+1 days", "+2 days"),
        "end_at" => $faker->dateTimeInInterval("+3 days", "+5 days"),
        "price_per_hour" => $faker->randomFloat(2, 1, 1000),
        "address" => $faker->address,
        "preferred_qualifications" => $faker->text(),
        "status_id" => factory(Status::class)->create(),
    ];
});
