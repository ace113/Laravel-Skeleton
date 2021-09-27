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
    return view('admin.dashboard.index');
});

Route::group([
    'namespace' => "Admin",
    'prefix' => "admin",
    'as' => "admin."
], function(){
    // guest routes
    Route::get('/login', 'GuestController@getLogin')->name('login.form');
    Route::post('/login', 'GuestController@login')->name('login');
    Route::post('/password/email', 'GuestController@sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset/{token}', 'GuestController@getResetPassword')->name('resetPassword.form');
    Route::get('/password/reset', 'GuestController@resetPassword')->name('reset.password');
    // Logout
    Route::get('/logout', 'GuestController@logout')->name('logout');
   

    // auth routes
    Route::group([
        // 'middleware' => 'auth:web'
    ], function(){
        // Dashboard
        Route::get('/dashboard', 'AuthController@dashboard')->name('dashboard');
        
        // Page routes
        Route::resource('/page', 'PageController');
        Route::post('/page/status', 'PageController@status')->name('page.status');
    });
});
