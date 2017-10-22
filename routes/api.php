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

Route::post('/register', 'UserController@register');
// Route::get('/login/facebook', 'Auth\LoginController@redirectToProvider');
// Route::get('/login/facebook/callback', 'Auth\LoginController@handleProviderCallback');
Route::group(['prefix' => 'articles'], function() {
  Route::get('/', 'ArticleController@index')->middleware('auth:api');
  Route::get('/{article}', 'ArticleController@show')->middleware('auth:api');
  Route::post('/', 'ArticleController@store')->middleware('auth:api');
  Route::patch('/{article}', 'ArticleController@update')->middleware('auth:api');
  Route::delete('/{article}', 'ArticleController@destroy')->middleware('auth:api');
});
