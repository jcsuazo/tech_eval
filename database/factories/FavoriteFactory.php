<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Favorite;
use Faker\Generator as Faker;

$factory->define(Favorite::class, function (Faker $faker) {
    return [
        'favorite' => $faker->boolean(50),
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'movie_id' => function () {
            return factory(\App\Movie::class)->create()->id;
        },
    ];
});
