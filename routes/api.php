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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'settings'], function () {
    Route::group(['prefix' => 'account'], function () {
        Route::group(['prefix' => 'update'], function () {
            Route::post('username', 'Auth\UpdateSettingsController@username');
            Route::post('email', 'Auth\UpdateSettingsController@email');
            Route::post('password', 'Auth\UpdateSettingsController@password');
        });
    });

    Route::group(['prefix' => 'billing'], function () {
        Route::group(['prefix' => 'update'], function () {
            Route::post('card', 'Auth\UpdateSettingsController@card');
        });
    });

    Route::group(['prefix' => 'subscription'], function () {
        Route::post('update', 'Auth\UpdateSettingsController@plan');
        Route::post('cancel', 'Auth\UpdateSettingsController@cancel');
    });
});
