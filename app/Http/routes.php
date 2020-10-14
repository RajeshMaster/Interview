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
	Route::any('wrkEndValidation','EmployeeController@wrkEndValidation');
	Route::any('wrkEndProcess','EmployeeController@wrkEndProcess');
	Route::any('uploadResume','EmployeeController@uploadResume');
	Route::any('popupuploadProcess','EmployeeController@popupuploadProcess');
	Route::any('resumeHistory','EmployeeController@resumeHistory');
	Route::any('downloadprocess','EmployeeController@downloadprocess');
	Route::any('Onsitehistory','EmployeeController@Onsitehistory');
	Route::any('empHistory','EmployeeController@empHistory');
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
	Route::any('mailSignatureRegValidation','MailSignatureController@mailSignatureRegValidation');
	Route::any('mailSignatureAddEditProcess','MailSignatureController@mailSignatureAddEditProcess');
});

// MailStatus
Route::group(['prefix' => 'MailStatus','middleware' => 'auth'], function(){
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'MailStatusController@index');
	Route::any('mailStatusView', 'MailStatusController@mailStatusView');
});

// Send Mail
Route::group(['prefix' => 'MailSend','middleware' => 'auth'], function(){
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'MailSendController@index');
	Route::any('sendMailPost', 'MailSendController@sendMailPost');
	Route::any('branch_ajax','EmployeeController@branch_ajax');
	Route::any('incharge_ajax','EmployeeController@incharge_ajax');
	Route::any('customerSelpopup','EmployeeController@customerSelpopup');
	Route::any('sendMialvalidation','MailSendController@sendMialvalidation');
	Route::any('sendMailpostProcess','MailSendController@sendMailpostProcess');
	Route::any('inchargenamepopup','MailSendController@inchargenamepopup');
	Route::any('uploadResume','EmployeeController@uploadResume');
	Route::any('groupadd','MailSendController@groupadd');
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
});

// User
Route::group(['prefix'=>'user', 'middleware' => 'auth'], function() {
	Route::any('index', 'UserController@index');
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('view', 'UserController@view');
	Route::any('addedit', 'UserController@addedit');
	Route::any('UserRegValidation', 'UserController@UserRegValidation');
	Route::any('changepassword', 'UserController@changepassword');
	Route::any('PasswordValidation', 'UserController@PasswordValidation');
	Route::any('passwordchangeprocess', 'UserController@passwordchangeprocess');
});

// Our Detail
Route::group(['prefix'=>'OurDetail', 'middleware' => 'auth'], function() {
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'OurdetailController@index');
});

// LOGOUT PROCESS
Route::get('logout', 'Auth\AuthController@logout');

//Customer
Route::group(['prefix'=>'Customer','middleware' => 'auth'], function(){
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'CustomerController@index');
	Route::any('selectGroup', 'CustomerController@selectGroup');
	Route::any('groupselpopup', 'CustomerController@groupselpopup');
	Route::any('CustomerView', 'CustomerController@CustomerView');
	Route::any('CustomerAddedit','CustomerController@CustomerAddedit');
	Route::any('CustomerRegValidation','CustomerController@CustomerRegValidation');
	Route::any('getEmailExists','CustomerController@getEmailExists');
	Route::any('CustomerAddeditProcess','CustomerController@CustomerAddeditProcess');
	Route::any('Branchaddedit','CustomerController@Branchaddedit');
	Route::any('BranchRegValidation','CustomerController@BranchRegValidation');
	Route::any('Branchaddeditprocess','CustomerController@Branchaddeditprocess');
	Route::any('Inchargeaddedit','CustomerController@Inchargeaddedit');
	Route::any('InchargeRegValidation','CustomerController@InchargeRegValidation');
	Route::any('Inchargeaddeditprocess','CustomerController@Inchargeaddeditprocess');
	Route::any('EmpNamePopup','CustomerController@EmpNamePopup');
	Route::any('incharge_ajax', 'CustomerController@incharge_ajax');
	Route::any('EmpNamePopupRegValidation','CustomerController@EmpNamePopupRegValidation');
	Route::any('EmpNamePopupAddEditprocess','CustomerController@EmpNamePopupAddEditprocess');
	Route::any('Onsitehistory','CustomerController@Onsitehistory');
});

//Customer
Route::group(['prefix'=>'OldCustomer','middleware' => 'auth'], function(){
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'OldCustomerController@index');
	Route::any('view', 'OldCustomerController@view');
	Route::any('copyCustomer', 'OldCustomerController@copyCustomer');
	Route::any('OldInchargeSelect', 'OldCustomerController@OldInchargeSelect');
	Route::any('CustomerRegValidation', 'OldCustomerController@CustomerRegValidation');
	Route::any('addprocess', 'OldCustomerController@addprocess');
	Route::any('copyBranch', 'OldCustomerController@copyBranch');
	Route::any('BranchRegValidation', 'OldCustomerController@BranchRegValidation');
	Route::any('copyBranchProcess', 'OldCustomerController@copyBranchProcess');
	Route::any('addcopycancel', 'OldCustomerController@addcopycancel');
	Route::any('getEmailExistsManyFields', 'OldCustomerController@getEmailExistsManyFields');
});

//Agent
Route::group(['prefix'=>'Agent','middleware' => 'auth'], function(){
	Route::get('changelanguage', 'AjaxController@index');
	Route::any('index', 'AgentController@index');
	Route::any('AgentView','AgentController@AgentView');
	Route::any('AgentAddedit','AgentController@AgentAddedit');
	Route::any('AgentRegValidation','AgentController@AgentRegValidation');
	Route::any('getEmailExists','AgentController@getEmailExists');
	Route::any('AgentAddeditProcess','AgentController@AgentAddeditProcess');
	Route::any('addeditCustomer', 'AgentController@addeditCustomer');
	Route::any('cusaddeditprocess', 'AgentController@cusaddeditprocess');
});

?>