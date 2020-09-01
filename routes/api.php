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

Route::post('register', 'Auth\RegisterController')->name('register');
Route::post('login', 'Auth\LoginController')->name('login');
Route::post('logout', 'Auth\LogoutController')->name('logout')->middleware('auth:sanctum');
Route::get('user', 'Auth\UserController')->name('getUser')->middleware('auth:sanctum');

Route::post('/offers', "OfferController@store");
