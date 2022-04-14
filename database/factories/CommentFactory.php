<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        "content"       => $faker->paragraph,
        'article_id'    => $faker->randomElement(App\Article::pluck('id')->toArray()),
        'user_id'       => $faker->randomElement(App\User::pluck('id')->toArray()),
    ];
});