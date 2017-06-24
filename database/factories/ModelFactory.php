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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Admin::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'permission' => 'Super Admin'
    ];
});

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Service::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->sentence($nbWords = 2, $variableNbWords = true),
        'description' => $faker->text($maxNbChars = 200),
        'sermonCount' => $faker->randomDigitNotNull,
    ];
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->sentence($nbWords = 2, $variableNbWords = true),
        'description' => $faker->text($maxNbChars = 200),
    ];
});

$factory->define(App\Models\Sermon::class, function (Faker\Generator $faker) {

    return [
        'title' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'preacher' => $faker->name,
        'service_id' => function () {
            return factory(App\Models\Service::class)->create()->id;
        },
        'category_id' => function () {
            return factory(App\Models\Category::class)->create()->id;
        },
        'datepreached' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'size' => $faker->randomDigitNotNull,
    ];
});
