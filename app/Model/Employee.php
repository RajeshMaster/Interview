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
	*  @param $userId
	*  Created At 2020/09/30
	**/
	public static function fnGetEmployeeDetails($request){
		$db = DB::connection('mysql_invoice');
		$query = $db->table('emp_mstemployees')
					->select('*')
					->get();
		print_r($query);exit;

					// dd($query);
		return $query;
	}
}