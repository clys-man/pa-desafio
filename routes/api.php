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
    Route::resource('/posts', 'PostController', [
        'except' => ['create' , 'edit']
    ]);

    Route::resource('/tags', 'TagController', [
        'except' => ['create' , 'edit']
    ]);

    Route::prefix('users')->group(function(){
        Route::get('/', 'UserController@index')->name('index_user');
        Route::get('/{id}', 'UserController@show')->name('single_user');
    });

    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
});
