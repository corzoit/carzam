<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Car::class, function (Faker\Generator $faker) {
	$makes = ['Toyota', 'BMW', 'Audi', 'Seat', 'Nissan'];
	$make = $makes[array_rand($makes)];

    return [
        'make' => $make,
        'model' => $faker->name,
        'badge' => $faker->name,
        'variant' => $faker->name,
        'color' => $faker->name,
    ];
});