<?php

use Illuminate\Http\Request;

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

Route::namespace('API')->name('api.')->group(function(){
    Route::prefix('posts')->group(function(){
        Route::get('/', 'PostController@index')->name('index_post');
        Route::post('/', 'PostController@store')->name('store_post');
        Route::get('/{id}', 'PostController@show')->name('single_post');
        Route::put('/{id}', 'PostController@update')->name('update_post');
        Route::delete('/{id}', 'PostController@delete')->name('delete_post');
    });

    Route::prefix('tags')->group(function(){
        Route::get('/', 'TagController@index')->name('index_tag');
        Route::post('/', 'TagController@store')->name('store_tag');
        Route::get('/{id}', 'TagController@show')->name('single_tag');
        Route::put('/{id}', 'TagController@update')->name('update_tag');
        Route::delete('/{id}', 'TagController@delete')->name('delete_tag');
    });

    Route::prefix('users')->group(function(){
        Route::get('/', 'UserController@index')->name('index_user');
        Route::get('/{id}', 'UserController@show')->name('single_user');
    });
});
