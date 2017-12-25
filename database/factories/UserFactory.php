<?php

use App\Model\Page;
use App\Model\Account;
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

$factory->define(App\Model\Page::class, function (Faker $faker) {
    $title = $faker->sentence(3);
    $account_id = Account::all()->random()->id;

    return [
        'slug' => str_slug($title),
        'content' => $faker->sentence(300),
        'banner' => $faker->imageUrl(700, 400),
        'seo_title' => $title,
        'seo_description' => $faker->sentence(),
        'seo_keywords' => $faker->sentence(5),
        'views' => $faker->numberBetween(0, 999),
        'sitemap' => $faker->boolean(85),
        'enabled' => $faker->boolean(85),
        'editable' => $faker->boolean(100),
        'creator_id' => $account_id,
        'editor_id' => $account_id,
        'updated_at' => $faker->dateTimeBetween('-10 months'),
        'created_at' => $faker->dateTimeBetween('-2 years', '-11 months'),
    ];
});

$factory->define(\App\Model\Menu::class, function (Faker $faker) {
    $page_id = Page::all()->random()->id;
    $account_id = Account::all()->random()->id;

    return [
            'title' => $faker->sentence(3),
            'page_id' => $page_id,
            'target' => '_self',
            'parent_id' => \App\Model\Menu::all()->random()->id,
            'lock' => $faker->boolean(6),
            'status' => $faker->boolean(84),
            'order' => 2,
            'creator_id' => $account_id,
            'editor_id' => $account_id,
            'updated_at' => $faker->dateTimeBetween('-10 months'),
            'created_at' => $faker->dateTimeBetween('-2 years', '-11 months'),
        ];
});

$factory->state(\App\Model\Menu::class, 'parent', function (Faker $faker) {
    $page_id = Page::all()->random()->id;
    $account_id = Account::all()->random()->id;

    return [
        'title' => $faker->sentence(1),
        'page_id' => $page_id,
        'parent_id' => null,
        'target' => '_self',
        'lock' => $faker->boolean(6),
        'status' => $faker->boolean(84),
        'order' => 2,
        'creator_id' => $account_id,
        'editor_id' => $account_id,
        'updated_at' => $faker->dateTimeBetween('-10 months'),
        'created_at' => $faker->dateTimeBetween('-2 years', '-11 months'),
    ];
});
