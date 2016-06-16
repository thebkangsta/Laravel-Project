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

Route::get('home', 'HomeController@index');
Route::post('home', 'Auth\AuthController@login');

Route::get('register','RegisterController@index');
Route::post('register','RegisterController@store');

Route::get('dashboard/analytics', 'DashboardController@index');
Route::get('logout', 'Auth\AuthController@logout');

Route::get('reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('reset', 'Auth\PasswordController@reset');
Route::post('email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('dashboard/email', 'Auth\PasswordController@sendResetLinkEmail');

//Route::post('dashboard/data', 'DashboardController@getData');
Route::get('dashboard/data', 'DashboardController@getData');

Route::get('dashboard/communities', 'CommunitiesController@index');
Route::post('dashboard/communities', 'CommunitiesController@submitComment');