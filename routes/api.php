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

// Auth Routes
Route::post('/register', 'AuthController@store');
Route::post('/login', 'AuthController@login');

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@user');
    
    Route::get('/users', 'UserController@index');

    Route::post('/conversations', 'ConversationController@store');
    Route::get('/conversations/{id}', 'ConversationController@getConversationByUserId');
    
    Route::post('/messages', 'MessageController@store');
});
