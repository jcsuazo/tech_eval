<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Movie;
use Faker\Generator as Faker;

$factory->define(Movie::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'imdb_number' => $faker->randomNumber(7),
        'year' => $faker->year(),
        'poster' => 'movie.jpg'
    ];
});
