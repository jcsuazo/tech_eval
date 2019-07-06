<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/test', function (Request $request) {
    return $request->user()->id;
});
Route::apiResource('user', 'API\UserController')->middleware('auth:api');
Route::get('findUser', 'API\UserController@findUser')->middleware('auth:api');
Route::apiResource('movie', 'API\MovieController')->middleware('auth:api');
Route::get('findMovie', 'API\MovieController@findMovie')->middleware('auth:api');
Route::apiResource('favorites', 'API\FavoritesController')->middleware('auth:api');
