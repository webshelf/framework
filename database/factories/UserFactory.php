<?php

use Faker\Generator as Faker;
use App\Classes\Roles\Administrator;
use App\Modules\Pages\Model\PageTypes;
use App\Modules\Pages\Model\PageOptions;

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
        'username' => $faker->userName,
        'forename' => $faker->firstName,
        'surname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'address' => $faker->address,
        'number' => $faker->phoneNumber,
        'last_login' => $faker->dateTimeBetween('-4 months'),
        'password' => 'password', // secret
        'remember_token' => str_random(10),
        'role_id' => Administrator::$key,
    ];
});

$factory->define(App\Model\Page::class, function (Faker $faker) {
    $title = $faker->sentence;
    $account = factory(App\Model\Account::class)->create();

    return [
        'seo_title' => $title,
        'seo_keywords' => $faker->paragraph(1),
        'seo_description' => $faker->paragraph(1),
        'prefix' => $faker->word,
        'slug' => str_slug($title),
        'views' => $faker->numberBetween(75, 900),
        'content' => $faker->paragraph(12),
        'type' => PageTypes::TYPE_STANDARD,
        'option' => PageOptions::OPTION_PUBLIC | PageOptions::OPTION_SITEMAP,
        'editor_id' => $account->id,
        'creator_id' => $account->id,
    ];
});

$factory->define(App\Model\Plugin::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'enabled' => false,
        'installed' => false,
        'hidden' => false,
        'required' => false,
        'is_frontend' => false,
        'is_backend' => false,
    ];
});

$factory->define(App\Model\Article::class, function (Faker $faker) {
    $creator = factory('App\Model\Account')->create();
    $title = $faker->sentence;

    return [
        'title' => $title,
        'slug' => str_slug($title),
        'content' => $faker->paragraph,
        'featured_img' => $faker->imageUrl(),
        'publish_date' => $faker->dateTimeBetween('-1 months'),
        'unpublish_date' => null,
        'views' => $faker->numberBetween(100, 9999),
        'sitemap' => true,
        'category_id' => factory('App\Model\Categories')->create()->id,
        'editor_id' => $creator->id,
        'creator_id' => $creator->id,
        'status' => true,
        'deleted_at' => null,
        'created_at' => $faker->dateTimeBetween('-12 months'),
        'updated_at' => $faker->dateTimeBetween('-5 months'),
    ];
});

$factory->define(App\Model\Categories::class, function (Faker $faker) {
    $title = $faker->word;
    $creator = factory('App\Model\Account')->create()->id;

    return [
        'title' => $title,
        'status' => $faker->boolean,
        'slug' => str_slug($title),
        'editor_id' => $creator,
        'creator_id' => $creator,
        'deleted_at' => null,
        'created_at' => $faker->dateTimeBetween('-12 months'),
        'updated_at' => $faker->dateTimeBetween('-5 months'),
    ];
});

$factory->define(\App\Model\Menu::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'target' => $faker->randomElement(['_self', '_blank']),
        'status' => true,
        'lock' => false,
        'page_id' => factory(\App\Model\Page::class)->create()->getKey(),
    ];
});

$factory->define(\App\Model\Configuration::class, function (Faker $faker) {
    return [
        'key' => $faker->word,
        'value' => collect([$faker->word, $faker->numberBetween(0, 999), $faker->boolean(50)])->random(),
        'description' => $faker->paragraph,
        'updated_at' => $faker->dateTimeBetween('-3 months'),
    ];
});
