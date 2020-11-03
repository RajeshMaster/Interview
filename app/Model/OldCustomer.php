<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Session;
use Config;
class OldCustomer extends Model {

	public static function customerchange($request) {
		$db = DB::connection('mysql');
		$update=DB::table('temp_mst_customerdetail')
			->where('id', $request->id)
			->update(
				['update_date' => date('Y-m-dh:i:s'),
				 'delflg' => $request->useval]
		);
		return $update;
	}

	/**  
	*  Employee Details
	*  @author Rajesh 
	*  @param $request
	*  Created At 2020/10/06
	**/
	public static function CustomerDetails($request) {
		$db = DB::connection('mysql');

		$query= $db->table('temp_mst_customerdetail')
					->SELECT('temp_mst_customerdetail.*');
		
			if (!empty($request->singlesearchtxt)) {
					$query = $query->where(function($joincont) use ($request) {
									$joincont->where('customer_name', 'LIKE', '%' . trim($request->singlesearchtxt) . '%')
									->orWhere('customer_address', 'LIKE', '%' . trim($request->singlesearchtxt) . '%');
									});
				}
			
				if (!empty($request->name)) {
					$query = $query->where(function($joincont) use ($request) {
									$joincont->where('customer_name', 'LIKE', '%' . trim($request->name) . '%');
								   // ->orWhere('customer_address', 'LIKE', '%' . trim($request->address) . '%');
									});
				}
				if (!empty($request->address)) {
					$query = $query->where(function($joincont) use ($request) {
									$joincont->where('customer_address', 'LIKE', '%' . trim($request->address) . '%');
								   // ->orWhere('customer_address', 'LIKE', '%' . trim($request->address) . '%');
									});
				}
				if (!empty($request->name && $request->address)) {
					$query = $query->where(function($joincont) use ($request) {
									$joincont->where('customer_name', 'LIKE', '%' . trim($request->name) . '%')
									->orWhere('customer_address', 'LIKE', '%' . trim($request->address) . '%');
									});
				}
				if (!empty($request->startdate) && !empty($request->enddate)) {
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
				$query =$query->paginate($request->plimit);
							/*	$query =$query->tosql();
											 dd($query);*/
			return $query;
	}


	public static function getSelectedMember($id) {
		$db = DB::connection('mysql');
		$query= $db->table('temp_mst_branchdetails')
					->SELECT('temp_mst_branchdetails.*')
					->leftJoin('temp_mst_customerdetail', 'temp_mst_customerdetail.customer_id', '=', 'temp_mst_branchdetails.customer_id')
					->where('temp_mst_customerdetail.customer_id','=', $id)
					->ORDERBY('temp_mst_branchdetails.branch_id','ASC')
					->get();
		return $query;
	}


	public static function getbranchdetails($request,$branchid) { 
		$db =DB::connection('mysql');
		$tbl_name = "temp_mst_branchdetails";
		$query= $db->table($tbl_name)
					->select('id AS id',
							 'branch_id AS branch_id',
							 'branch_name AS branch_name',
							 'branch_contact_no AS txt_mobilenumber',
							 'branch_fax_no AS txt_fax',
							 'branch_address AS txt_address' 
							 )
					->where('customer_id','=', $request->custid)
					->where('branch_id','=', $branchid)
					->get();
		return $query;
	 }

	public static function getinchargedetails($id) {
		$db = DB::connection('mysql');
		$query= $db->table('temp_mst_cus_inchargedetail')
					->SELECT('temp_mst_cus_inchargedetail.*','sysdesignationtypes.DesignationNM')
					->leftJoin('sysdesignationtypes', 'sysdesignationtypes.DesignationCD', '=', 'temp_mst_cus_inchargedetail.designation')
					->where('temp_mst_cus_inchargedetail.branch_name','=', $id)
					->get();
		return $query;
	}

	public static function getbdetails($id) { 
		$db =DB::connection('mysql');
		$tbl_name = "temp_mst_branchdetails";
		$query= $db->table($tbl_name)
					->select('temp_mst_branchdetails.*')
					->where('customer_id','=', $id)
					->ORDERBY('branch_id','ASC')
					->get();
		return $query;
	}

	public static function selectByIdclient($id) { 
		$db =DB::connection('mysql');
		$sql="SELECT * FROM  temp_mst_customerdetail LEFT JOIN temp_clientempteam ON temp_clientempteam.cust_id = temp_mst_customerdetail.customer_id 
					AND LEFT(temp_clientempteam.emp_id, 3) NOT LIKE '%MBC%'
					where temp_clientempteam.cust_id = '".$id."' ORDER BY temp_clientempteam.start_date DESC";
		$cards = $db->select($sql);
		return $cards;
	}

	public static function selectByIdchangeclient($id) { 
		$db =DB::connection('mysql');
		$sql="SELECT * FROM  temp_mst_customerdetail LEFT JOIN temp_clientempteam ON temp_clientempteam.cust_id = temp_mst_customerdetail.customer_id 
					AND LEFT(temp_clientempteam.emp_id, 3) NOT LIKE '%MBC%'
					where temp_clientempteam.cust_id = '".$id."' ORDER BY temp_clientempteam.end_date DESC";
		$cards = $db->select($sql);
		return $cards;
	}
	public static function getcustomerdetails($request) {
        $db = DB::connection('mysql');
        $tbl_name = "temp_mst_customerdetail";
        $query= $db->table($tbl_name)
                   ->select('id AS id',
                   			 'customer_id AS custid', 
                             'customer_name AS txt_custnamejp',
                             'contract AS txt_custagreement', 
                             'customer_contact_no AS txt_mobilenumber',
                             'customer_fax_no AS txt_fax', 
                             'customer_website AS txt_url', 
                             'customer_address As txt_address',
                             'romaji As txt_kananame',
                             'nickname As txt_repname',
                             'cover_letter As coverletter'
                             )
                   ->where('id','=', $request->id)
                   ->get();
        return $query;
    }

    public static function getallIncharge($customerid) {
		 $db = DB::connection('mysql');
        $tbl_name = "temp_mst_cus_inchargedetail";
        $query= $db->table($tbl_name)
                   ->select('temp_mst_cus_inchargedetail.*')
                   ->where('customer_id','=', $customerid)
                   ->ORDERBY('id','ASC')
                   ->get();
        return $query;
	}

	public static function getmaxid() {
			$db = DB::connection('mysql');
			$maxid=DB::table('mst_customerdetail')
				->max('customer_id');
			return $maxid;
	}

	public static function insertRec($request,$cus) {
		$insert=DB::table('mst_customerdetail')->insert([
			'id' => '',
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
	}

	public static function fetchmaxid($request) {
		$db = DB::connection('mysql');
		$latDetails = $db->table('mst_customerdetail')
						   ->max('id');
			return $latDetails;
	}

	public static function insertbranchrec($request,$branchid,$cus) {
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
			//'update_date' => date('Y-m-d'),
			//'Update_by' => Auth::user()->username,
			'delflg' => 0
			]);
	}

	public static function insertincharge($name,$mail,$branchid,$cus3) {
		// Rajesh 
		$insert=DB::table('mst_cus_inchargedetail')->insert([
				'id' => '',
				'customer_id' => $cus3,
				'incharge_name' => $name,
				'incharge_email_id' => $mail,
				'password' => md5('mb'),
				'create_date' => date('Y-m-d'),
				'create_by' => Auth::user()->username,
				'delflg' =>0,
				'designation' =>17,
				'confirmpassword' =>'',
				'branch_name' => $branchid
				]);
		// Rajesh
		return $insert;
	}

	public static function getonebranch($branch_id) { 
        $db = DB::connection('mysql');
        $tbl_name = "temp_mst_branchdetails";
        $query= $db->table($tbl_name)
                   ->select('temp_mst_branchdetails.*')
                   ->where('branch_id','=', $branch_id)
                   ->ORDERBY('branch_id','ASC')
                   ->get();
        return $query;
    }

   	public static function branchadd($request)	{
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

	public static function fnGetEmailExistsCheckmanyField($mail){
		$db = DB::connection('mysql');
		$result = $db->TABLE('mst_cus_inchargedetail')
					->select('*')
					->WHERE('incharge_email_id','=', $mail)
					->get();
		return $result;
	}

	public static function fnOldDbDetails() {
		$db = DB::connection('mysql');
		$result= DB::table('olddbdetailsregistration')
						->SELECT('*')
						->WHERE('Delflg', '=', 0)
						->lists('DBName','id');
		return $result;
	}

	public static function fnGetCustomerCount() {
		$db = DB::connection('mysql');
		$sql= DB::table('mst_customerdetail')
						->SELECT('*')
						->count();
		return $sql;
	}

	public static function fnGetConnectionQuery($request){
        $db = DB::connection('mysql');
        $query= DB::table('olddbdetailsregistration')
                        ->SELECT('*')
                        ->where([['Delflg', '=', 0],['id', '=', $request->contentsel]])
                        ->get();
        return $query;
    }

    public static function fnGetCustomerDetailsMB() {
		$db = DB::connection('otherdb');
		$query= $db->table('mst_customerdetail as cus')
						->SELECT('*')
						->get();
						
		return $query;
	}

	public static function fnOldTempstaffExist($cusid) {
		$sql= DB::table('temp_mst_customerdetail')
						->SELECT('*')
						->WHERE('customer_id', '=', $cusid)
						->get();
		return $sql;
	}

	public static function fnInsertOLDMBDetails($fldarray, $valuearray) {
		$db = DB::connection('mysql');
		$result= $insert=DB::table('temp_mst_customerdetail')->insert(
			[$fldarray[0] => $valuearray[0],
			$fldarray[1] => $valuearray[1],
			$fldarray[2] => $valuearray[2],
			$fldarray[3] => $valuearray[3],
			$fldarray[4] => $valuearray[4],
			$fldarray[5] => $valuearray[5],
			$fldarray[6] => $valuearray[6],
			$fldarray[7] => $valuearray[7],
			$fldarray[8] => $valuearray[8],
			$fldarray[9] => $valuearray[9],
			$fldarray[10] => $valuearray[10],
			$fldarray[11] => $valuearray[11],
			$fldarray[12] => $valuearray[12],
			$fldarray[13] => $valuearray[13],
			$fldarray[14] => $valuearray[14],
			$fldarray[15] => $valuearray[15],
			$fldarray[16] => $valuearray[16],
			$fldarray[17] => $valuearray[17],
			
			]
		);
		return $result;
	}

	public static function fnGetCustomerBranchDetailsMB() {
		$db = DB::connection('otherdb');
		$query= $db->table('mst_branchdetails as branch')
						->SELECT('*')
						->get();
						
		return $query;
	}

	public static function fnUpdateOLDMBDetails($fldarray, $valuearray, $tempvar) {
		$db = DB::connection('mysql');
		$update=DB::table('temp_mst_customerdetail')
		->where('customer_id', $tempvar)
		->update(
			[$fldarray[0] => $valuearray[0],
			$fldarray[1] => $valuearray[1],
			$fldarray[2] => $valuearray[2],
			$fldarray[3] => $valuearray[3],
			$fldarray[4] => $valuearray[4],
			$fldarray[5] => $valuearray[5],
			$fldarray[6] => $valuearray[6],
			$fldarray[7] => $valuearray[7],
			$fldarray[8] => $valuearray[8],
			$fldarray[9] => $valuearray[9],
			$fldarray[10] => $valuearray[10],
			$fldarray[11] => $valuearray[11],
			$fldarray[12] => $valuearray[12],
			$fldarray[13] => $valuearray[13],
			$fldarray[14] => $valuearray[14],
			$fldarray[15] => $valuearray[15],
			$fldarray[16] => $valuearray[16]
			]
		);
		return $update;
	}

	public static function fnOldTempbranchExist($branch) {
		$sql= DB::table('temp_mst_branchdetails')
						->SELECT('*')
						->WHERE('branch_id', '=', $branch)
						->get();
		return $sql;
	}

	public static function fnInsertBranchOLDMBDetails($fldarray, $valuearray) {
		$db = DB::connection('mysql');
		$result= $insert=DB::table('temp_mst_branchdetails')->insert(
			[$fldarray[0] => $valuearray[0],
			$fldarray[1] => $valuearray[1],
			$fldarray[2] => $valuearray[2],
			$fldarray[3] => $valuearray[3],
			$fldarray[4] => $valuearray[4],
			$fldarray[5] => $valuearray[5],
			$fldarray[6] => $valuearray[6],
			$fldarray[7] => $valuearray[7],
			$fldarray[8] => $valuearray[8],
			$fldarray[9] => $valuearray[9],
			$fldarray[10] => $valuearray[10],
			$fldarray[11] => $valuearray[11]
		
			]
		);
		return $result;
	}

	public static function fnUpdatebranchOLDMBDetails($fldarray, $valuearray, $tempvar) {
		$db = DB::connection('mysql');
		$update=DB::table('temp_mst_branchdetails')
		->where('branch_id', $tempvar)
		->update(
			[$fldarray[0] => $valuearray[0],
			$fldarray[1] => $valuearray[1],
			$fldarray[2] => $valuearray[2],
			$fldarray[3] => $valuearray[3],
			$fldarray[4] => $valuearray[4],
			$fldarray[5] => $valuearray[5],
			$fldarray[6] => $valuearray[6],
			$fldarray[7] => $valuearray[7],
			$fldarray[8] => $valuearray[8],
			$fldarray[9] => $valuearray[9],
			$fldarray[10] => $valuearray[10]
			]
		);
		return $update;
	}

	public static function fnGetCustomerInchargeDetailsMB() {
		$db = DB::connection('otherdb');
		$query= $db->table('mst_cus_inchargedetail as inch')
					->SELECT('*')
					->get();
		return $query;
	}

	public static function fnOldTempInchargeExist($id) {
		$sql= DB::table('temp_mst_cus_inchargedetail')
						->SELECT('*')
						->WHERE('id', '=', $id)
						->get();
		return $sql;
	}

	public static function fnInsertInchargeOLDMBDetails($fldarray, $valuearray) {
		$db = DB::connection('mysql');
		$result= $insert=DB::table('temp_mst_cus_inchargedetail')->insert(
			[$fldarray[0] => $valuearray[0],
			$fldarray[1] => $valuearray[1],
			$fldarray[2] => $valuearray[2],
			$fldarray[3] => $valuearray[3],
			$fldarray[4] => $valuearray[4],
			$fldarray[5] => $valuearray[5],
			$fldarray[6] => $valuearray[6],
			$fldarray[7] => $valuearray[7],
			$fldarray[8] => $valuearray[8],
			$fldarray[9] => $valuearray[9],
			$fldarray[10] => $valuearray[10],
			$fldarray[11] => $valuearray[11],
			$fldarray[12] => $valuearray[12],
			$fldarray[13] => $valuearray[13],
			$fldarray[14] => $valuearray[14]
		
			]
		);
		return $result;
	}

	public static function fnUpdateInchargeOLDMBDetails($fldarray, $valuearray, $tempvar) {
		$db = DB::connection('mysql');
		$update=DB::table('temp_mst_cus_inchargedetail')
		->where('id', $tempvar)
		->update(
			[$fldarray[0] => $valuearray[0],
			$fldarray[1] => $valuearray[1],
			$fldarray[2] => $valuearray[2],
			$fldarray[3] => $valuearray[3],
			$fldarray[4] => $valuearray[4],
			$fldarray[5] => $valuearray[5],
			$fldarray[6] => $valuearray[6],
			$fldarray[7] => $valuearray[7],
			$fldarray[8] => $valuearray[8],
			$fldarray[9] => $valuearray[9],
			$fldarray[10] => $valuearray[10],
			$fldarray[11] => $valuearray[11],
			$fldarray[12] => $valuearray[12],
			$fldarray[13] => $valuearray[13]
			]
		);
		return $update;
	}

	public static function fnGetCustomerClientEmpDetailsMB() {
		$db = DB::connection('otherdb');
		$query= $db->table('clientempteam as Cemp')
					->SELECT('*')
					->get();
		return $query;
	}

	public static function fnOldClientEmpExist($id) {
		$sql= DB::table('temp_clientempteam')
						->SELECT('*')
						->WHERE('id', '=', $id)
						->get();
		return $sql;
	}

	public static function fnInsertClientEmpOLDMBDetails($fldarray, $valuearray) {
	
		$db = DB::connection('mysql');
		$result= $insert=DB::table('temp_clientempteam')->insert(
			[$fldarray[0] => $valuearray[0],
			$fldarray[1] => $valuearray[1],
			$fldarray[2] => $valuearray[2],
			$fldarray[3] => $valuearray[3],
			$fldarray[4] => $valuearray[4],
			$fldarray[5] => $valuearray[5],
			$fldarray[6] => $valuearray[6],
			$fldarray[7] => $valuearray[7],
			$fldarray[8] => $valuearray[8],
			$fldarray[9] => $valuearray[9],
			$fldarray[10] => $valuearray[10],
			$fldarray[11] => $valuearray[11],
			$fldarray[12] => $valuearray[12],
			$fldarray[13] => $valuearray[13]
		
			]
		);
		return $result;
	}

	public static function fnUpdateclientempOLDMBDetails($fldarray, $valuearray, $tempvar) {
		$db = DB::connection('mysql');
		$update=DB::table('temp_clientempteam')
		->where('id', $tempvar)
		->update(
			[$fldarray[0] => $valuearray[0],
			$fldarray[1] => $valuearray[1],
			$fldarray[2] => $valuearray[2],
			$fldarray[3] => $valuearray[3],
			$fldarray[4] => $valuearray[4],
			$fldarray[5] => $valuearray[5],
			$fldarray[6] => $valuearray[6],
			$fldarray[7] => $valuearray[7],
			$fldarray[8] => $valuearray[8],
			$fldarray[9] => $valuearray[9],
			$fldarray[10] => $valuearray[10],
			$fldarray[11] => $valuearray[11],
			$fldarray[12] => $valuearray[12]
			]
		);
		return $update;
	}

	public static function deleteCusbranchincCli($customerId){
		$db = DB::connection('mysql');
		$result = $db->TABLE('temp_mst_customerdetail')
					->WHERE('customer_id','=', $customerId)
					->delete();
		if ($result) {
			$query1 = $db->TABLE('temp_mst_branchdetails')
					->WHERE('customer_id','=', $customerId)
					->delete();
		} if ($query1) {
			$query2 = $db->TABLE('temp_mst_cus_inchargedetail')
					->WHERE('customer_id','=', $customerId)
					->delete();
		} if ($result) {
			$query3 = $db->TABLE('temp_clientempteam')
					->WHERE('cust_id','=', $customerId)
					->delete();
		}
		return $result;
	}
}