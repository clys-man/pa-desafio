<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
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
