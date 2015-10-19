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

Route::get('/', function () {
    return view('homepage');
});

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', 'SessionController@create');
        Route::post('login', 'SessionController@store');
        Route::get('register', 'UserController@create');
        Route::post('register', 'UserController@store');
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::post('logout', 'SessionController@destroy');
    });
});
