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

Route::get('/', 'AdministratorController@login')->name('login');

Route::group(['prefix' => 'administrator'], function () {
    // Route::get('/login', 'AdministratorAuth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'AdministratorController@loginSubmit');
    // Route::post('/logout', 'AdministratorAuth\LoginController@logout')->name('logout');
  
    // Route::get('/register', 'AdministratorAuth\RegisterController@showRegistrationForm')->name('register');
    // Route::post('/register', 'AdministratorAuth\RegisterController@register');
  
    // Route::post('/password/email', 'AdministratorAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    // Route::post('/password/reset', 'AdministratorAuth\ResetPasswordController@reset')->name('password.email');
    // Route::get('/password/reset', 'AdministratorAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    // Route::get('/password/reset/{token}', 'AdministratorAuth\ResetPasswordController@showResetForm');
  });

// Route::get('/activation', function () {
//     return view('mail.auth.activation');
// });
