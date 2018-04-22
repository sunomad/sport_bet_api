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

Route::group(['prefix' => 'v1'], function () {
    
    Route::group(['prefix' => 'users'], function () {
        Route::get('{user}', 'UserController@getUser');
        Route::post('', 'UserController@createUser');
        Route::patch('{user}', 'UserController@updateUser');
        Route::delete('{user}', 'UserController@deleteUser');
    });
    
    Route::group(['prefix' => 'books'], function () {
        Route::get('', 'BookController@getBook');
        Route::post('', 'BookController@placeBets');
    });
});
