<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Movie;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Movie::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = str_replace(' ', '_', $request->title) . '_' . time() . "." . explode(';', explode('/', $request->poster)[1])[0];
        \Image::make($request->poster)->save(public_path('img/profile/') . $name);
        $request->merge(['poster' => $name]);

        $validation = $request->validate(
            [
                'title' => ['required', 'string', 'max:191'],
                'imdb_number' => ['required', 'string', 'max:191'],
                'year' => ['required', 'string', 'max:191'],
                'poster' => ['required'],
            ]
        );
        // return Movie::create($validation);
        return Movie::create([
            'title' => $request['title'],
            'imdb_number' => $request['imdb_number'],
            'year' => $request['year'],
            'poster' => $request['poster'],
        ]);
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
    public function update(Request $request, Movie $movie)
    {
        $validation = $request->validate(
            [
                'title' => ['required', 'string', 'max:191'],
                'imdb_number' => ['required', 'string', 'max:191'],
                'year' => ['required', 'string', 'max:191'],
                'poster' => ['required'],

            ]
        );
        $movie->update($request->all());
        return ['message' => 'updated'];
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
