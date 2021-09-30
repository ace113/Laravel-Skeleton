<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
    'namespace' => "Admin",
    'prefix' => "admin",
    'as' => "admin."
], function(){
    // guest routes
    Route::get('/login', 'GuestController@getLogin')->name('login.form');
    Route::post('/login', 'GuestController@login')->name('login');
  
    Route::group([
        "namespace" => "Auth",
    ], function(){
        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.update');
        Route::get('/reset/confirm', 'ResetConfirmController@confirmReset')->name('confirm.reset');
    });

    // Logout
    Route::get('/logout', 'GuestController@logout')->name('logout');
   

    // auth routes
    Route::group([
        'middleware' => 'auth:web'
    ], function(){
        // Dashboard
        Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');

        // auth/profile
        Route::get('/change-password', 'AuthController@getChangePassword')->name('edit.password');
        Route::post('/change-password', 'AuthController@changePassword')->name('update.password');
        Route::get('/profile', 'AuthController@getProfile')->name('edit.profile');
        Route::post('/profile', 'AuthController@updateProfile')->name('update.profile');

        // Roles
        Route::post('/role/status', 'RoleController@status')->name('role.status');
        Route::resource('/role', 'RoleController');       

        // Permissions
        Route::post('/permission/status', 'PermissionController@status')->name('permission.status');
        Route::resource('/permission', 'PermissionController');

        // Users
        Route::post('/user/status', 'UserController@status')->name('user.status');
        Route::resource('/user', 'UserController');
        
        // Page routes
        Route::post('/page/status', 'PageController@status')->name('page.status');
        Route::resource('/page', 'PageController');       
    });
});
