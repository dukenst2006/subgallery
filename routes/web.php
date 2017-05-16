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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/premium', 'HomeController@premium')->name('premium');
Route::get('/settings/subscription/card', 'SettingsController@card');
Route::get('/settings/subscription/upgrade', 'SettingsController@upgrade');

Route::post('stripe/webhook', 'Auth\WebhookController@handleWebhook');