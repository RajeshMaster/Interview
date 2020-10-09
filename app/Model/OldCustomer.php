<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Session;
use Config;
class OldCustomer extends Model {

	/**  
	*  Employee Details
	*  @author Rajesh 
	*  @param $request
	*  Created At 2020/10/06
	**/
/*	public static function customerchange($request) {
		$db = DB::connection('mysql');
		$update=DB::table('mst_customerdetail')
			->where('id', $request->id)
			->update(
				['update_date' => date('Y-m-dh:i:s'),
				 'delflg' => $request->useval]
		);
		return $update;
	}*/

	/**  
	*  Employee Details
	*  @author Rajesh 
	*  @param $request
	*  Created At 2020/10/06
	**/
/*	public static function CustomerDetails($request) {
		$db = DB::connection('mysql');
		$query = $db->TABLE($db->raw("(select *,
				(SELECT count(clientempteam.cust_id) AS cnt FROM emp_mstemployees 
								LEFT JOIN clientempteam ON emp_mstemployees.Emp_ID=clientempteam.emp_id
								where clientempteam.status = '1' AND emp_mstemployees.resign_id = '0' AND clientempteam.cust_id = mst_customerdetail.customer_id) 
				CNT 
				from mst_customerdetail) as tbl1"));
	  
				if ($request->filterval == 1) {
					//print_r($request->filterval);exit();
					$query = $query->where(function($joincont) use ($request) {
									  $joincont->where('CNT', '>', 0);
									  $joincont->where('delflg', '=', 0);
									  });
				} else if ($request->filterval == 2) {
					$query = $query->where(function($joincont) use ($request) {
									  $joincont->where('CNT', '=', 0);
									  $joincont->where('delflg', '=', 0);
									  });
				} else {
					$query = $query->where(function($joincont) use ($request) {
									  $joincont->where('delflg', '=', 1);
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
								   // ->orWhere('customer_address', 'LIKE', '%' . $request->address . '%');
									});
				}
				if (!empty($request->address)) {
					$query = $query->where(function($joincont) use ($request) {
									$joincont->where('customer_address', 'LIKE', '%' . $request->address . '%');
								   // ->orWhere('customer_address', 'LIKE', '%' . $request->address . '%');
									});
				}
				if (!empty($request->name && $request->address)) {
					$query = $query->where(function($joincont) use ($request) {
									$joincont->where('customer_name', 'LIKE', '%' . $request->name . '%')
									->orWhere('customer_address', 'LIKE', '%' . $request->address . '%');
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
				// $query = $query->tosql();
						// dd($query);

											// ->tosql()
											// dd($query);
			return $query;
	}*/

	public static function customerchange($request) {
		$db = DB::connection('mysql_invoice');
		$update=DB::table('mst_customerdetail')
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
		$db = DB::connection('mysql_invoice');
		$query = $db->TABLE($db->raw("(select *,
				(SELECT count(clientempteam.cust_id) AS cnt FROM emp_mstemployees 
								LEFT JOIN clientempteam ON emp_mstemployees.Emp_ID=clientempteam.emp_id
								where clientempteam.status = '1' AND emp_mstemployees.resign_id = '0' AND clientempteam.cust_id = mst_customerdetail.customer_id) 
				CNT 
				from mst_customerdetail) as tbl1"));
	  
				if ($request->filterval == 1) {
					//print_r($request->filterval);exit();
					$query = $query->where(function($joincont) use ($request) {
									  $joincont->where('CNT', '>', 0);
									  $joincont->where('delflg', '=', 0);
									  });
				} else if ($request->filterval == 2) {
					$query = $query->where(function($joincont) use ($request) {
									  $joincont->where('CNT', '=', 0);
									  $joincont->where('delflg', '=', 0);
									  });
				} else {
					$query = $query->where(function($joincont) use ($request) {
									  $joincont->where('delflg', '=', 1);
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
								   // ->orWhere('customer_address', 'LIKE', '%' . $request->address . '%');
									});
				}
				if (!empty($request->address)) {
					$query = $query->where(function($joincont) use ($request) {
									$joincont->where('customer_address', 'LIKE', '%' . $request->address . '%');
								   // ->orWhere('customer_address', 'LIKE', '%' . $request->address . '%');
									});
				}
				if (!empty($request->name && $request->address)) {
					$query = $query->where(function($joincont) use ($request) {
									$joincont->where('customer_name', 'LIKE', '%' . $request->name . '%')
									->orWhere('customer_address', 'LIKE', '%' . $request->address . '%');
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
											// ->tosql()
											// dd($query);
			return $query;
	}


	public static function getSelectedMember($id) {
		$db = DB::connection('mysql_invoice');
		$query= $db->table('mst_branchdetails')
					->SELECT('mst_branchdetails.*')
					->leftJoin('mst_customerdetail', 'mst_customerdetail.customer_id', '=', 'mst_branchdetails.customer_id')
					->where('mst_customerdetail.customer_id','=', $id)
					->ORDERBY('mst_branchdetails.branch_id','ASC')
					->get();
		return $query;
	}


	public static function getbranchdetails($request,$branchid) { 
		$db =DB::connection('mysql_invoice');
		$tbl_name = "mst_branchdetails";
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
		$db = DB::connection('mysql_invoice');
		$query= $db->table('mst_cus_inchargedetail')
					->SELECT('mst_cus_inchargedetail.*','sysdesignationtypes.DesignationNM')
					->leftJoin('sysdesignationtypes', 'sysdesignationtypes.DesignationCD', '=', 'mst_cus_inchargedetail.designation')
					->where('mst_cus_inchargedetail.branch_name','=', $id)
					->get();
		return $query;
	}

	public static function getbdetails($id) { 
		$db =DB::connection('mysql_invoice');
		$tbl_name = "mst_branchdetails";
		$query= $db->table($tbl_name)
					->select('mst_branchdetails.*')
					->where('customer_id','=', $id)
					->ORDERBY('branch_id','ASC')
					->get();
		return $query;
	}

	public static function selectByIdclient($id) { 
		$db =DB::connection('mysql_invoice');
		$sql="SELECT * FROM  mst_customerdetail LEFT JOIN clientempteam ON clientempteam.cust_id = mst_customerdetail.customer_id 
					AND LEFT(clientempteam.emp_id, 3) NOT LIKE '%MBC%'
					where clientempteam.cust_id = '".$id."' ORDER BY clientempteam.start_date DESC";
		$cards = $db->select($sql);
		return $cards;
	}

	public static function selectByIdchangeclient($id) { 
		$db =DB::connection('mysql_invoice');
		$sql="SELECT * FROM  mst_customerdetail LEFT JOIN clientempteam ON clientempteam.cust_id = mst_customerdetail.customer_id 
					AND LEFT(clientempteam.emp_id, 3) NOT LIKE '%MBC%'
					where clientempteam.cust_id = '".$id."' ORDER BY clientempteam.end_date DESC";
		$cards = $db->select($sql);
		return $cards;
	}

	 public static function fnGetOnsiteHistory($empid,$request) {
		$db = DB::connection('mysql_invoice');
		$query = $db->table('emp_mstemployees AS emp')->SELECT('emp.Emp_ID',
								'emp.FirstName',
								'emp.LastName',
								'emp.Title',
								'cli.cust_id',
								'cli.status',
								'cli.start_date',
								'cli.end_date',
								'cus.customer_name')
					->JOIN('clientempteam AS cli','emp.Emp_ID','=','cli.emp_id')
					->JOIN('mst_customerdetail AS cus','cli.cust_id','=','cus.customer_id')
					->where('emp.Emp_ID', '=', $empid)
					->where('emp.delFlg',0)
					->where('cli.delFLg',0)	
					->where('cus.delflg',0)
					->get();
					//->paginate($request->plimit);
		return $query;
	}

	public static function getcustomerdetails($request) {
        $db =DB::connection('mysql_invoice');
        $tbl_name = "mst_customerdetail";
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
		$db =DB::connection('mysql_invoice');
        $tbl_name = "mst_cus_inchargedetail";
        $query= $db->table($tbl_name)
                   ->select('mst_cus_inchargedetail.*')
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
        $db =DB::connection('mysql_invoice');
        $tbl_name = "mst_branchdetails";
        $query= $db->table($tbl_name)
                   ->select('mst_branchdetails.*')
                   ->where('branch_id','=', $branch_id)
                   ->ORDERBY('branch_id','ASC')
                   ->get();
        return $query;
    }
}