<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = ['title', 'imdb_number', 'year', 'poster'];
}
