<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $title = $faker->realText($maxNbChars = 50, $indexSize = 2);
    return [
        'title' => $title,
        'slug' => \Str::slug($title),
        'body' => $faker->realText($maxNbChars = 2000, $indexSize = 4),
        'status' => 1,
        'image' => $faker->image('public/uploads/posts', 640, 480, 'cats', false),
        'user_id' => rand(1, 5)
    ];
});
