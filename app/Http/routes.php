<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Support\Facades\DB;



Route::get('weather/{town}/refresh', 'WeatherController@refresh');

Route::get('/', function()
{
    return view('main');
});

Route::resource('weather', 'WeatherController',
        ['only' => ['index','show','store']]);

/*
 * Route::get('/', function () {
    return 'Hello World';

    // return view('main');
});
 *
 *



Route::get('/', 'WeatherController@showWelcome');
*/