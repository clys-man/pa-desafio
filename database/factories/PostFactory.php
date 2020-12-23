<?php

/** @var Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Post::class, function (Faker $faker) {

    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'user_id' => \App\User::all('id')->random(),
    ];
});
