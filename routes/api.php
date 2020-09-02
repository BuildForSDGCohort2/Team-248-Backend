<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/offers', "OfferController@store");

Route::post('forget-password', 'API\Auth\ForgetPasswordController@index')->name('forget.password');
Route::post('reset-password', 'API\Auth\ResetPasswordController@index')->name('password.reset');
