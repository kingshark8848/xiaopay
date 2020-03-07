<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Account;
use Faker\Generator as Faker;

$factory->define(\App\Models\Account::class, function (Faker $faker) {
    return [
        "first_name" => $faker->firstName,
        "last_name" => $faker->lastName,
        "address" => $faker->address,
        "gender" => $faker->randomElement(\App\Models\Account::allGenders()),
        "date_of_birth" => $faker->date(),
        "balance" => $faker->randomFloat(2, 0, 10000),
    ];
});
