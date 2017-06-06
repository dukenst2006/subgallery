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
        Route::group(['prefix' => 'card'], function () {
            Route::post('update', 'Auth\UpdateSettingsController@card');
        });

        Route::group(['prefix' => 'invoices'], function () {
            Route::get('get', 'Auth\UpdateSettingsController@invoices');
        });
    });

    Route::group(['prefix' => 'subscription'], function () {
        Route::post('update', 'Auth\UpdateSettingsController@plan');
        Route::post('cancel', 'Auth\UpdateSettingsController@cancel');
        Route::post('resume', 'Auth\UpdateSettingsController@resume');
    });
});

Route::group(['prefix' => 'home'], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::group(['prefix' => 'users'], function () {
            Route::get('get', 'Api\Admin\UserController@index');
            Route::post('create', 'Api\Admin\UserController@store');
            Route::get('view', 'Api\Admin\UserController@view');
            Route::post('update', 'Api\Admin\UserController@update');
        });

        Route::group(['prefix' => 'permissions'], function () {
            Route::get('get', 'Api\Admin\PermissionController@index');
            Route::post('create', 'Api\Admin\PermissionController@store');
            Route::get('view', 'Api\Admin\PermissionController@view');
            Route::post('update', 'Api\Admin\PermissionController@update');
            Route::delete('delete/{id}', 'Api\Admin\PermissionController@destroy');
        });
    });
});
