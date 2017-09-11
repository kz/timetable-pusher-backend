<?php

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

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
    Route::group(['prefix' => 'v1', 'namespace' => 'V1', 'middleware' => ['auth.api']], function () {
        Route::get('timetable', 'TimetableController@index');

        /**
         * Creates a job for pins to be pushed
         *
         * timetable_id
         * timeline_token
         * offset_from_utc (minutes)
         * week [current|next]
         * day (optional) [0 - 6, 0 = Monday, 6 = Sunday]
         */
        Route::post('job/create', 'JobController@store');

        /**
         * Deletes all pins from two days in the past
         *
         * timeline_token
         */
        Route::delete('job', 'JobController@destroy');
    });
});