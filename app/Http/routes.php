<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['prefix'=>'/'], function() {
	Route::get('/', 'LoginController@index');
});

// LOGIN PAGE
Route::get('login', 'LoginController@index');

// LOGIN PROCESS
Route::post('login', 'LoginController@authenticate');
Route::get('Login/forgetpassword', 'Auth\PasswordController@showLinkRequestForm');
Route::post('Login/forgetprocess', 'Auth\PasswordController@sendResetLinkEmail');

Route::get('User/changelanguage','AjaxController@index');

// Login Verify
Route::any('User/verifyLogin', 'UserController@verifyLoginCheck');

//User Index
Route::any('User/index', 'UserController@userindex');

// Home
Route::group(['prefix'=>'menu', 'middleware' => 'auth'], function() {
	Route::any('index', 'MenuController@index');
	Route::get('changelanguage', 'AjaxController@index');
});

// User Register
Route::get('User/register', 'UserController@register');
Route::any('User/addeditprocess', 'UserController@addeditprocess');
Route::any('User/getEmailExists', 'UserController@mailexistcheck');

// Forgot Password
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/reset', 'Auth\PasswordController@reset');

//User Profile
Route::any('User/profile', 'UserController@userprofile');
Route::any('User/edit', 'UserController@useredit');

// Password Change 
Route::group(['prefix'=>'Auth', 'middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('changepassword', 'LoginController@showChangePasswordForm');
	Route::any('changePasswordprocess','LoginController@changePassword');
});

// Employee - ADDED By Rajesh --2020/09/30
Route::group(['prefix'=>'Employee', 'middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'EmployeeController@index');
});

// Mail - ADDED By Sathish --2020/09/30
Route::group(['prefix'=>'Mail', 'middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'MailController@index');
	Route::any('mailContentView','MailController@mailContentView');
});

// LOGOUT PROCESS
Route::get('logout', 'Auth\AuthController@logout');

?>