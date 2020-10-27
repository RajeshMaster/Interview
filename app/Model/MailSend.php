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
		$db = DB::connection('mysql_mbstaff');
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
		$db = DB::connection('mysql_mbstaff');
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
		$result = DB::TABLE('mailstatus')
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
				   ->WHERE('mst_customerdetail.groupId',  'LIKE', '%' . $group . '%')
					->get();
		return $result;
	}

	/**  
	*  get Customer Details
	*  @author Rajesh 
	*  @param $mailId,$subject,$empid,$CustId,$BranchId,$pdfFile
	*  Created At 2020/10/01
	**/
	public static function getpopupincharge($inchargeId){
		$db = DB::connection('mysql');
		$result = $db->TABLE('mst_cus_inchargedetail')
				->select('id','customer_id','incharge_name','branch_name','incharge_contact_no','incharge_email_id')
				->WHERE('branch_name', $inchargeId)
				->WHERE('delflg',0)
				->get();
    	return $result;
	}

	/**  
	*  get Customer Details
	*  @author Rajesh 
	*  @param $mailId,$subject,$empid,$CustId,$BranchId,$pdfFile
	*  Created At 2020/10/01
	**/
	public static function groupAgentsends($group) {
		$db = DB::connection('mysql');
		$result = $db->TABLE('mst_customerdetail')
		           ->select('mst_agentdetail.*','mst_customerdetail.*')
		           ->leftJoin('mst_agentdetail','mst_agentdetail.agent_id','=','mst_customerdetail.agentId')
				   ->WHERE('mst_customerdetail.groupId', 'LIKE', '%' . $group . '%')
					->get();
		return $result;
	}

	public static function getallGroup() {
		$db = DB::connection('mysql');
		$result = $db->TABLE('mst_cus_group as group')
					->select('group.*','mst_customerdetail.customer_name')
					->leftJoin('mst_customerdetail','mst_customerdetail.customer_id','=','group.customerId')
					->WHERE('group.delFlg',0)
					->groupBy('groupId')
					->orderBy('group.groupId', 'ASC')
					->get();
		return $result;
	}

	public static function getProgramLanguage($request){
		$db = DB::connection('mysql');
		$result = $db->TABLE('emp_sysprogramlangtypes')
					->select('id','ProgramLangTypeCD','ProgramLangTypeNM')
					->WHERE('DelFlg',0)
					->orderBy('Order_id', 'ASC')
					->get();
		return $result;
	} 

	/**  
    *  Get Record From DataBase
    *  @author Rajesh 
    *  @param $fieldArray,$orderid,$request
    *  Created At 2020/10/01
    **/
    public static function selectOnefieldDatas($fieldArray,$orderid,$request) {
        $db = DB::connection('mysql');
        $fieldNames="";
        for ($i=0; $i < count($fieldArray); $i++) {
            $fieldNames .= "".$fieldArray[$i].",";
        }
        $fieldNames = rtrim($fieldNames, ',');
           $query = $db->table($request->skillSel)
                ->select(DB::raw($fieldNames))
                ->orderBy($orderid,'ASC')
                ->get();

        return $query;
    }



	public static function getSkillDetail($empid){
		$db = DB::connection('mysql');
		$result = $db->TABLE('emp_mstskills')
				->select('programming_lang','japanese_skill','youTubeUrl','os','data_base','tool')
				->WHERE('empId', $empid)
				->WHERE('delFlg',0)
				->get();
		return $result;	
	}
	public static function updateSkillDetail($request){
		$db = DB::connection('mysql');
		$result = $db->TABLE('emp_mstskills')
				->WHERE('empId', $request->empId)
				->update([
						$request->fieldName => $request->hidskillId,
						'updatedDate' => date('Y-m-d'),
						'updatedBy' => Auth::user()->username
					]);
		return $result;		
	}
	public static function regSkillDetail($request){
		$db = DB::connection('mysql');
		$insert= $db->table('emp_mstskills')
			->insert([
				'empId'=> $request->empId,
				$request->fieldName => $request->hidskillId,
				'createdDate' => date('Y-m-d'),
				'createdBy' => Auth::user()->username,
				'delFlg' => 0
				]);
		return $insert;
	}

	public static function getSkillsingle($id){
		$db = DB::connection('mysql');
		$result = $db->TABLE('emp_sysprogramlangtypes')
					->select('id','ProgramLangTypeCD','ProgramLangTypeNM')
					->WHERE('DelFlg',0)
					->WHERE('id',$id)
					->get();
		return $result;
	} 

	public static function updateVideo($request){
		$db = DB::connection('mysql');
		$result = $db->TABLE('emp_mstskills')
				->WHERE('empId', $request->empId)
				->update(['kanaName' => $request->Kananame,
						'lastName' => $request->Lastname,
						'youTubeUrl' => $request->urlLink,
						'updatedDate' => date('Y-m-d'),
						'updatedBy' => Auth::user()->username
					]);
		return $result; 
	}
	public static function insertVideo($request){
		$db = DB::connection('mysql');
		$insert= $db->table('emp_mstskills')
			->insert([
				'empId'=> $request->empId,
				'kanaName' => $request->Kananame,
				'lastName' => $request->Lastname,
				'youTubeUrl' => $request->urlLink,
				'createdDate' => date('Y-m-d'),
				'createdBy' => Auth::user()->username,
				'delFlg' => 0
				]);
		return $insert; 
	}
	public static function regOtherMail($mail,$name){
		$db = DB::connection('mysql');
		$insert= $db->table('other_mail_list')
			->insert([
				'other_name' => $name,
				'other_mailid' => $mail,
				'createdDate' => date('Y-m-d'),
				'createdBy' => Auth::user()->username,
				'delFlg' => 0
				]);
		return $insert; 
	}
	public static function getOthermailDt(){
		$db = DB::connection('mysql');
		$result = $db->TABLE('other_mail_list')
					->select('*')
					->WHERE('delFlg',0)
					->get();
		return $result;
	}
	public static function fnExistsCheck($request){
		$db = DB::connection('mysql');
		$exist = $db->TABLE('mst_cus_inchargedetail')
					->select('*')
					->WHERE('incharge_email_id','=', $request->mailId)
					->get();
		$existOther = $db->TABLE('other_mail_list')
					->select('*')
					->WHERE('other_mailid','=', $request->mailId);
			if($request->editId != ""){
				$existOther	= $existOther->WHERE('id','!=', $request->editId)->get();
			} else {
				$existOther = $existOther->get();
			}
		$result = count($exist)+ count($existOther);			
		return $result;
	}
	public static function fnupdateOtherMailDetail($request)
	{
		$db = DB::connection('mysql');
		$result = $db->TABLE('other_mail_list')
				->WHERE('id', $request->editId)
				->update(['other_name' => $request->other_name,
						'other_mailid' => $request->mailId,
						'updatedDate' => date('Y-m-d'),
						'updatedBy' => Auth::user()->username
					]);
		return $result; 
	}
	public static function getOtherNameEmail($id)
	{
		$db = DB::connection('mysql');
			foreach ($id as $key => $value) {
				$result = $db->TABLE('other_mail_list')
					->select('*')
					->WHERE('id','=', $value)
					->get();
				$query[$key] = $result[0];
			}
		return $query;
	}
}
