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

Route::get('/post-random', 'FrontPageController@random');

Route::get('search-university', 'UniversityController@search');

Route::post('/v1/images', 'EditorController@image');

Route::post('/phone-verification', 'PhoneVerificationController@sendVerificationCode');

Route::post('/code-verification', 'PhoneVerificationController@verifyCode');

Route::any('/facebook-delete', 'Auth\FacebookController@delete');