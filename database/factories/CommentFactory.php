<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'comment' => $faker->realText($maxNbChars = 100, $indexSize = 2),
        'status' => rand(0,1),
        'user_id' => rand(1, 5)
    ];
});
