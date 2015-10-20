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

/*
 * Standard Routes
 */
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('homepage');
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('home', function() {
        return redirect('/dashboard');
    });
    Route::get('dashboard', 'DashboardController@show');

    Route::post('token/regenerate', 'TokenController@update');

    Route::get('timeline/create', 'TimelineController@create');
    Route::post('timeline/create', 'TimelineController@store');
    Route::get('timeline/{id}/edit', 'TimelineController@edit');
    Route::post('timeline/{id}', 'TimelineController@update');
    Route::post('timeline/{id}/{delete}', 'TimelineController@destroy');
});

/*
 * Authentication Routes
 */
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', 'AuthController@getLogin');
        Route::post('login', 'AuthController@postLogin');
        Route::get('register', 'AuthController@getRegister');
        Route::post('register', 'AuthController@postRegister');
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::post('logout', 'AuthController@getLogout');
    });
});

/*
 * API Routes
 */
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
    Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function () {
        Route::get('timelines', 'TimelineController@index');

        Route::post('pins', 'PinController@store');
        Route::delete('pins', 'PinController@destroy');
    });
});