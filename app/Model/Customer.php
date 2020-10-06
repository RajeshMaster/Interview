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
					->WHERE('delFlg', 0)
					->ORDERBY('groupId', 'ASC')
					->get();
		return $query;
	}

	public static function CustomerDetailsSelect($request) {
		$db = DB::connection('mysql');
		$query = $db->TABLE($db->raw("(select *,
				(SELECT count(inv_clientemp_dtl.cust_id) AS cnt FROM emp_mstemployees 
								LEFT JOIN inv_clientemp_dtl ON emp_mstemployees.Emp_ID=inv_clientemp_dtl.emp_id
								where inv_clientemp_dtl.status = '1' AND emp_mstemployees.resign_id = '0' AND inv_clientemp_dtl.cust_id = mst_customerdetail.customer_id) 
				CNT 
				from mst_customerdetail) as tbl1"));
			if ($request->filterval != 1) {
				$query = $query->where(function($joincont) use ($request) {
								$joincont->where('groupId', '=', $request->filterval);
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
					// $query =$query->tosql();
					// dd($query);
		return $query;
	}
	public static function cntGrpCus($groupId) {
		$db = DB::connection('mysql');
		$query = $db->TABLE('mst_customerdetail')
					->SELECT(DB::raw('COUNT(customer_id) AS cntCusId'))
					->where('groupId', $groupId)
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
			->update(['groupId' => $request->grpId]);
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
		// $custname = trim(iconv(mb_detect_encoding($customer_name), 'UTF-8', $customer_name));
		$db = DB::connection('mysql');
		$result = $db->TABLE('mst_cus_inchargedetail')
					->select('*')
					->WHERE('incharge_email_id','=', $request->mailId);
			if($request->editId != ""){
				$result	= $result->WHERE('id','!=', $request->editId)->get();
			} else {
				$result = $result->get();
			}
		return $result;
	}
	public static function InsertCustomerRec($request,$cus){
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
}