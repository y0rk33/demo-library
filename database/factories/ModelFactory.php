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

$factory->define(App\Book::class, function (Faker\Generator $faker) {
    return [
        'isbn' => rand(10000000000, 9999999999999),
        'title' => str_random(13),
        'edition' => rand(1, 10) + 'edition',
        'year' => \Carbon\Carbon::now(),
        'author' => str_random(20),
        'description' => str_random(255),
        'current_qty' => rand(1, 200),
        'total_qty' => rand(200, 600),
        'shelf_location' => str_random(10),
    ];
});