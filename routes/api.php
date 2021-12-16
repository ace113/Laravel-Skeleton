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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'namespace' => 'Api\V1',    
    'prefix' => 'v1'
], function(){
    Route::group([
        'prefix' => 'guest'
    ], function(){
        Route::post('/register', 'GuestController@register');
        Route::get('/register/verifyEmail/', 'GuestController@verifyEmail')->name('api.verify.email');
        Route::post('/register/verifyContact', 'GuestController@verifyContact');
        Route::post('/sendVerificationEmail', 'GuestController@sendVerificationEmail');
        Route::post('/sendPhoneVerificationToken', 'GuestController@sendPhoneVerificationToken');
        Route::get('/pages/{slug}', 'GuestController@getPage');
        Route::post('/password/forgot', 'ForgotPasswordController@resetLinkEmail');
        Route::post('/password/reset', 'ResetPasswordController@reset');
        Route::post('/login', 'GuestController@login');

        Route::get('/test-sms', 'GuestController@testSms');

        // Blogs
        Route::get('/posts', 'PostController@getPostsList');
        Route::get('/posts/{slug}', 'PostController@getPost');
        Route::get('/posts/{slug}/comment', 'PostController@getPostComments');
        Route::post('/posts/{slug}/comment/create', 'PostController@addComment');
        Route::patch('/posts/{slug}/comment/{comment}', 'PostController@editComment');
        Route::delete('/posts/{slug}/comment/{comment}', 'PostController@deleteComment');

        // sociolite
        Route::get('/login/facebook', 'GuestController@facebookLogin');
        Route::get('/login/facebook/callback', 'GuestController@facebookLoginCallback');
        
        Route::get('/login/google', 'GuestController@googleLogin');
        Route::get('/login/google/callback', 'GuestController@googleLoginCallback');
    });

    Route::group([
        'prefix' => 'auth',
        'middleware' => ['auth:api', 'verified'],
    ], function(){
        Route::get('/profile', 'AuthUserController@getUserProfile');
        Route::post('/profile', 'AuthUserController@updateProfile');
        Route::post('/profile/upload_image', 'AuthUserController@uploadImage');
        Route::post('/changePassword', 'AuthUserController@changePassword');
        Route::get('/logout/{device_id}', 'AuthUserController@logout');
        Route::post('/addUpdateDeviceInfo', 'AuthUserController@addUpdateDeviceInfo');
    });
});