<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $title = $faker->word;
    return [
        'title' => $title,
        'slug' => \Str::slug($title),
        'body' => $faker->paragraph,
        'status' => 1,
        'user_id' => rand(1, 5)
    ];
});
