<?php

use App\Model\Page;
use App\Model\Account;
use Faker\Generator as Faker;

use App\Model as Model;

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

$factory->define(Model\Account::class, function (Faker $faker) {
    return [
        'forename' => $faker->firstName,
        'surname' => $faker->lastName,
        'address' => $faker->address,
        'number' => $faker->phoneNumber,
        'verified' => $faker->boolean(92),
        'login_count' => $faker->numberBetween(0, 760),
        'ip_address' => $faker->ipv4,
        'last_login' => $faker->dateTimeBetween('-4 months'),
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'role_id' => $faker->numberBetween(2, 3),
    ];
});