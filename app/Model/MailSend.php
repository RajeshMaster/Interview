<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Session;
use Config;
class MailSend extends Model {
	/**
	*
	* To Mail Send Index View
	* @author Sathish
	* Created At 05/10/2020
	*
	*/
	public static function fnGetEmployeeDetailsstart($request, $resignid){
		$db = DB::connection('mysql_invoice');
		$query = $db->table('emp_mstemployees')
					->select('Emp_ID')
					->where([['delFlg', '=', 0],
							  ['resign_id', '=', $resignid],
							  ['Emp_ID', 'LIKE', '%MB%']])
					->get();
		return $query;
	}

	/**  
	*  Employee Details
	*  @author Rajesh 
	*  @param $request,$resignid,title
	*  Created At 2020/09/30
	**/
	public static function fnGetEmployeeDetails($request, $resignid, $empidarr){
		$db = DB::connection('mysql_invoice');
		$query = $db->table('emp_mstemployees')
					->select('*')
					->where([['delFlg', '=', 0],
							  ['resign_id', '=', $resignid],
							  ['Emp_ID', 'LIKE', '%MB%']])
					->whereIn('Emp_ID', $empidarr);

		$query = $query	->orderBy($request->staffsort, $request->sortOrder)
						->paginate($request->plimit);
							// ->tosql();
					// dd($query);
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
	*  Get Customer Details
	*  @author Rajesh 
	*  @param
	*  Created At 2020/10/01
	**/
	public static function selCustomer(){
			$db = DB::connection('mysql');
		$result = $db->TABLE('mst_customerdetail')
					->select('customer_id','customer_name')
					->where('delflg', 0)
					->get();
		return $result;
	}

	/**  
	*  Get Customer Details
	*  @author Rajesh 
	*  @param
	*  Created At 2020/10/01
	**/
	public static function fnGetmail($customerid) {
		$getmail = "";
		$db = DB::connection('mysql');
		$result = $db->TABLE('mst_cus_inchargedetail')
					->select('incharge_email_id')
					->WHERE('delflg', '=', 0)
					->WHERE('customer_id', '=', $customerid)
					->get();
					foreach ($result as $key => $value) {
						$getmail .= $value->incharge_email_id.',';
					} 	
		return $getmail;
	}

	/**  
	*  Get Agent Details
	*  @author Rajesh 
	*  @param
	*  Created At 2020/10/01
	**/
	public static function getAgentMail($customerid) {
		$db = DB::connection('mysql');
		$result = $db->TABLE('mst_agentdetail')
					->select('mst_agentdetail.*')
					->leftJoin('mst_customerdetail','mst_agentdetail.agent_id','=','mst_customerdetail.agentId')
					->WHERE('mst_customerdetail.customer_id', '=', $customerid)
					->get();
		return $result;
	}

	/**  
	*  Insert Mail Status details
	*  @author Rajesh 
	*  @param $mailId,$subject,$empid,$CustId,$BranchId,$pdfFile
	*  Created At 2020/10/01
	**/
	public static function mailPostSendList($mailId,$subject,$empid,$CustId,$BranchId,$pdfFile) {
		$db = DB::connection('mysql');
		$result = DB::TABLE('mailStatus')
					->insert([	
						'empId' => $empid,
						'companyId' => $CustId,
						'branchId' => $BranchId,
						'toMail' => $mailId,
						'subject' => $subject,
						'sendFlg' => 1,
						'pdfNames' => $pdfFile,
						'attachCount' => 1,
						'createdBy' => Auth::user()->username,
						'updatedBy' => Auth::user()->username 
					]);
		return $result;
	}

	/**  
	*  get Incharge Details
	*  @author Rajesh 
	*  @param $mailId,$subject,$empid,$CustId,$BranchId,$pdfFile
	*  Created At 2020/10/01
	**/
	public static function fngetInchargeDetails($request,$customerId,$branchId,$inchargeId) {
		if ($request->hidincharge != "") {
			$db = DB::connection('mysql');
			foreach ($inchargeId as $key => $value) {
				$result = $db->TABLE('mst_cus_inchargedetail')
					->select('*')
					->WHERE('delflg', '=', 0)
					->WHERE('customer_id', '=', $customerId)
					->WHERE('branch_name', '=', $branchId)
					->WHERE('id','=', $value)
					->get();
				$query[$key] = $result[0];
			}
			return $query;
		} else {
			$db = DB::connection('mysql');
			$result = $db->TABLE('mst_cus_inchargedetail')
				->select('*')
				->WHERE('delflg', '=', 0)
				->WHERE('customer_id', '=', $customerId)
				->WHERE('branch_name', '=', $branchId);
				if ($inchargeId != "") {
					$result = $result->WHERE('id','=', $inchargeId);
				}
				$result = $result->get();
				return $result;
		}
	}

	/**  
	*  get Customer Details
	*  @author Rajesh 
	*  @param $mailId,$subject,$empid,$CustId,$BranchId,$pdfFile
	*  Created At 2020/10/01
	**/
	public static function getCustomerName($Cid){
		$db = DB::connection('mysql');
		$result= $db->TABLE('mst_customerdetail')
					->select('customer_id','customer_name')
					->WHERE('customer_id', '=', $Cid)
					->get();
		return $result;
	}
	/**  
	*  Update Incharge Details
	*  @author Rajesh 
	*  @param $mailId,$subject,$empid,$CustId,$BranchId,$pdfFile
	*  Created At 2020/10/01
	**/
	public static function changeMailFlg($email){
		$db = DB::connection('mysql');
		$update = DB::TABLE('mst_cus_inchargedetail')
					->WHERE('incharge_email_id', $email)
					->update(['sendpasswrodFlg' => 1]);
    	return $update;
	}

	public static function groupsends($group) {
		$db = DB::connection('mysql');
		$result = $db->TABLE('mst_customerdetail')
		           ->select('mst_cus_inchargedetail.*')
		           ->leftJoin('mst_cus_group','mst_cus_group.groupId','=','mst_customerdetail.groupId')
		           ->leftJoin('mst_cus_inchargedetail','mst_customerdetail.customer_id','=','mst_cus_inchargedetail.customer_id')
				   ->WHERE('mst_customerdetail.groupId', '=',$group)
					->get();
		return $result;
	}


	public static function getpopupincharge($inchargeId){
		$db = DB::connection('mysql');
		$result = $db->TABLE('mst_cus_inchargedetail')
				->select('id','customer_id','incharge_name','branch_name','incharge_contact_no','incharge_email_id')
				->WHERE('branch_name', $inchargeId)
				->WHERE('delflg',0)
				->get();
    	return $result;
	}
}
