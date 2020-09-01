  
<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Status;
use Faker\Generator as Faker;

$factory->define(Status::class, function (Faker $faker) {
    return [
        "name" => $faker->text(),
        "description" => $faker->text(),
        "code" => $faker->text(),
    ];
});
