<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Offer;
use App\Models\OfferCategory;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Offer::class, function (Faker $faker) {
    return [
        "user_id" => factory(User::class)->create(),
        "category_id" => factory(OfferCategory::class)->create(),
        "start_at" => Carbon::now()->format('Y-m-d H:s:i'),
        "end_at" =>  Carbon::now()->addDay()->format('Y-m-d H:s:i'),
        "price_per_hour" => $faker->randomFloat(2, 1, 1000),
        "address" => $faker->address,
        "preferred_qualifications" => $faker->text(),
        "status_id" => factory(Status::class)->create(),
    ];
});
