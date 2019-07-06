<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Movie;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')->count(); //number of users------1
        $movies = DB::table('movies')->count(); //number of movies------2
        $favorites = DB::table('favorites')->count(); //number of favorites----3
        $top_favorites_movies = DB::table('favorites')
            ->select(DB::raw('movie_id, count(*) as favorites_count'))
            ->orderBy('favorites_count', 'desc')
            ->groupBy('movie_id')
            ->paginate(3);
        // ---------
        $arr = [];
        foreach ($top_favorites_movies as $key) {
            $arr[] = Movie::find($key->movie_id);
        }

        // ---------
        return [
            'users' => $users,
            'movies' => $movies,
            "favorites_count" => $favorites,
            'top_favorites_movies' => $arr
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
