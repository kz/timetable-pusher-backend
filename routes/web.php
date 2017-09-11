<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('homepage');
    });
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
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
 * Config Page Routes
 */
Route::get('app/config', function () {
    return view('config');
});