<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Session;
use Config;
class Customer extends Model {

	public static function customerChangeFlg($request) {
		$db = DB::connection('mysql');
		$update= $db->TABLE('mst_customerdetail')
			->WHERE('id', $request->id)
			->update(
				['update_date' => date('Y-m-dh:i:s'),
				 'delflg' => $request->useval]
		);
		return $update;
	}

	public static function getGroupName() {
		$db = DB::connection('mysql');
		$query = $db->TABLE('mst_cus_group')
					->SELECT('*')
					// ->WHERE('delFlg', 0)
					->ORDERBY('groupId', 'ASC')
					->get();
		return $query;
	}
	public static function getGroupCheck($request){
		$db = DB::connection('mysql');
		$query = $db->TABLE('mst_customerdetail')
					->SELECT('groupId')
					->WHERE('customer_id', $request->custId)
					->get();
		return $query;
	}
	public static function CustomerDetailsSelect($request) {
		$db = DB::connection('mysql');
		$query = $db->TABLE($db->raw("(select *
				from mst_customerdetail) as tbl1"));
			if ($request->filterval != 1) {
				$query = $query->where(function($joincont) use ($request) {
								$joincont->where('groupId', 'LIKE', '%' . $request->filterval . '%');
								  });
			} else {
				$query = $query->where(function($joincont) use ($request) {
							$joincont->where('groupId', '=', '')
									->orWhere('groupId', '=', NULL);
								});
			}
			if (!empty($request->singlesearchtxt)) {
				$query = $query->where(function($joincont) use ($request) {
								$joincont->where('customer_name', 'LIKE', '%' . $request->singlesearchtxt . '%')
								->orWhere('customer_address', 'LIKE', '%' . $request->singlesearchtxt . '%');
								});
			}
			if (!empty($request->name)) {
				$query = $query->where(function($joincont) use ($request) {
								$joincont->where('customer_name', 'LIKE', '%' . $request->name . '%');
								});
			}
			if (!empty($request->address)) {
				$query = $query->where(function($joincont) use ($request) {
								$joincont->where('customer_address', 'LIKE', '%' . $request->address . '%');
								});
			}
			if (!empty($request->name && $request->address)) {
				$query = $query->where(function($joincont) use ($request) {
								$joincont->where('customer_name', 'LIKE', '%' . $request->name . '%')
								->orWhere('customer_address', 'LIKE', '%' . $request->address . '%');
								});
			}
			if(!empty($request->startdate) && !empty($request->enddate)) {
				$query = $query->where('contract','>=',$request->startdate);
				$query = $query->where('contract','<=',$request->enddate);
			}
			if (!empty($request->startdate) && empty($request->enddate)) {
				$query = $query->where('contract','>=',$request->startdate);
			}
			if (empty($request->startdate) &&!empty($request->enddate)) {
				$query = $query->where('contract','<=',$request->enddate);
			}
			if($request->oldfilter == $request->filterval){
				$query = $query->ORDERBY($request->cussort, $request->sortOrder)
							   ->ORDERBY('customer_id', 'DESC');	
			} else {
				$query = $query->ORDERBY($request->cussort, $request->sortOrder)
								->ORDERBY('customer_id', 'DESC');
								$request->cussort = "customer_id";
			}
			$query = $query-> paginate($request->plimit);
		return $query;
	}
	public static function cntGrpCus($groupId) {
		$db = DB::connection('mysql');
		$query = $db->TABLE('mst_customerdetail')
					->SELECT(DB::raw('COUNT(customer_id) AS cntCusId'))
					->where('groupId', 'LIKE', '%' . $groupId . '%')
					// ->toSql();dd($query);
					->get();
		return $query;
	}
	public static function getKenName($kenId) {
		$db = DB::connection('mysql');
		$query = $db->TABLE('mst_prefecture')
					->select('prefecture_name_jp')
					->WHERE('id','=',$kenId)
					->get();
		return $query;
	}
	public static function getSelectedMember($id) {
		$db = DB::connection('mysql');
		$query= $db->table('mst_branchdetails')
					->SELECT('mst_branchdetails.*')
					->leftJoin('mst_customerdetail', 'mst_customerdetail.customer_id', '=', 'mst_branchdetails.customer_id')
					->where('mst_customerdetail.customer_id','=', $id)
					->ORDERBY('mst_branchdetails.branch_id','ASC')
					->get();
		return $query;
	}
	public static function updGrpId($request) {
		$db = DB::connection('mysql');
		$update = DB::TABLE('mst_customerdetail')
			->WHERE('customer_id', $request->customerId)
			->update(['groupId' => $request->groupId]);
		return $update;
	}
	public static function getKendetails() {
		$query = DB::table('mst_prefecture')
				->select('id','prefecture_name_jp')
				->WHERE('delflg', '=', 0)
				->lists('prefecture_name_jp','id');
		return $query;	
	} 
	public static function getMaxId(){
		$query = DB::SELECT("SELECT CONCAT('CST', LPAD(MAX(SUBSTRING(customer_id,5))+100,5,0)) AS custid FROM mst_customerdetail WHERE customer_id LIKE '%CST%'");
		return $query;
	}
	public static function fnGetEmailExistsCheck($request){
		$db = DB::connection('mysql');
		$result = $db->TABLE('mst_cus_inchargedetail')
					->select('*')
					->WHERE('incharge_email_id','=', $request->mailId);
			if($request->editId != ""){
				$result	= $result->WHERE('id','!=', $request->editId)->get();
			} else {
				$result = $result->get();
			}
		$existOther = $db->TABLE('other_mail_list')
				->select('*')
				->WHERE('other_mailid','=', $request->mailId)
				->get();
		$retresult = count($result) + count($existOther);
		return $retresult;
	}
	public static function InsertCustomerRec($request,$cus,$groupIdList){
		$insert=DB::table('mst_customerdetail')->insert([
			'customer_id' => $cus,
			'customer_name' => $request->txt_custnamejp,
			 'contract' => $request->txt_custagreement,
			 'create_date' => date('Y-m-d'),
			'create_by' => Auth::user()->username,
			 'customer_contact_no' => $request->txt_mobilenumber,
			 'customer_email_id'=> '',
			 'customer_fax_no'=> $request->txt_fax,
			 'customer_website' => $request->txt_url,
			 'customer_address'=>$request->txt_address,
			 'postalNumber'=>$request->txt_postal,
			 'kenmei'=>$request->kenmei,
			 'shimei'=>$request->txt_shimei,
			 'street_address'=>$request->txt_streetaddress,
			 'buildingname'=>$request->txt_buildingname,
			 'romaji'=> $request->txt_kananame,
			 'delflg'=> 0,
			 'nickname'=> $request->txt_repname,
			 'groupId' => $groupIdList
			]);
		$id = DB::getPdo()->lastInsertId();;
		return $id;
	}
	public static function InsertBranchRec($request,$branchid,$cus) {
		$insert=DB::table('mst_branchdetails')->insert([
				'id' => '',
				'customer_id' => $cus,
				'branch_id' => $branchid,
				'branch_name' => $request->txt_branch_name,
				 'branch_contact_no' => $request->txt_mobilenumber,
				 'branch_fax_no' => $request->txt_fax,
				 'postalNumber' => $request->txt_postal,
				 'kenmei' => $request->kenmei,
				 'shimei' => $request->txt_shimei,
				 'street_address' => $request->txt_streetaddress,
				 'buildingname' => $request->txt_buildingname,
				 'branch_address' => $request->txt_address,
				 'create_date' => date('Y-m-d'),
				'create_by' => Auth::user()->username,
				'delflg' => 0
				]);
	}
	public static function InsertIncharge($request,$branchid,$cus3) {
		$insert=DB::table('mst_cus_inchargedetail')->insert([
				'id' => '',
				'customer_id' => $cus3,
				'incharge_name' => $request->txt_incharge_name,
				'incharge_email_id' => $request->txt_mailid,
				'password' => md5('mb'),
				'create_date' => date('Y-m-d'),
				'create_by' => Auth::user()->username,
				'delflg' =>0,
				'designation' =>17,
				'confirmpassword' =>'',
				'branch_name' => $branchid
				]);
		return $insert;
	}
	public static function getInchargeDetails($id){
		$db = DB::connection('mysql');
		$query= $db->table('mst_cus_inchargedetail')
					->SELECT('mst_cus_inchargedetail.*','sysdesignationtypes.DesignationNM')
					->leftJoin('sysdesignationtypes', 'sysdesignationtypes.DesignationCD', '=', 'mst_cus_inchargedetail.designation')
					->where('mst_cus_inchargedetail.customer_id','=', $id)
					->get();
		return $query;
	}
	public static function getBranchDetails($id){
		$db =DB::connection('mysql');
		$tbl_name = "mst_branchdetails";
		$query= $db->table($tbl_name)
				   ->select('mst_branchdetails.*',
							 'mst_prefecture.prefecture_name_jp As prefNameJP',
							 'mst_prefecture.prefecture_name_en As prefNameEN')
				   ->leftJoin('mst_prefecture', 'mst_prefecture.id', '=', 'mst_branchdetails.kenmei')
				   ->where('customer_id','=', $id)
				   ->ORDERBY('branch_id','ASC')
				   ->get();
		return $query;
	}
	public static function getInchargeDetailsByBranch($id,$branchid) {
		$db = DB::connection('mysql');
		$query= $db->table('mst_cus_inchargedetail')
					->SELECT('mst_cus_inchargedetail.*','sysdesignationtypes.DesignationNM')
					->leftJoin('sysdesignationtypes', 'sysdesignationtypes.DesignationCD', '=', 'mst_cus_inchargedetail.designation')
					->where('mst_cus_inchargedetail.customer_id','=', $id)
					->where('mst_cus_inchargedetail.branch_name','=', $branchid)
					->get();
		return $query;
	}
	public static function selectIdclientDtl($id) { 
		$sql = " SELECT * FROM  mst_customerdetail LEFT JOIN inv_clientemp_dtl ON 
					inv_clientemp_dtl.cust_id = mst_customerdetail.customer_id 
					AND LEFT(inv_clientemp_dtl.emp_id, 3) NOT LIKE '%MBC%'
					where inv_clientemp_dtl.cust_id = '".$id."' AND
					inv_clientemp_dtl.delFLg = 0 AND
					inv_clientemp_dtl.status = 1
					ORDER BY inv_clientemp_dtl.start_date DESC";
		$cards = DB::select($sql);
		return $cards;
	}
	
	public static function getYrMonCountBtwnDates($startDT, $endDT){
		$retVal['year']=0;
		$retVal['month']=0;
		if ($endDT == ""||$endDT=="0000-00-00") {
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
  	public static function selectByIdchangeclientDtl($id) { 
		$sql = "SELECT * FROM  mst_customerdetail LEFT JOIN inv_clientemp_dtl ON 
					inv_clientemp_dtl.cust_id = mst_customerdetail.customer_id 
					AND LEFT(inv_clientemp_dtl.emp_id, 3) NOT LIKE '%MBC%'
					where inv_clientemp_dtl.cust_id = '".$id."' AND
					inv_clientemp_dtl.delFLg = 1 AND
					inv_clientemp_dtl.status = 1
					ORDER BY inv_clientemp_dtl.end_date DESC";
		$cards = DB::select($sql);
		return $cards;
	}
	public static function getCustomerDetails($request) {
		$db =DB::connection('mysql');
		$query= $db->table('mst_customerdetail')
				   	->select('mst_customerdetail.id AS id',
							 'customer_id AS custid', 
							 'customer_name AS txt_custnamejp',
							 'contract AS txt_custagreement', 
							 'customer_contact_no AS txt_mobilenumber',
							 'customer_fax_no AS txt_fax', 
							 'customer_website AS txt_url', 
							 'customer_address As txt_address',
							 'postalNumber As postalNumber',
							 'kenmei As kenmei',
							 'shimei As shimei',
							 'street_address As street_address',
							 'buildingname As buildingname',
							 'romaji As txt_kananame',
							 'nickname As txt_repname',
							 'cover_letter As coverletter',
							 'mst_prefecture.prefecture_name_jp As prefNameJP',
							 'mst_prefecture.prefecture_name_en As prefNameEN',
							 'groupId AS groupId'
							 )
				   	->leftJoin('mst_prefecture', 'mst_prefecture.id', '=', 'mst_customerdetail.kenmei')
				   	->where('mst_customerdetail.id','=', $request->id)
				   	->get();
		return $query;
	}
	public static function getBranchdt($request,$branchid) { 
		$db =DB::connection('mysql');
		$query= $db->table('mst_branchdetails')
				   ->select('mst_branchdetails.id AS id',
							 'branch_id AS branch_id',
							 'branch_name AS branch_name',
							 'branch_contact_no AS txt_mobilenumber',
							 'branch_fax_no AS txt_fax',
							 'postalNumber AS postalNumber',
							 'kenmei AS kenmei',
							 'shimei AS shimei',
							 'street_address AS street_address',
							 'buildingname AS buildingname',
							 'branch_address AS branch_address',
							 'mst_prefecture.prefecture_name_jp As prefNameJP',
							 'mst_prefecture.prefecture_name_en As prefNameEN'
							 )
				   ->leftJoin('mst_prefecture', 'mst_prefecture.id', '=', 'mst_branchdetails.kenmei')
				   ->where('customer_id','=', $request->custid)
				   ->where('branch_id','=', $branchid)
				   ->get();
		return $query;
	}
	public static function updaterec($request,$groupIdList) { 
		$db = DB::connection('mysql');
		$tbl_name = "mst_customerdetail";
		$allupdatequery= $db->table($tbl_name)
					->where('id', $request->editid)
					->update([ 'customer_id' => $request->custid,
								'customer_name' => $request->txt_custnamejp,
								'contract' => $request->txt_custagreement,
								'update_date' => date('Y-m-d'),
								'update_by' => Auth::user()->username,
								'customer_contact_no' => $request->txt_mobilenumber,
								'customer_email_id'=> '',
								'customer_fax_no'=> $request->txt_fax,
								'customer_website' => $request->txt_url,
								'customer_address'=>$request->txt_address,
								'postalNumber'=>$request->txt_postal,
								'kenmei'=>$request->kenmei,
								'shimei'=>$request->txt_shimei,
								'street_address'=>$request->txt_streetaddress,
								'buildingname'=>$request->txt_buildingname,
								'romaji'=> $request->txt_kananame,
								'nickname'=> $request->txt_repname,
								'groupId' => $groupIdList]);
		  return $allupdatequery;
	}
	public static function updatebranchrec($request,$branchid) {
		$db = DB::connection('mysql');
		$tbl_name = "mst_branchdetails";
		$allupdatequery= $db->table($tbl_name)
					->where('customer_id','=', $request->custid)
				   ->where('branch_id','=', $branchid)
					->update([ 'branch_name' => $request->txt_branch_name,
								'branch_contact_no' => $request->txt_mobilenumber,
								'branch_fax_no' => $request->txt_fax,
								'postalNumber' => $request->txt_postal,
								'kenmei' => $request->kenmei,
								'shimei' => $request->txt_shimei,
								'street_address' => $request->txt_streetaddress,
								'buildingname' => $request->txt_buildingname,
								'branch_address' => $request->txt_address,
								'delflg'=> 0,
								'update_date' => date('Y-m-d'),
								'update_by' => Auth::user()->username]);
		  return $allupdatequery;
	}
	public static function getMaxBranchId($request)	{
			$db =DB::connection('mysql');
			$tbl_name = "mst_branchdetails";
			$query= $db->table($tbl_name)
					   ->select('branch_id')
					   ->where('customer_id','=', $request->custid)
					   ->ORDERBY('branch_id', 'DESC')
					   ->lists('branch_id');
					   //->first();
			return $query;
	}
	public static function getDesignationList()	{
			$db =DB::connection('mysql');
			$tbl_name = "sysdesignationtypes";
			$query= $db->table($tbl_name)
					   ->select('DesignationCD','DesignationNM')
					   ->where('DelFlg','=', 0)
					   ->ORDERBY('Order_id', 'ASC')
					   ->lists('DesignationNM','DesignationCD');
			return $query;
	}
	public static function insertInchargeRecord($request,$cus) {
		$insert=DB::table('mst_cus_inchargedetail')->insert([
				'id' => '',
				'customer_id' => $cus,
				'incharge_name' => $request->txt_incharge_name,
				'incharge_name_romaji' => $request->txt_incharge_namekana,
				'incharge_contact_no' => $request->txt_mobilenumber,
				'incharge_email_id' => $request->txt_mailid,
				'password' => md5('mb'),
				'create_date' => date('Y-m-d'),
				'create_by' => Auth::user()->username,
				'delflg' =>0,
				'designation' => $request->designation,
				'confirmpassword' =>'',
				'branch_name' => $request->bname
				]);
		return $insert;
	}
	public static function getInchargeUpdateDetails($request,$inchargeid) { 
		 $db =DB::connection('mysql');
		$tbl_name = "mst_cus_inchargedetail";
		$query= $db->table($tbl_name)
				   ->select('id AS id',
							 'incharge_name AS txt_incharge_name',
							 'incharge_name_romaji AS txt_incharge_namekana',
							 'incharge_contact_no AS txt_mobilenumber',
							 'incharge_email_id AS txt_mailid',
							 'designation AS designation',
							 'branch_name AS bname'
							 )
				   ->where('id','=', $inchargeid)
				   ->get();
		return $query;
	}
	public static function updateInchargeRec($request,$id) { 
		$db = DB::connection('mysql');
		$tbl_name = "mst_cus_inchargedetail";
		$allupdatequery= $db->table($tbl_name)
				   ->where('id','=', $id)
					->update(['customer_id' => $request->custid,
							'incharge_name' => $request->txt_incharge_name,
							'incharge_name_romaji' => $request->txt_incharge_namekana,
							'incharge_contact_no' => $request->txt_mobilenumber,
							'incharge_email_id' => $request->txt_mailid,
							'designation' => $request->designation,
							'branch_name' => $request->bname,
							'delflg'=> 0,
							'update_date' => date('Y-m-d'),
							'update_by' => Auth::user()->username]);
		  return $allupdatequery;
	}
	public static  function getCusDetailEmp($request) {
		$db =DB::connection('mysql');
		$tbl_name = "mst_customerdetail";
		$query= $db->table($tbl_name)
				   ->select('mst_customerdetail.*')
				   ->where('customer_id','=', $request->custid)
				   ->get();
		return $query;
	}
	public static function getUserNameByEmployee($request) {
		$db = DB::connection('mysql_mbstaff');
		$result = $db->table('emp_mstemployees')
						->select('FirstName', 'LastName','Emp_ID')
						->WHERE('resign_id', '=', 0)
						->WHERE('delFlg', '=', 0)
						->WHERE('Title', '=', 2)
						->ORDERBY('LastName','ASC' ) 
						->lists('LastName','Emp_ID');
					return $result;
	}
	public static function getBranchDetailsEmp($request)	{
		$db =DB::connection('mysql');
		$tbl_name = "mst_branchdetails";
		$query= $db->table($tbl_name)
				   ->select('branch_name','branch_id')
				   ->where('customer_id','=', $request->custid)
				   ->ORDERBY('branch_id', 'DESC')
				   ->lists('branch_name','branch_id');
		return $query;
	}

	public static function selectEmpAddressInClient($request) {
		$query = DB::table('inv_clientemp_dtl')
					->select('inv_clientemp_dtl.start_date',
				'inv_clientemp_dtl.cust_id','inv_clientemp_dtl.end_date','inv_clientemp_dtl.status','mst_customerdetail.customer_name', 'inv_clientemp_dtl.branch_id','mst_branchdetails.branch_name','mst_cus_inchargedetail.incharge_name')
					->leftjoin('mst_customerdetail', 'mst_customerdetail.customer_id', '=', 'inv_clientemp_dtl.cust_id') 
					->leftjoin('mst_branchdetails', 'mst_branchdetails.branch_id', '=', 'inv_clientemp_dtl.branch_id')
					->leftjoin('mst_cus_inchargedetail', 'mst_cus_inchargedetail.id', '=', 'inv_clientemp_dtl.incharge_id')
					->where('inv_clientemp_dtl.cust_id', $request->custid)
					->where('inv_clientemp_dtl.status','=', 1)
					->where('inv_clientemp_dtl.delFLg','=', 0)
					->get();
				return $query;
	} 
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
	public static function insclientdtl($request) {
		$insert = DB::table('inv_clientemp_dtl')
				->insert(
				['cust_id' => $request->custid,
				'status' => 1,
				'emp_id' => $request->newemployeename,
				'start_date' => $request->txt_start_date,
				'delFLg' => 0,
				'incharge_id' => $request->inchargeId,
				'branch_id' => $request->newbranches,
				'CreatedBy' => Auth::user()->username]);
		return $insert;
	}
	public static function updateEnddate($request) {
		$db = DB::connection('mysql');
		$result = DB::table('inv_clientemp_dtl')
				->where('emp_id', $request->empidd)
				->where('status', 1)
				->where('delFLg', 0)
				->update([
					'start_date' => $request->txt_start_date,
					'end_date' => $request->txt_end_date,
					'UpdatedBy' => Auth::user()->username,
					'delFLg' => 1]);
		return $result;
	}
	public static function fnGetOnsiteHistoryDetails($request) {
		$db = DB::connection('mysql');
		$query =  $db->TABLE('inv_clientemp_dtl as cli')
				->SELECT('cli.cust_id',
						'cli.status',
						'cli.start_date',
						'cli.end_date',
						'brn.branch_name',
						'cus.customer_name')
				->JOIN('mst_customerdetail AS cus','cli.cust_id','=','cus.customer_id')
				->JOIN('mst_branchdetails AS brn','cli.branch_id','=','brn.branch_id')
				->where('cli.emp_id','=', $request->hdnempid)
				->paginate($request->plimit);
		return $query;
	}
}

