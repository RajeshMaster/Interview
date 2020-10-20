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
	public static function fnGetEmployeeDetails($request, $resignid, $title ,$candiate){
		$db = DB::connection('mysql_mbstaff');
		$query = $db->table('emp_mstemployees')
					->select('*')
					->whereNotIn('Emp_ID', $candiate)
					->where([['delFlg', '=', 0],
							  ['resign_id', '=', $resignid],
							  ['Emp_ID', 'LIKE', '%MB%']]);
		if($resignid == 0){
			$query = $query->where('Title', '=', $title);
		}

		if ($request->searchmethod == 1) {
			$query = $query->where(function($joincont) use ($request) {
									$joincont->where('Emp_ID', 'LIKE', '%' . $request->singlesearch . '%')
											 ->orwhere('nickname', 'LIKE', '%' . $request->singlesearch . '%');
							});
		} elseif ($request->searchmethod == 2) {
			$query = $query->where(function($joincont) use ($request) {
								$joincont->where([['Emp_ID', 'LIKE', '%' . $request->employeeno . '%'],
												 ['nickname', 'LIKE', '%' . $request->employeename . '%']]);
							});
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
		$db = DB::connection('mysql_mbstaff');
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
		$db = DB::connection('mysql_mbstaff');
		$sql = "SELECT AVG(YEAR(CURDATE()) - YEAR(dob) - (RIGHT(CURDATE(), 5) < RIGHT(dob, 5))) as avg_age FROM emp_mstemployees
		WHERE resign_id='$resignid' AND delFLg=0 AND Title = 2";
		$query = $db->SELECT($sql);
		return $query;
	}

	/**  
	*  Get Resume Details
	*  @author Rajesh 
	*  @param $request
	*  Created At 2020/10/01
	**/
	public static function fnGetResume($empId){
		$db = DB::connection('mysql');
		$query = $db->table('mst_resume')
					->select('*')
					->where([['empId', '=', $empId]])
					->ORDERBY('createdDate', 'DESC')
					->first();
		return $query;
	}

	/** 
	*  Get Resume History Details
	*  @author Rajesh 
	*  @param $request
	*  Created At 2020/10/01
	**/
	public static function viewResumedetails($request) {
		$db = DB::connection('mysql');
		$select = $db->table('mst_resume')
					->SELECT('*')
					->where([['empId', '=', $request->empid]])
					->ORDERBY('createdDate', 'DESC')
					->paginate($request->plimit);
		return $select;
	}

	/** 
	*  Get On site History Details
	*  @author Rajesh 
	*  @param $request
	*  Created At 2020/10/01
	**/
	public static function fnGetOnsiteHistoryDetails($empid,$request) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_clientemp_dtl AS cli')->SELECT(
								'cli.cust_id',
								'cli.status',
								'cli.start_date',
								'cli.end_date',
								'brn.branch_name',
								'cus.customer_name')
					->JOIN('mst_customerdetail AS cus','cli.cust_id','=','cus.customer_id')
					->JOIN('mst_branchdetails AS brn','cli.branch_id','=','brn.branch_id')
					->where('cli.emp_id', '=', $empid)
					->where('cus.delflg',0)
					->paginate($request->plimit);
						/*	->tosql();
					dd($query);*/
		return $query;
	}

	/**  
	*  Get Resume Details
	*  @author Rajesh 
	*  @param $request
	*  Created At 2020/10/01
	**/
	public static function fnGetClientDtl($empId){
		$db = DB::connection('mysql');
		$query = $db->table('inv_clientemp_dtl')
					->select('*')
					->where([['emp_id', '=', $empId]])
					->ORDERBY('Ins_DT', 'DESC')
					->first();
		return $query;
	}

	/**  
	*  Get Employee Details for Single year
	*  @author Rajesh 
	*  @param $request
	*  Created At 2020/10/01
	**/
	public static function fnGetstaffDetail($request){
		if (!empty($request->empid)) {
		$db = DB::connection('mysql_mbstaff');
		$query = $db->table('emp_mstemployees')
					->select('*')
					->leftJoin('mstaddress AS mst', 'mst.id', '=', 'emp_mstemployees.Address1')
					->where([['Emp_ID', '=', $request->empid]])
					->get();
		} else {
			$query = "";
		}
		return $query;
	}

	/**  
	*  Employee update process
	*  @author Rajesh 
	*  @param $request
	*  Created At 2020/10/1
	**/
	public static function updateprocess($request) {
		$name = Session::get('FirstName').' '.Session::get('LastName');
		$db = DB::connection('mysql_mbstaff');
		$update = $db->table('emp_mstemployees')
		->where('Emp_ID', $request->empid)
		->update(
			[
			'DOJ' => $request->OpenDate,
			'FirstName' => $request->Surname,
			'LastName' => $request->Name,
			'nickname' => $request->nickName,
			'Gender' => $request->Gender,
			'DOB' => $request->DateofBirth,
			'Mobile1' => $request->MobileNo,
			'Emailpersonal' => $request->Email,
			'Address1' => $request->StreetAddress,
			'Up_DT' => date('Y-m-d'),
			'Up_TM' => date('h:i:s'),
			'UpdatedBy' => $name]
		);
		return $update;
	}

	/**  
	*  Get Work Detail
	*  @author Rajesh 
	*  @param $request
	*  Created At 2020/10/1
	**/
	public static function clientWorkDetails($request) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_clientemp_dtl')
					->SELECT('inv_clientemp_dtl.*','mst_customerdetail.customer_name','mst_branchdetails.branch_name','mst_cus_inchargedetail.incharge_name')
					->leftJoin('mst_customerdetail', 'mst_customerdetail.customer_id', '=', 'inv_clientemp_dtl.cust_id')
					->leftJoin('mst_branchdetails', function($join) {
						$join->on('mst_branchdetails.customer_id', '=', 'inv_clientemp_dtl.cust_id');
						$join->on('mst_branchdetails.branch_id', '=', 'inv_clientemp_dtl.branch_id');
					})
					->leftJoin('mst_cus_inchargedetail','mst_cus_inchargedetail.id','=','inv_clientemp_dtl.incharge_id')
					->where('inv_clientemp_dtl.emp_id','=', $request->empid)
					->where('inv_clientemp_dtl.status','=', 1)
					->where('inv_clientemp_dtl.delFLg', 0)
					->first();
		return $query;
	}

	/**  
	*  Get Customer Detail
	*  @author Rajesh 
	*  @param 
	*  Created At 2020/10/2
	**/
	public static function selectcustomer() {
		$db = DB::connection('mysql');
		$result = $db->TABLE('mst_customerdetail')
					->select('customer_id','customer_name','romaji')
					->where('delflg', 0)
					->get();
		return $result;
	}

	/**  
	*  Get Branch Detail
	*  @author Rajesh 
	*  @param $customerid
	*  Created At 2020/10/2
	**/
	public static function fnGetbranchName($customerid) {
		$db = DB::connection('mysql');
		$result = $db->TABLE('mst_branchdetails')
					->select('*')
					->WHERE('delFlg', '=', 0)
					->WHERE('customer_id', '=', $customerid)
					->get();
		return $result;
	}

	/**  
	*  Get Incharge Detail
	*  @author Rajesh 
	*  @param $startDT,$endDT
	*  Created At 2020/10/2
	**/
	public static function fnGetinchargeName($customerId,$branchId) {
		$db = DB::connection('mysql');
		$result = $db->TABLE('mst_cus_inchargedetail')
					->select('*')
					->WHERE('delflg', '=', 0)
					->WHERE('customer_id', '=', $customerId)
					->WHERE('branch_name', '=', $branchId)
					->get();
		return $result;
	}

	/**
	*  End Date Insert Details
	*  @author Rajesh 
	*  @param $request
	*  Created At 2020/10/2
	**/
	public static function insertEnddate($request) {
		$db = DB::connection('mysql');
		$result= $insert=DB::table('inv_clientemp_dtl')->insert(
			[
				'cust_id' => $request->customerId,
				'branch_id' => $request->branchId,
				'emp_id' => $request->empid,
				'interview_id' => "",
				'incharge_id' => $request->inchargeDetails,
				'status' => 1,
				'start_date' => $request->startDate,
				'end_date' => $request->endDate,
				'CreatedBy' => Session::get('FirstName').' '.Session::get('LastName'),
				'UpdatedBy' => Session::get('FirstName').' '.Session::get('LastName'),
				'remarks' => $request->remarks,
				'delFLg' => 1,
				'reason' => "",
			]
		);
		return $result;
	}

	/**
	 * Resume Insert Process
	 * @author Rajesh 
	 * @param $request,$filename
	 *  Created At 2020/10/5
	 */
	public static function InsResumeHistory($request,$filename) {
		
		$db = DB::connection('mysql');
		$result = DB::TABLE('mst_resume')
					->insert([	
						'empId' => $request->empId,
						'resume' => $filename,
						'createdBy' => Auth::user()->username,
						'updatedBy' => Auth::user()->username 
					]);
		return $result;
	}

	/**
	*  Get Mail Details
	*  @author Rajesh 
	*  @param $mailId
	*  Created At 2020/10/2
	**/
	public static function getContentFirst($mailId) {
		$db = DB::connection('mysql');
		$query = $db->TABLE('mailcontent')
					->select('*')
					->WHERE('mailId','=',$mailId)
					->get();
		return $query;
	}



	/**  
	*  Employee Details
	*  @author Rajesh 
	*  @param $request,$resignid,title
	*  Created At 2020/09/30
	**/
	public static function fnGetEmpHistDetails($request) {
		$db = DB::connection('mysql');
		$query = $db->table('inv_clientemp_dtl')
					->select('inv_clientemp_dtl.*','mst_customerdetail.customer_name','mst_customerdetail.id','mst_customerdetail.customer_id','mst_branchdetails.branch_name')
					->leftJoin('mst_customerdetail', 'mst_customerdetail.customer_id', '=', 'inv_clientemp_dtl.cust_id')
					->leftJoin('mst_branchdetails', function($join) {
						$join->on('mst_branchdetails.customer_id', '=', 'inv_clientemp_dtl.cust_id');
						$join->on('mst_branchdetails.branch_id', '=', 'inv_clientemp_dtl.branch_id');
					})
					->where([['status', '=', 1]])
					->orderBy('inv_clientemp_dtl.cust_id', 'ASC')
					->paginate($request->plimit);
					/*->tosql();
					dd($query);*/
		return $query;
	}

	public static function editEnddate($request) {
		$name = Session::get('FirstName').' '.Session::get('LastName');
		$db = DB::connection('mysql');
		$result = DB::table('inv_clientemp_dtl')
				->where('id', $request->clientempId)
				->update([
					'start_date' => $request->startDate,
					'end_date' => $request->endDate,
					'UpdatedBy' => $name,
					'remarks' => $request->remarks,
					'delFLg' => 1]);
		return $result;
	}
}