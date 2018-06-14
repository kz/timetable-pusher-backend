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
 * Web Routes
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

    Route::get('timetable/create', 'TimetableController@create');
    Route::post('timetable/create', 'TimetableController@store');
    Route::get('timetable/{id}', 'TimetableController@show');
    Route::get('timetable/{id}/edit', 'TimetableController@edit');
    Route::post('timetable/{id}/edit', 'TimetableController@update');
    Route::post('timetable/{id}/{delete}', 'TimetableController@destroy');
});

/*
 * Web Authentication Routes
 */
// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', 'AuthController@getLogin');
        Route::post('login', 'AuthController@postLogin');
        Route::get('register', 'AuthController@getRegister');
        Route::post('register', 'AuthController@postRegister');
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::get('logout', 'AuthController@getLogout');
    });
});



/*
 * API Routes
 */
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
    /*
     * Authorization: Bearer [TOKEN]
     */
    Route::group(['prefix' => 'v1', 'namespace' => 'V1', 'middleware' => ['auth.api.v1', 'cors']], function () {
        /*
         * GET timeline/
         */
        Route::get('timetable', 'TimetableController@index');

        /*
         * POST job/create
         * [x-www-form-urlencoded]
         * timetable_id
         * timeline_token
         * offset_from_utc (minutes)
         * week [current|next]
         * day (optional) [0 - 6, 0 = Monday, 6 = Sunday]
         */
        Route::post('job/create', 'JobController@store');

        /*
         * DELETE job/
         * [Deletes all pins from two days in the past]
         * [x-www-form-urlencoded]
         * timeline_token
         */
        Route::delete('job', 'JobController@destroy');
    });
});

/*
 * Config Page Routes
 */
Route::get('app/config', function () {
    return view('config');
});