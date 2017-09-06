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

$factory->define(App\Model\Account::class, function (Faker $faker) {
    static $password;

    return [
        'id' => $faker->numberBetween(0, 9999),
        'forename' => $faker->firstName,
        'surname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'role_id' => 1,
    ];
});

$factory->define(App\Model\Page::class, function (Faker $faker) {
    $title = $faker->sentence(5);

    return [
        'slug' => str_slug($title),
        'content' => $faker->sentence(300),
        'seo_title' => $title,
        'seo_description' => $faker->sentence(),
        'seo_keywords' => $faker->sentence(5),
        'views' => $faker->numberBetween(0, 999),
        'sitemap' => $faker->boolean(50),
        'enabled' => $faker->boolean(100),
        'created_at' => $faker->dateTimeBetween('-2 years', '-11 months'),
        'updated_at' => $faker->dateTimeBetween('-10 months'),
        'creator_id' => account()->id,
    ];
});
