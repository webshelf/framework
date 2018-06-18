<?php

use App\Model\Page;
use App\Model\Account;
use Faker\Generator as Faker;

use App\Plugins\Pages\Model\PageOptions;
use App\Plugins\Pages\Model\PageTypes;

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
        'email' => $faker->unique()->safeEmail,
        'address' => $faker->address,
        'number' => $faker->phoneNumber,
        'last_login' => $faker->dateTimeBetween('-4 months'),
        'password' => 'password', // secret
        'remember_token' => str_random(10),        
    ];
});

$factory->define(App\Model\Page::class, function(Faker $faker) {

    $title = $faker->sentence;
    $account = factory(App\Model\Account::class)->create();

    return [
        'seo_title' => $title,
        'seo_keywords' => $faker->paragraph(1),
        'seo_description' => $faker->paragraph(2),
        'prefix' => $faker->word,
        'slug' => str_slug($title),
        'views' => $faker->numberBetween(75,900),
        'content' => $faker->paragraph(12),
        'type' => PageTypes::TYPE_STANDARD,
        'option' => PageOptions::OPTION_PUBLIC|PageOptions::OPTION_SITEMAP,
        'editor_id' => $account->id,
        'creator_id' => $account->id,
    ];

});