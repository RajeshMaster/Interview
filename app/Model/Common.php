<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use Auth;
use Cookie;
use Carbon\Carbon ;
use File;
class Common extends Model {

	/**
	*
	* Get Details for employee count
	* @author Sastha
	* @return Object to particular selected value
	* Created At 2020/08/19
	*
	*/
	public static function fnGetDataFromOtherTable($userId,$userType) {
			$userName = DB::TABLE('ams_users')
						->SELECT('lastName AS userName')
						->WHERE('userId',$userId)
						->WHERE('userType',$userType)
						->GET();
			return $userName;
	}

	/**  
	 *  To Employer Register
	 *  @author Sastha 
	 *  @param $request
	 *  Created At 2020/08/19
	 **/
	public static function get_mail_content($mailId) {
		$get_query = DB::TABLE('ams_mailcontent')
					->SELECT('subject',
							 'header',
							 'content')
					->WHERE('mailId',$mailId)
					->get();
		return $get_query;
	}

	/**  
	 *  For Check current and auth password check
	 *  @author Sastha
	 *  @param $request
	 *  Created At 2020/08/19
	 **/
	public static function checkpassword($password,$authpassword) {
		$password = md5($password);
		if ($password == $authpassword) {
			return true;
		} else {
			return false;
		}
	}

	/**
	*
	* Get details from Cookies
	* @author Sastha
	* @return Object to particular selected value
	* Created At 2020/08/19
	*
	*/
	public static function setCookieValue() {
		if(Session::get('userId') == "") {
			// cookie array to foreach & set into the session. modified by sabari
			$cookieArrayList = Cookie::get('cookieArrayList');
			if (is_array($cookieArrayList)) {
				foreach ($cookieArrayList as $key => $value) {
		  			//set cookie key and value here 
					Session::put($key,$value);
				}
			}
		}
	}

	/**  
	*  Update User  Log
	*  @author Sastha.
	*  Created At 2020/08/24
	**/
	public static function fnUpdateLoginLog($request) {
		DB::beginTransaction();
		try {
			$updUserlog = DB::TABLE('ams_login')
					->WHERE('userId', '=', Auth::user()->userId)
					->update(['loginStatus' => 1]);
			DB::commit();       
			return $updUserlog;
		} catch (\Exception $e) {
			DB::rollback();
		} 
	}

	/**  
	*  Change User Log Status Updated by Sastha.
	*  @author Sastha  
	*  Created At 2020/08/24
	**/
	public static function fnUpdateLogoutLog() {
		 // dd(Session::all());
		DB::beginTransaction();
		try {
			$updUserlog = DB::TABLE('ams_login')
					->WHERE('userId', '=', Auth::user()->userId)
					->update(['loginStatus' => 0 ]);
			DB::commit();       
			return $updUserlog;
		} catch (\Exception $e) {
			DB::rollback();
		} 
	}

	/**
	* To Login Details
	* @author Sastha
	* @param $userData
	* Created At 2020/08/24
	**/
	public static function fnGetLogin($userData){
		if (isset($userData['userId'])) {
			$userId = $userData['userId'];
		} else if (isset($userData['email'])) {
			$userId = $userData['email'];
		} else {
			$userId = "";
		}
		
		$get_query = DB::TABLE('ams_login')
					->SELECT('verifyFlg','email','userType')
					->WHERE('userId',$userId)
					->ORWHERE('email',$userId)
					->get();
		return $get_query;
	}

	/**
	* To Get Bank Name
	* @author Sastha
	* Created At 2020/08/27
	**/
	public static function fnGetBankName(){
		$query = DB::TABLE('ams_bankname_master')
					->SELECT('*')
					->WHERE('delFlg',0)
					->get();
		return $query;
	}

	/**  
	* To Get Bank Nick Name
	*  @author Sastha 
	*  @param $bankId
	*  Created At 2020/08/27
	**/
	public static function fnGetBankNickName($bankId) {
		$db = DB::connection('mysql');
		$result = $db->TABLE('ams_bankname_master')
					->select('*')
					->WHERE('id', '=', $bankId)
					->get();
		return $result;
	}

	/**
	* To Get Family Member Name
	* @author Sastha
	* Created At 2020/08/27
	**/
	public static function fnGetFamilyMembers(){
		$query = DB::TABLE('ams_family_master')
					->SELECT('*')
					->WHERE('delFlg',0)
					->get();
		return $query;
	}

	/**
	* To Get House Address
	* @author Sastha
	* Created At 2020/08/27
	**/
	public static function fnGetBuildingName(){
		$query = DB::TABLE('ams_master_buildingname')
					->SELECT('*')
					->WHERE('delFlg',0)
					->get();
		return $query;
	}

	/**
	* To Get Assets Types
	* @author Sastha
	* Created At 2020/09/15
	**/
	public static function fnGetAssetsTypes(){
		$query = DB::TABLE('ams_master_assetstypes')
					->SELECT('*')
					->WHERE('delFlg',0)
					->get();
		return $query;
	}

	/**
	* To Get User Information
	* @author Sastha
	* Created At 2020/09/15
	**/
	public static function fnGetEmployeeInfo($id){
		$db = DB::connection('mysql_invoice');
		$result = $db->table('emp_mstemployees')
						->SELECT('*')
						->leftJoin('mstaddress AS mst', 'mst.id', '=', 'emp_mstemployees.Address1')
						->WHERE('Emp_ID', '=', $id)
						->get();
		return $result;
	}

	/**  
	*  Year counnt Between dates Details(Common Function)
	*  @author Rajesh 
	*  @param $startDT,$endDT
	*  Created At 2020/09/30
	**/
	public static function getYrMonCountBtwnDates($startDT, $endDT){
		$retVal['year']=0;
		$retVal['month']=0;
		if ($endDT == ""||$endDT=="") {
			$endDT = date("Y-m-d");
		}
		if (($startDT!=""&&$startDT!="0000-00-00")&&($endDT!=""&&$endDT!="0000-00-00")){
			$diff = abs(strtotime($endDT) - strtotime($startDT));
			$dys = (int)((strtotime($endDT)-strtotime($startDT))/86400);
			$retVal['year'] = floor($diff / (365*60*60*24));
			$retVal['month'] = floor(($diff - $retVal['year'] * 365*60*60*24) / (30*60*60*24));
		} 
		return $retVal;
	}
	public static function fnAddZeroSubstring($val) {
		return substr($val, -2);
	}


	/**
	 * 画面表示
	 *
	 *
	 * @return Get mail content.
	 */
	public static function getContentFirst($mailId) {
		$db = DB::connection('mysql');
		$query = $db->TABLE('mailContent')
					->select('*')
					->WHERE('mailId','=',$mailId)
					->get();
		return $query;
	}

	/**
	 * 画面表示
	 *
	 *
	 * @return To Get Current System Date and Time  
	 */
	public static function getSystemDateTime() {
		$query = DB::select("SELECT CURRENT_DATE, CURRENT_TIME, CURRENT_TIMESTAMP, NOW() + 1 as NOW");
		return $query;
	}
}
