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
    dd($request->user());
});
Route::apiResource('user', 'API\UserController')->middleware('auth:api');
Route::apiResource('movie', 'API\MovieController')->middleware('auth:api');
