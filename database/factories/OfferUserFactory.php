<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use App\Models\OfferUser;
use App\Models\Offer;
use App\Models\Status;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(OfferUser::class, function (Faker $faker) {
    return [
        "user_id" => factory(User::class)->create(),
        "offer_id" => factory(Offer::class)->create(),
        "status_id" => factory(Status::class)->create(),
    ];
});
