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

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
    Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function () {
        Route::get('timelines', 'TimelineController@index');

        Route::post('pins', 'PinController@store');
        Route::delete('pins', 'PinController@destroy');
    });
});