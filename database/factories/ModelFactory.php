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
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'permission'     => 'Super Admin',
    ];
});

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;
    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Service::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->text($maxNbChars = 15),
        'description' => $faker->sentence($nbWords = 10, $variableNbWords = true),
    ];
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->text($maxNbChars = 15),
        'description' => $faker->sentence($nbWords = 10, $variableNbWords = true),
    ];
});

$factory->define(App\Models\Sermon::class, function (Faker\Generator $faker) {
    return [
        'title'      => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'preacher'   => $faker->name,
        'service_id' => function () {
            return factory(App\Models\Service::class)->create()->id;
        },
        'category_id' => function () {
            return factory(App\Models\Category::class)->create()->id;
        },
        'datepreached' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'size'         => $faker->randomDigitNotNull,
    ];
});

$factory->define(App\Models\Setting::class, function (Faker\Generator $faker) {
    return [
        'name' => "setting",
        'churchName' => "GlobalInc",
        'contactEmail' => "globlinc@cs.co",
        'vision' => 'Love and Grace',
        'welcomeEmailHeading' => "Dearly beloved",
        'welcomeEmailBody' => "Glad you signed up on this platform... blah blah blah...",
        'plan_id' => "premium-01",
        'plan_name' => "Premium-01",
        'plan_amount' => 300,
        'plan_interval' => 1,
    ];
});
