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
Route::get('/settings/account', 'SettingsController@account');
Route::get('/settings/billing/invoices', 'SettingsController@invoices');
Route::get('/settings/billing/card', 'SettingsController@card');
Route::get('/settings/subscription/plan', 'SettingsController@plan');
Route::get('/settings/subscription/cancel', 'SettingsController@cancel');
Route::get('/settings/subscription/resume', 'SettingsController@resume');

Route::get('/settings/billing/invoice/{invoice}', 'SettingsController@invoiceDownload');

Route::post('stripe/webhook', 'Auth\WebhookController@handleWebhook');