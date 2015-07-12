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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@home');

// Authentication routes...
Route::get('login', 'Auth\AuthController@login');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('activate/{username}/{code}', 'Auth\AuthController@activate');
Route::get('signup', 'Auth\AuthController@signup');
Route::post('signup', 'Auth\AuthController@signup');
Route::get('successfull', 'Auth\AuthController@successfull');

