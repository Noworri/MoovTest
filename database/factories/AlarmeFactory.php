<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Alarme;
use Faker\Generator as Faker;

$factory->define(Alarme::class, function (Faker $faker) {
    return [
        'num_module' => $faker->phoneNumber,
        'error' => $faker->text,
    ];
});
