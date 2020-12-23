<?php

/** @var Factory $factory */

use App\Tag;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Tag::class, function (Faker $faker) {
    $post = \App\Post::all('id')->random();
    $post->tags()->sync([
        $faker->randomDigitNotNull,
        $faker->randomDigitNotNull,
        $faker->randomDigitNotNull,
        $faker->randomDigitNotNull
    ]);
    return [
        'title' => $faker->randomElement([
            "organization","planning","collaboration", "writing",
            "calendar", "api","json", "schema","node",
            "github", "rest", "web","framework",
            "node", "http2", "https", "localhost"
        ]),
        'description' => $faker->paragraph,
    ];
});
