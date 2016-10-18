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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => str_random(5)
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'name' => str_random(8)
    ];
});

$factory->define(App\Article::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(mt_rand(1, 3)),
        'desc' => $faker->sentence(mt_rand(20, 70)),
        'content' => join("\n\n", $faker->paragraphs(mt_rand(3, 6))),
    ];
});
