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

// Route::get('/', function () {
//     return view('admin.dashboard.index');
// });

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
        
        // Page routes
        Route::resource('/page', 'PageController');
        Route::post('/page/status', 'PageController@status')->name('page.status');
    });
});
