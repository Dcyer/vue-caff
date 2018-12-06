<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    $now = \Carbon\Carbon::now()->toDateTimeString();

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'avatar' => $faker->imageUrl(200),
        'introduction' => $faker->sentence,
        'password' => '$2y$10$CSG857YIYvAASde0dPgyRuv8pM5amMqdgSeH22sX0bRzstf8cZ3Qi', // 123456
        'remember_token' => str_random(10),
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
