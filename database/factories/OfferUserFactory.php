<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Offer;
use App\Models\OfferUser;
use App\Models\Status;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(OfferUser::class, function (Faker $faker) {
    return [
        "user_id" => factory(User::class)->create()->id,
        "offer_id" => factory(Offer::class)->create()->id,
        "status_id" => factory(Status::class)->create()->id
    ];
});
