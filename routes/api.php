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
Route::put('profile/updatePassword', 'AuthController@updatePassword')->name('profile.updatePassword')->middleware('auth:sanctum');

Route::post('/offers', "OfferController@store")->middleware('auth:sanctum');
Route::get('/offers', "OfferController@index")->middleware('auth:sanctum');
Route::put('/offers/{offer}', "OfferController@update")->middleware('auth:sanctum');
Route::delete('/offers/{offer}', "OfferController@destroy")->middleware('auth:sanctum');
Route::post('/offers/{offer}/apply', "OfferUserController@store")->middleware('auth:sanctum');
Route::patch('/applications/{application}/cancel', "OfferUserController@cancel")->middleware('auth:sanctum');
Route::post('reset-password', 'API\Auth\ResetPasswordController')->name('password.reset');
Route::post('/user-offers', "OfferController@userOffers")->middleware('auth:sanctum');
Route::patch('/users/deactivate', "UserController@deactivate")->middleware('auth:sanctum');
Route::post('/applied-offers', "OfferUserController@index")->middleware('auth:sanctum');
Route::post('forget-password', 'API\Auth\ForgetPasswordController')->name('forget.password');
