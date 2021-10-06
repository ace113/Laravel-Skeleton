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

Route::group([
    'namespace' => 'Api\V1',
    'prefix' => 'v1/guest'
], function(){
    Route::post('/register', 'GuestController@register');
    Route::get('/register/verifyEmail/{token}', 'GuestController@verifyEmail');
    Route::post('/register/verifyContact', 'GuestController@verifyContact');
    Route::post('/sendVerificationEmail', 'GuestController@sendVerificationEmail');
    Route::post('/sendPhoneVerificationToken', 'GuestController@sendPhoneVerificationToken');
    Route::get('/pages/{slug}', 'GuestController@getPage');
    Route::post('/password/forgot', 'GuestController@forgotPassword');
    Route::post('/login', 'GuestController@login');
});