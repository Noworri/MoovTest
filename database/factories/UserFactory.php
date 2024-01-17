<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'last_name' => $faker->name,
        'first_name' => $faker->name,
        'user_id' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'mobile_phone' => $faker->unique()->phoneNumber,
        'email_verified_at' => now(),
        'password' => md5('abalo'), // password
        'remember_token' => Str::random(10),
    ];
});
