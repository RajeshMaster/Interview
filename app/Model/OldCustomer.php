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

}