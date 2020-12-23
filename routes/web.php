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

Route::namespace('API')->middleware('client')->name('auth')->group(function(){
    Route::prefix('oauth')->group(function(){
        Route::post('/login', 'AuthController@login');
        Route::post('/register', 'AuthController@register');
    });
});