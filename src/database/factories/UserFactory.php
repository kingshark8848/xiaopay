<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

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

$factory->define(\App\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
    ];
});

$factory->state(\App\Models\User::class, 'enough_salary', function (Faker $faker) {
    $monthExpense = $faker->randomFloat(2,1000, 10000);
    $monthSalary = $monthExpense + $faker->randomFloat(2,1000,5000);
    return [
        'month_salary' => $monthSalary,
        'month_expense' => $monthExpense,
    ];
});

$factory->state(\App\Models\User::class, 'not_enough_salary', function (Faker $faker) {
    $monthExpense = $faker->randomFloat(2,1000, 10000);
    $monthSalary = $faker->randomFloat(2,0,$monthExpense + 999);
    return [
        'month_salary' => $monthSalary,
        'month_expense' => $monthExpense,
    ];
});
