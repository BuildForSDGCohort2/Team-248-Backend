<?php

use Illuminate\Support\Facades\Route;

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

Route::post('register', 'AuthController@register')->name('register');
Route::post('login', 'AuthController@login')->name('login');
Route::post('logout', 'AuthController@logout')->name('logout')->middleware('auth:sanctum');
Route::get('user', 'AuthController@user')->name('getUser')->middleware('auth:sanctum');

Route::post('/offers', "OfferController@store");

Route::post('forget-password', 'API\Auth\ForgetPasswordController')->name('forget.password');
Route::post('reset-password', 'API\Auth\ResetPasswordController')->name('password.reset');
