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
Route::post('/forget-password', 'API\Auth\ForgetPasswordController')->name('forget.password');
Route::post('reset-password', 'API\Auth\ResetPasswordController')->name('password.reset');

Route::middleware('auth:api')->group(
    function () {
        Route::post('logout', 'AuthController@logout')->name('logout');
        Route::get('user', 'AuthController@user')->name('getUser');
        Route::put('profile/updatePassword', 'AuthController@updatePassword')->name('profile.updatePassword');
        Route::get('profile/offers', 'UserController@offers')->name('profile.myOffers');

        Route::post('/offers', "OfferController@store");
        Route::get('/offers', "OfferController@index");
        Route::put('/offers/{offer}', "OfferController@update");
        Route::delete('/offers/{offer}', "OfferController@destroy");
        Route::post('/offers/{offer}/apply', "OfferUserController@store");
        Route::patch('/applications/{application}/cancel', "OfferUserController@cancel");
        Route::post('/user-offers', "OfferController@userOffers");
        Route::patch('/users/deactivate', "UserController@deactivate");
        Route::post('/applied-offers', "OfferUserController@index");
    });

Route::get('offers/{offer}','OfferController@show')->name('offer.show');
Route::get('categories','OfferCategoriesController@index');
