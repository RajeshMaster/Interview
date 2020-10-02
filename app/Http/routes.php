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

/*Route::get('User/changelanguage','AjaxController@index');

// Login Verify
Route::any('User/verifyLogin', 'UserController@verifyLoginCheck');

//User Index
Route::any('User/index', 'UserController@userindex');*/

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
	Route::any('view', 'EmployeeController@view');
	Route::any('empAddEdit', 'EmployeeController@empAddEdit');
	Route::any('AddEditregvalidation','EmployeeController@AddEditregvalidation');
	Route::any('employeeEditProcess','EmployeeController@employeeEditProcess');
	Route::any('workend','EmployeeController@workend');
	Route::any('branch_ajax','EmployeeController@branch_ajax');
	Route::any('incharge_ajax','EmployeeController@incharge_ajax');
	Route::any('customerSelpopup','EmployeeController@customerSelpopup');
});

// Non Employee - ADDED By Rajesh --2020/10/01
Route::group(['prefix'=>'NonEmployee', 'middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'NonEmployeeController@index');
});

// Mail - ADDED By Sathish --2020/09/30
Route::group(['prefix'=>'Mail', 'middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'MailController@index');
	Route::any('mailContentView','MailController@mailContentView');
	Route::any('mailContentAddEdit','MailController@mailContentAddEdit');
	Route::any('mailContentAddEditProcess','MailController@mailContentAddEditProcess');
	Route::any('mailregvalidation','MailController@mailregvalidation');
	Route::any('mailContentFlg','MailController@mailContentFlg');
});

// MailSignature
Route::group(['prefix'=>'MailSignature','middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'MailSignatureController@index');
	Route::any('mailSignatureFlg','MailSignatureController@mailSignatureFlg');
	Route::any('mailSignatureView','MailSignatureController@mailSignatureView');
	Route::any('mailSignatureAddEdit','MailSignatureController@mailSignatureAddEdit');
	Route::any('mailSignaturePopup','MailSignatureController@mailSignaturePopup');
	Route::any('getDataExist','MailSignatureController@getDataExist');
});

// Setting
Route::group(['prefix'=>'setting', 'middleware' => 'auth'], function() {
	Route::any('index', 'SettingController@index');
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('Already_Exists', 'SettingController@Already_Exists');
	Route::any('singletextpopup', 'SettingController@singletextpopup');
	Route::any('SingleFieldaddedit', 'SettingController@SingleFieldaddedit');
	Route::any('twotextpopup', 'SettingController@twotextpopup');
	Route::any('twoFieldaddedit', 'SettingController@twoFieldaddedit');
	Route::any('commitProcess', 'SettingController@commitProcess');
	Route::any('useNotuse', 'SettingController@useNotuse');
	Route::any('grouppopup', 'SettingController@grouppopup');
	Route::any('groupaddprocess', 'SettingController@groupaddprocess');
	Route::any('useNotuses', 'SettingController@useNotuses');
	Route::any('requirmentSetting', 'SettingController@requirmentSetting');
	Route::any('twoFieldaddeditgrp', 'SettingController@twoFieldaddeditgrp');

	/*Route::any('uploadpopup', 'SettingController@uploadpopup');
	Route::any('settingpopupupload', 'SettingController@settingpopupupload');
	Route::any('requirmentSetting', 'SettingController@requirmentSetting');
	Route::any('reqirmentaddprocess', 'SettingController@reqirmentaddprocess');
	Route::any('useNotusesrequirment', 'SettingController@useNotusesrequirment');
	Route::any('importpopup', 'SettingController@importpopup');
	Route::any('importprocess', 'SettingController@importprocess');*/
});

// User
Route::group(['prefix'=>'user', 'middleware' => 'auth'], function() {
	Route::any('index', 'UserController@index');
	Route::get('changelanguage', 'AjaxController@index');
});

// LOGOUT PROCESS
Route::get('logout', 'Auth\AuthController@logout');

?>