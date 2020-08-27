<?php

use Illuminate\Support\Facades\Route;

Route::post('register', 'Auth\RegisterController')->name('register');
Route::post('login', 'Auth\LoginController')->name('login');
Route::post('logout', 'Auth\LogoutController')->name('logout')->middleware('auth:sanctum');
Route::get('user', 'Auth\UserController')->name('getUser')->middleware('auth:sanctum');
