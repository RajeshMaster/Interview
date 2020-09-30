<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Input;
use Auth;
use Session;
use Carbon\Carbon ;

class Employee extends Model
{

	/**  
	*  Employee Details
	*  @author Rajesh 
	*  @param $request,$resignid,title
	*  Created At 2020/09/30
	**/
	public static function fnGetEmployeeDetails($request, $resignid, $title){
		$db = DB::connection('mysql_invoice');
		$query = $db->table('emp_mstemployees')
					->select('*')
					->where([['delFlg', '=', 0],
							  ['resign_id', '=', $resignid],
							  ['Emp_ID', 'NOT LIKE', '%NST%']]);
		if($resignid == 0){
			$query = $query->where('Title', '=', $title);
		}
		$query = $query	->orderBy($request->staffsort, $request->sortOrder)
						->paginate($request->plimit);
					// dd($query);
		return $query;
	}

	/**  
	*  Employee Details
	*  @author Rajesh 
	*  @param $address
	*  Created At 2020/09/30
	**/
	public static function fngetjapanaddress($address) {
		$db = DB::connection('mysql_invoice');
		$query = $db->table('mstaddress')
					->select(DB::raw("CONCAT('〒',pincode,jpstate,jpaddress,roomno,'号') AS address"))
					->where('id', '=', $address)
					->get();
		return $query;
	}

	/**  
	*  Customer Details
	*  @author Rajesh 
	*  @param $address
	*  Created At 2020/09/30
	**/
	public static function fnGetcusname($request, $empid) {
		$db = DB::connection('mysql_invoice');
		$query = $db->table('mst_customerdetail')
					->SELECT('mst_customerdetail.customer_name')
					->leftJoin('clientempteam', function($join){
					$join->ON('clientempteam.cust_id', '=', 'mst_customerdetail.customer_id')
					->WHERE('clientempteam.status', '=', 1);
					})
					->LEFTJOIN('emp_mstemployees', 'emp_mstemployees.Emp_ID' ,'=','clientempteam.emp_id')
					->where('emp_mstemployees.Emp_ID', '=', $empid)
					->get();
		return $query;
	}

	/**  
	*  Year counnt Between dates Details(Common Function)
	*  @author Rajesh 
	*  @param $startDT,$endDT
	*  Created At 2020/09/30
	**/
	public static function GetAvgage($resignid) {
		$db = DB::connection('mysql_invoice');
		$sql = "SELECT AVG(YEAR(CURDATE()) - YEAR(dob) - (RIGHT(CURDATE(), 5) < RIGHT(dob, 5))) as avg_age FROM emp_mstemployees
		WHERE resign_id='$resignid' AND delFLg=0 AND Title = 2";
		$query = $db->SELECT($sql);
		return $query;
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
}