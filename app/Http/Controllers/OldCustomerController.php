<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Model\OldCustomer;
use App\Model\Common;
use Redirect;
use Session;
use Input;
use Config;
use Carbon;
use File;
use Storage;
use View;
use Illuminate\Support\Facades\Validator;
use DB;


class OldCustomerController extends Controller {
	public function index(Request $request)
	{
		$cstviews=array();
		$branchNames=array();
		$disabledactive=" ";
		$disabledinactive=" ";
		$disabledusenotuse=" ";
		//Setting page limit
		if ($request->plimit=="") {
			$request->plimit = 50;
		}

		//Filter process
		if (!isset($request->filterval) || $request->filterval == "") {
			$request->filterval = 1;
		}
		if ($request->filterval == 1) {
			$disabledactive="disabled fb";
		} else if($request->filterval == 2) {
			$disabledinactive="disabled fb";
		}  else if($request->filterval == 3) {
			$disabledusenotuse="disabled fb";
		}

		//Sorting process
		$customersortarray = array("customer_id"=>trans('messages.lbl_CustId'),
					"customer_name"=>trans('messages.lbl_name'),
					"customer_address"=>trans('messages.lbl_address')
					);

		//SORT POSITION
		if (!empty($request->singlesearchtxt) || $request->searchmethod == 2) {
		  $sortMargin = "margin-right:260px;";
		} else {
		  $sortMargin = "margin-right:0px;";
		}
		if ($request->cussort == "") {
			$request->cussort = "customer_id";
			$request->sortOrder = "DESC";
		}
		if($request->oldfilter == $request->filterval){
			if (empty($request->sortOrder)) {
				$request->sortOrder = "DESC";
			}
			if ($request->sortOrder == "asc") {  
				$request->sortstyle="sort_asc";
			} else {  
				$request->sortstyle="sort_desc";
			}
		} else {
			if (empty($request->sortOrder)) {
				$request->sortOrder = "DESC";
			}
			if ($request->sortOrder == "asc") {  
				$request->sortstyle="sort_asc";
			} else {  
				$request->sortstyle="sort_desc";
			}
		}

		$src = "";
		if ($request->UseNotUseVal != "") {
			$customerchange = OldCustomer::customerchange($request);
			if($customerchange == 1 && $request->useval == 0) {
				Session::flash('success', 'Old Customer Use Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else if($customerchange == 1 && $request->useval == 1) {
				Session::flash('success', 'Old Customer Not Use Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('type', 'Old Customer UseNotUse Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		}

		$customerdetailview = OldCustomer::CustomerDetails($request);
		$i = 0;
		foreach($customerdetailview as $key=>$cstview) {
			$cstviews[$i]['customer_name'] = $cstview->customer_name;
			$cstviews[$i]['contract'] = $cstview->contract;
			$cstviews[$i]['customer_contact_no'] = $cstview->customer_contact_no;
			$cstviews[$i]['customer_fax_no'] = $cstview->customer_fax_no;
			$cstviews[$i]['customer_website'] = $cstview->customer_website;
			$cstviews[$i]['customer_address'] = $cstview->customer_address;
			$cstviews[$i]['romaji'] = $cstview->romaji;
			$cstviews[$i]['customer_id'] = $cstview->customer_id;
			$cstviews[$i]['delflg'] = $cstview->delflg;
			$cstviews[$i]['id'] = $cstview->id;
			$branchNames = OldCustomer::getSelectedMember($cstviews[$i]['customer_id']);
			$j = 0;
			foreach($branchNames as $key=>$rec) { 
				$cstviews[$i]['BranchName'][$j]=$rec->branch_name;
				$j++;
			}
			$i++;
		}

		return View('oldcustomer.index',['request' => $request,
									 'cstviews' => $cstviews,
									 'customersortarray' => $customersortarray,
									 'sortMargin' => $sortMargin,
									 'detailview' => $customerdetailview,
									 'src' => $src,
									 'disabledactive' => $disabledactive,
									 'disabledinactive' => $disabledinactive,
									 'disabledusenotuse' => $disabledusenotuse]);
	}

	function importpopup(Request $request){
		//For Get The DataBase List
		$getOldDbDetails = OldCustomer::fnOldDbDetails();
		return view('oldcustomer.importpopup',['getOldDbDetails'=> $getOldDbDetails,
										'request' => $request]);
	}

	public function view(Request $request) {
		$inchargeview=array();
		$branchview=array();
		$currentview=array();
		$currentempview=array();
		$emp_type=array();
		$emp_type1=array();
		if(Session::get('custid') !="" && Session::get('id') !=""){
			$request->custid = Session::get('custid');
			$request->id = Session::get('id');
		}
		if(!isset($request->id)){
			return Redirect::to('OldCustomer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$customer_id = substr($request->custid, 3,5);
		$cus = $customer_id+1;
		$cus = str_pad($cus,5,"0",STR_PAD_LEFT);
		//print_r($cus);exit();
		if(isset($_REQUEST['hid_branch_id']) != "") {
			$branchid = "CST" . $cus;
		} else {
			$branchid = " ";
		}

		$getbranchdetails = OldCustomer::getbranchdetails($request,$branchid);
		$id = $request->custid;
		$getinchargedetails = OldCustomer::getinchargedetails($id);
		$i=0;
		foreach($getinchargedetails as $key=>$inchview) {
			$inchargeview[$i]['incharge_name'] = $inchview->incharge_name;
			$inchargeview[$i]['incharge_contact_no'] = $inchview->incharge_contact_no;
			$inchargeview[$i]['incharge_email_id'] = $inchview->incharge_email_id;
			$inchargeview[$i]['id'] = $inchview->id;
			$inchargeview[$i]['DesignationNM'] = $inchview->DesignationNM;
			$inchargeview[$i]['incharge_name_romaji'] = $inchview->incharge_name_romaji;
			$i++;
		}

		$getbranchdetails=OldCustomer::getbdetails($id);

		$i=0;
		foreach($getbranchdetails as $key=>$bview) {
			$branchview[$i]['branch_name'] = $bview->branch_name;
			$branchview[$i]['branch_contact_no'] = $bview->branch_contact_no;
			$branchview[$i]['branch_fax_no'] = $bview->branch_fax_no;
			$branchview[$i]['id'] = $bview->branch_id;
			$branchview[$i]['branch_address'] = $bview->branch_address;
			$branchview[$i]['customer_id'] = $bview->customer_id;
			//$branchview[$i]['romaji'] = $bview->romaji;
			$i++;
		}

		$currentemployeedetails = OldCustomer::selectByIdclient($id);

		$i=0;

		foreach($currentemployeedetails as $key=>$cempview) {
			$currentview[$i]['customer_id'] = $cempview->customer_id;
			$currentview[$i]['customer_name'] = $cempview->customer_name;
			$currentview[$i]['emp_id'] = $cempview->emp_id;
			$currentview[$i]['status'] = $cempview->status;
			$currentview[$i]['start_date'] = $cempview->start_date;
			$currentview[$i]['end_date'] = $cempview->end_date;
			$currentview[$i]['update_by'] = $cempview->update_by;
			$viewname=Common::fnGetEmployeeInfo($currentview[$i]['emp_id']); 
			foreach($viewname as $key=>$rec) { 
				$currentview[$i]['LastName']=$rec->LastName;
				$currentview[$i]['FirstName']=$rec->FirstName;
			}
			if($cempview->end_date=="0000-00-00") {
				$currentview[$i]['end_date'] ="";
			}
			$cusexpdetails = Common::getYrMonCountBtwnDates($currentview[$i]['start_date'],$currentview[$i]['end_date']);
			if ($cusexpdetails['year'].".".$cusexpdetails['month'] == 0.0) {
				$currentview[$i]['experience'] = "-";
			} else {
				$currentview[$i]['experience'] = $cusexpdetails['year'].".".Common::fnAddZeroSubstring($cusexpdetails['month']);
			}
			$i++;
		}

		$currentempdetails = OldCustomer::selectByIdchangeclient($id);

		$i=0;
		foreach($currentempdetails as $key=>$cemployeeview) {
			$currentempview[$i]['customer_id'] = $cemployeeview->customer_id;
			$currentempview[$i]['customer_name'] = $cemployeeview->customer_name;
			$currentempview[$i]['emp_id'] = $cemployeeview->emp_id;
			$currentempview[$i]['status'] = $cemployeeview->status;
			$currentempview[$i]['start_date'] = $cemployeeview->start_date;
			$currentempview[$i]['end_date'] = $cemployeeview->end_date;
			$currentempview[$i]['update_by'] = $cemployeeview->update_by;
			$viewname = Common::fnGetEmployeeInfo($currentempview[$i]['emp_id']);
			foreach($viewname as $key=>$rec) { 
				$currentempview[$i]['LastName']=$rec->LastName;
				$currentempview[$i]['FirstName']=$rec->FirstName;
			}
			if($cemployeeview->end_date=="0000-00-00") {
				$currentempview[$i]['end_date'] ="";
			}
			$cusexpdetails = Common::getYrMonCountBtwnDates($currentempview[$i]['start_date'],$currentempview[$i]['end_date']);
			if ($cusexpdetails['year'].".".$cusexpdetails['month'] == 0.0) {
				$currentempview[$i]['experience'] = "-";
			} else {
				$currentempview[$i]['experience'] = $cusexpdetails['year'].".".Common::fnAddZeroSubstring($cusexpdetails['month']);
			}
			$i++;
		}

		$getdetails=OldCustomer::getcustomerdetails($request);
		return view('oldcustomer.view',['request' => $request,
										'getdetails' => $getdetails,
										'inchargeview' => $inchargeview,
										'branchview' => $branchview,
										'currentview' => $currentview,
										'currentempview' =>$currentempview,
										'getbranchdetails' =>$getbranchdetails
										]);
	}

	public function copyCustomer(Request $request) {
		Session::put('Allbranch_Idset',$request->Allbranch_Idset);
		$allBrcancharray = explode(',', $request->Allbranch_Idset);
		Session::put('allBrcancharray',$allBrcancharray);
		Session::put('OldCustomerIdselected',$request->txt_custID);
		if ($request->txt_custnamejp == "") {
			return Redirect::to('OldCustomer/index?mainmenu=menu_customer&time='.date('YmdHis'));
		}
		$getKenname=Common::getKendetails();
		return view('oldcustomer.customercopy',[
									'request'=> $request,
									'getKenname' => $getKenname
							]);

	}

	function OldInchargeSelect(Request $request) {
		$customerIdSel = session::get('OldCustomerIdselected');
		$getAllInchargeDtl = OldCustomer::getallIncharge($customerIdSel);
		return view('oldcustomer.InchargeSelectPopup',[
													'request' => $request,
													'getAllInchargeDtl' => $getAllInchargeDtl
													]);

	}

	public function CustomerRegValidation(Request $request){
		$commonrules=array();
		$commonrules1=array();
		$commonrules = array(
			'txt_custnamejp' => 'required',
			'txt_kananame'=>'required',
			'txt_repname' => 'required',
			'txt_custagreement' => 'required|date_format:"Y-m-d"',
			'txt_branch_name' => 'required',
			'txt_mobilenumber' => 'required',
			'txt_fax' => 'required',
			'txt_url' => 'required',
			'txt_postal' => 'required|min:8',
			'kenmei' => 'required',
			'txt_shimei' => 'required',
			'txt_streetaddress' => 'required',
		);

		if($request->flg !=1) {
			$commonrules1 = array(
				'txt_incharge_name' => 'required',
				'txt_mailid' => 'required',
			);
		}

		$rules = $commonrules+$commonrules1;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);exit;
        } else {
            $success = true;
            echo json_encode($success);
        }
	}

	public function addprocess(Request $request) {
		$custmaxid = OldCustomer::getmaxid();
		if($custmaxid == "") {
			$cus3 = "CST00001";
		} else {
			$aaa=$custmaxid;
			$customer = substr($aaa, 3,5);
			$cus1 = (int)$customer + 100;
			$cus2 = str_pad($cus1,5,"0",STR_PAD_LEFT);
			$cus3 = "CST" . $cus2;
		}
		if($_REQUEST['hid_branch_id'] == "") {
			$customer = substr($cus3, 3,5);
			$cus4 = $customer+1;
			$cus5 = str_pad($cus4,5,"0",STR_PAD_LEFT);
			$branchid = "CST" . $cus5;
		} else {
			$branchid = $_REQUEST['hid_branch_id'];
		}
		$rest1 = substr($request->txt_mailid, -1);
		if ($rest1 != ";") {
			$request->txt_mailid = $request->txt_mailid . ";";
		}
		$rest2 = substr($request->txt_incharge_name, -1);
		if ($rest2 != ";") {
			$request->txt_incharge_name = $request->txt_incharge_name . ";";
		}
		if($request->txt_mailid != ""){
			$rest = substr($request->txt_mailid, 0, -1);
			$restname = substr($request->txt_incharge_name, 0, -1);
		}
		$inchArray = explode(";", $rest);
		$inchNameArray = explode(";", $restname);
		$insert = OldCustomer::insertRec($request,$cus3);
		$getmaxid = OldCustomer::fetchmaxid($request);
		Session::put('customerMax',$getmaxid);
		Session::put('customerIdSel',$cus3);
		$insert= OldCustomer::insertbranchrec($request,$branchid,$cus3);
		foreach ($inchArray as $key => $value) {
			$mail = $value;
			$name = $inchNameArray[$key];
			$insert=OldCustomer::insertincharge($name,$mail,$branchid,$cus3);
		}
		if($insert) {
			Session::flash('success', 'Inserted Sucessfully!'); 
			Session::flash('type', 'alert-success');

			if (session::get('Allbranch_Idset') != "" ) {
				Session::flash('custid', $cus3 );
				return Redirect::to('OldCustomer/copyBranch?mainmenu=menu_oldcustomer&time='.date('YmdHis'));
			} else {
				$oldCustomerId = Session::get('OldCustomerIdselected');
				$deleteCusbranchincCli = OldCustomer::deleteCusbranchincCli($oldCustomerId);
				Session::flash('id', $getmaxid );
				Session::flash('custid', $cus3 );
				return Redirect::to('Customer/index?mainmenu=menu_oldcustomer&time='.date('YmdHis'));
			}

		} else {
			Session::flash('type', 'Inserted Unsucessfully!'); 
			Session::flash('type', 'alert-danger'); 
			return Redirect::to('Customer/index?mainmenu=menu_oldcustomer&time='.date('YmdHis'));

		}
	}

	function copyBranch(Request $request) {
  		if (session::get('custid') == "") {
  			$oldCustomerId = Session::get('OldCustomerIdselected');
  			$getmaxid = Session::get('customerMax');
  			$cus3 = Session::get('customerIdSel');
			$deleteCusbranchincCli = OldCustomer::deleteCusbranchincCli($oldCustomerId);
			Session::flash('id', $getmaxid );
			Session::flash('custid', $cus3 );
			return Redirect::to('Customer/index?mainmenu=menu_customer&time='.date('YmdHis'));
  		}
  		$allbranch = session::get('Allbranch_Idset');
  		$allBrcancharray = session::get('allBrcancharray');
  		$customerIdSel = session::get('customerIdSel');
  		// print_r($customerIdSel);echo "<br/>";
  		$remaningallBrcancharray ="";
  		$nowbranch ="";
  		foreach ($allBrcancharray as $key => $value) {
  			if ($key == 0) {
  				$nowbranch = $value;
  			}
  			if ($key == 1) {
  				$remaningallBrcancharray = $value;
  			}  elseif ($key > 1) {
				$remaningallBrcancharray = $remaningallBrcancharray.','.$value;
			}
  		}
		Session::put('Allbranch_Idset',$remaningallBrcancharray);
		$allBrcancharray = explode(',', $remaningallBrcancharray);
		Session::put('allBrcancharray',$allBrcancharray);
		$getbranchDetails = OldCustomer::getonebranch($nowbranch);
		$getKenname=Common::getKendetails();
		return view('oldcustomer.Branchaddcopy',[
									'request'=> $request,
									'getKenname' => $getKenname,
									'getbranchDetails' => $getbranchDetails
								]);

	}

	public function BranchRegValidation(Request $request){
  		$commonrules1 = array();
  		$commonrules = array(
			'txt_branch_name' => 'required',
			'txt_mobilenumber' => 'required',
			'txt_fax' => 'required',
			'txt_postal' => 'required|min:7|max:8',
			'kenmei' => 'required',
			'txt_shimei' => 'required',
			'txt_streetaddress' => 'required',
		);
		if($request->flg!=1){
			$commonrules1 = array(
				'txt_incharge_name' => 'required',
				'txt_mailid' => 'required',
			);
		}
		$rules = $commonrules+$commonrules1;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);exit;
        } else {
            $success = true;
            echo json_encode($success);
        }
  	}

  	function copyBranchProcess(Request $request) {
		if(Session::get('customerIdSel') !=""){
			$request->custid = Session::get('customerIdSel');
		}
      	$maxbranchid = OldCustomer::branchadd($request);

		if(empty($maxbranchid)) {
			$aaa=$request->custid;
			$customer = substr($aaa, 3,5);
			$cus1 = (int)$customer + 1;
			$cus2 = str_pad($cus1,5,"0",STR_PAD_LEFT);
			$cus3 = "CST" . $cus2;
		} else {
			$aaa=$maxbranchid[0];
			$customer = substr($aaa, 3,5);
			$cus1 = (int)$customer + 1;
			$cus2 = str_pad($cus1,5,"0",STR_PAD_LEFT);
			$cus3 = "CST" . $cus2;
		}
		$rest1 = substr($request->txt_mailid, -1);
		if ($rest1 != ";") {
			$request->txt_mailid = $request->txt_mailid . ";";
		}
		$rest2 = substr($request->txt_incharge_name, -1);
		if ($rest2 != ";") {
			$request->txt_incharge_name = $request->txt_incharge_name . ";";
		}
		if($request->txt_mailid != ""){
			$rest = substr($request->txt_mailid, 0, -1);
			$restname = substr($request->txt_incharge_name, 0, -1);
		}
		$inchArray = explode(";", $rest);
		$inchNameArray = explode(";", $restname);
		$custid=$request->custid;
		$insert= OldCustomer::insertbranchrec($request,$cus3,$custid);
		$getmaxid = OldCustomer::fetchmaxid($request);
		foreach ($inchArray as $key => $value) {
			$mail = $value;
			$name = $inchNameArray[$key];
			$insert=OldCustomer::insertincharge($name,$mail,$cus3,$custid);
		}
		$allBrcancharray = explode(',', session::get('Allbranch_Idset'));
		if($insert) {
			if (isset($allBrcancharray[0]) && $allBrcancharray[0] != "") {
				Session::flash('custid', $cus3);
				return Redirect::to('OldCustomer/copyBranch?mainmenu=menu_oldcustomer&time='.date('YmdHis'));
			} else {
				$oldCustomerId = Session::get('OldCustomerIdselected');
				$deleteCusbranchincCli = OldCustomer::deleteCusbranchincCli($oldCustomerId);
				Session::flash('id', $getmaxid );
				Session::flash('custid', $custid );
				return Redirect::to('Customer/index?mainmenu=menu_customer&time='.date('YmdHis'));
			}
		} else {
			Session::flash('type', 'Inserted Unsucessfully!'); 
			Session::flash('type', 'alert-danger'); 
			return Redirect::to('Customer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		
	}

	public function addcopycancel(Request $request) {
		$oldCustomerId = Session::get('OldCustomerIdselected');
		$deleteCusbranchincCli = OldCustomer::deleteCusbranchincCli($oldCustomerId);
		Session::flash('id', $request->id );
		Session::flash('custid', $request->custid );
		return Redirect::to('Customer/CustomerView?mainmenu=menu_customer&time='.date('YmdHis'));
  	}

  	public function getEmailExistsManyFields(Request $request) {
		$rest1 = substr($request->mailId, -1);
		if ($rest1 != ";") {
			$request->mailId = $request->mailId . ";";
		}
		$rest = substr($request->mailId, 0, -1);  // returns "abcde"
		$restarry = explode(';', $rest);
		for ($i=0; $i < count($restarry) ; $i++) {
			$inchargeMailExist = OldCustomer::fnGetEmailExistsCheckmanyField($restarry[$i]);
			$countEmail = count($inchargeMailExist);
			if ($countEmail == 0) {
				$whchMail = 0;
			} else {
				$whchMail = $i+1;
				break;
			}
		}
		print_r($whchMail);exit;
		// $inchargeMailExist = OldCustomer::fnGetEmailExistsCheck($request);
		// $countEmail = count($inchargeMailExist);
  	}

  	public function importprocess(Request $request) {
  		print_r($request->all()); exit();
  		$employee_count = OldCustomer::fnGetCustomerCount();
		$getConnectionQuery = OldCustomer::fnGetConnectionQuery($request);

		$dbName = $getConnectionQuery[0]->DBName;
		$dbUser = $getConnectionQuery[0]->UserName;
		$dbPass = $getConnectionQuery[0]->Password;

		Config::set('database.connections.otherdb.database', $dbName);
		Config::set('database.connections.otherdb.username', $dbUser);
		Config::set('database.connections.otherdb.password', $dbPass);
		try {
			$db = DB::connection('otherdb');
			$db->getPdo();

			if($db->getDatabaseName()){
				$oldUserQuery = OldCustomer::fnGetCustomerDetailsMB();
				$g_val = count($oldUserQuery);
				$getOldUserRecordsAsArray = array();
				$j = 0;
				foreach ($oldUserQuery as $key => $value1) {
					$getOldUserRecordsAsArray[$j]['customer_id'] = $value1->customer_id;
					$getOldUserRecordsAsArray[$j]['customer_name'] = $value1->customer_name;
					$getOldUserRecordsAsArray[$j]['contract'] = $value1->contract;
					$getOldUserRecordsAsArray[$j]['customer_contact_no'] = $value1->customer_contact_no;
					$getOldUserRecordsAsArray[$j]['customer_email_id'] = $value1->customer_email_id;
					$getOldUserRecordsAsArray[$j]['customer_fax_no'] = $value1->customer_fax_no;
					$getOldUserRecordsAsArray[$j]['customer_website'] = $value1->customer_website;
					$getOldUserRecordsAsArray[$j]['customer_address'] = $value1->customer_address;
					$getOldUserRecordsAsArray[$j]['cover_letter'] = $value1->cover_letter;
					$getOldUserRecordsAsArray[$j]['create_date'] = $value1->create_date;
					$getOldUserRecordsAsArray[$j]['create_by'] = $value1->create_by;
					$getOldUserRecordsAsArray[$j]['update_date'] =	$value1->update_date;
					$getOldUserRecordsAsArray[$j]['update_by'] =	$value1->update_by;
					$getOldUserRecordsAsArray[$j]['delflg'] =	$value1->delflg;
					$getOldUserRecordsAsArray[$j]['romaji'] = $value1->romaji;
					$getOldUserRecordsAsArray[$j]['nickname'] =	$value1->nickname;
					$getOldUserRecordsAsArray[$j]['move_flg'] =	$value1->move_flg;
					$getOldUserRecordsAsArray[$j]['emp_active'] =	$value1->emp_active;
					$j++;
				}
				if ($getOldUserRecordsAsArray != "") {
					for ($i = 0; $i < count($getOldUserRecordsAsArray); $i++) {
						$exist = OldCustomer::fnOldTempstaffExist($getOldUserRecordsAsArray[$i]["customer_id"]);
						$existCount = count($exist);
						if ($existCount == 0) {
							$fldarray = "";
							$valuearray = "";
							foreach ($getOldUserRecordsAsArray[$i] AS $key => $value) {
								$fldarray[]= $key;
								$valuearray[]= $value;
							}
							$insertOldUserQuery = OldCustomer::fnInsertOLDMBDetails($fldarray,$valuearray);
						} else {
							$tempvar=$getOldUserRecordsAsArray[$i]['customer_id'];
							$tempTM=$getOldUserRecordsAsArray[$i]['customer_id'];
							$column_name_value = "";
							$condition = "";
							$fldarray = "";
							$valuearray = "";
							foreach ($getOldUserRecordsAsArray[$i] AS $key => $value) {
								if ($key != "customer_id") {
									$fldarray[]= $key;
									$valuearray[]= $value;
								}
							}
							$condition = "customer_id = '" . $tempvar. "'";
							$column_name_value = mb_substr($column_name_value, 0, mb_strlen($column_name_value) - 1);
							$updateOldUserQuery = OldCustomer::fnUpdateOLDMBDetails($fldarray,$valuearray,$tempvar);
							Session::flash('success', 'Imported Sucessfully!'); 
							Session::flash('type', 'alert-success'); 
						}
					}
					// Branch Details INsert
					$oldbranchUserQuery = OldCustomer::fnGetCustomerBranchDetailsMB();
					$g_val = count($oldbranchUserQuery);
					$oldbranchUserQueryRecordsAsArray = array();
					$K = 0;
					foreach ($oldbranchUserQuery as $key2 => $value2) {
						$oldbranchUserQueryRecordsAsArray[$K]['customer_id'] = $value2->customer_id;
						$oldbranchUserQueryRecordsAsArray[$K]['branch_id'] = $value2->branch_id;
						$oldbranchUserQueryRecordsAsArray[$K]['branch_name'] = $value2->branch_name;
						$oldbranchUserQueryRecordsAsArray[$K]['branch_contact_no'] = $value2->branch_contact_no;
						$oldbranchUserQueryRecordsAsArray[$K]['branch_email_id'] = $value2->branch_email_id;
						$oldbranchUserQueryRecordsAsArray[$K]['branch_fax_no'] = $value2->branch_fax_no;
						$oldbranchUserQueryRecordsAsArray[$K]['branch_address'] = $value2->branch_address;
						$oldbranchUserQueryRecordsAsArray[$K]['create_date'] = $value2->create_date;
						$oldbranchUserQueryRecordsAsArray[$K]['create_by'] = $value2->create_by;
						$oldbranchUserQueryRecordsAsArray[$K]['update_date'] = $value2->update_date;
						$oldbranchUserQueryRecordsAsArray[$K]['update_by'] = $value2->update_by;
						$oldbranchUserQueryRecordsAsArray[$K]['delflg'] =	$value2->delflg;
						$K++;
					}
					if ($oldbranchUserQueryRecordsAsArray != "") {
						for ($l = 0; $l < count($oldbranchUserQueryRecordsAsArray); $l++) {
							$exist = OldCustomer::fnOldTempbranchExist($oldbranchUserQueryRecordsAsArray[$l]["branch_id"]);
							$existCount = count($exist);

							if ($existCount == 0) {
								$fldarray = "";
								$valuearray = "";
								foreach ($oldbranchUserQueryRecordsAsArray[$l] AS $key => $value) {
									$fldarray[]= $key;
									$valuearray[]= $value;
								}

								$insertOldbranchQuery = OldCustomer::fnInsertBranchOLDMBDetails($fldarray,$valuearray);

							} else {
								$tempvar=$oldbranchUserQueryRecordsAsArray[$l]['branch_id'];
								$fldarray = "";
								$valuearray = "";

								foreach ($oldbranchUserQueryRecordsAsArray[$l] AS $key => $value) {
									if ($key != "branch_id") {
										$fldarray[]= $key;
										$valuearray[]= $value;
									}
								}

								$updateOldUserQuery = OldCustomer::fnUpdatebranchOLDMBDetails($fldarray,$valuearray,$tempvar);
							}
						}
						
					} else {
						Session::flash('success', 'Branch Data Does NOt exist'); 
						Session::flash('type', 'alert-danger'); 
						return Redirect::to('OldCustomer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
					}

					// Incharge Details Insert
					$oldInchargeUserQuery = OldCustomer::fnGetCustomerInchargeDetailsMB();
					$g_val = count($oldInchargeUserQuery);
					$oldinchargeQueryRecordsAsArray = array();
					$M = 0;
					foreach ($oldInchargeUserQuery as $key3 => $value3) {
						$oldinchargeQueryRecordsAsArray[$M]['id'] = $value3->id;
						$oldinchargeQueryRecordsAsArray[$M]['customer_id'] = $value3->customer_id;
						$oldinchargeQueryRecordsAsArray[$M]['incharge_name'] = $value3->incharge_name;
						$oldinchargeQueryRecordsAsArray[$M]['incharge_name_romaji'] = $value3->incharge_name_romaji;
						$oldinchargeQueryRecordsAsArray[$M]['branch_name'] = $value3->branch_name;
						$oldinchargeQueryRecordsAsArray[$M]['incharge_contact_no'] = $value3->incharge_contact_no;
						$oldinchargeQueryRecordsAsArray[$M]['incharge_email_id'] = $value3->incharge_email_id;
						$oldinchargeQueryRecordsAsArray[$M]['password'] = $value3->password;
						$oldinchargeQueryRecordsAsArray[$M]['confirmpassword'] = $value3->confirmpassword;
						$oldinchargeQueryRecordsAsArray[$M]['create_date'] = $value3->create_date;
						$oldinchargeQueryRecordsAsArray[$M]['create_by'] = $value3->create_by;
						$oldinchargeQueryRecordsAsArray[$M]['update_date'] = $value3->update_date;
						$oldinchargeQueryRecordsAsArray[$M]['update_by'] = $value3->update_by;
						$oldinchargeQueryRecordsAsArray[$M]['delflg'] = $value3->delflg;
						$oldinchargeQueryRecordsAsArray[$M]['designation'] =	$value3->designation;
						$M++;
					}

					if ($oldinchargeQueryRecordsAsArray != "") {
						for ($N = 0; $N < count($oldinchargeQueryRecordsAsArray); $N++) {
							$exist = OldCustomer::fnOldTempInchargeExist($oldinchargeQueryRecordsAsArray[$N]["id"]);
							$existCount = count($exist);
							if ($existCount == 0) {
								$fldarray = "";
								$valuearray = "";
								foreach ($oldinchargeQueryRecordsAsArray[$N] AS $key => $value) {
									$fldarray[]= $key;
									$valuearray[]= $value;
								}
								$insertOldbranchQuery = OldCustomer::fnInsertInchargeOLDMBDetails($fldarray,$valuearray);
							} else {
								$tempvar=$oldinchargeQueryRecordsAsArray[$N]['id'];
								$fldarray = "";
								$valuearray = "";

								foreach ($oldinchargeQueryRecordsAsArray[$N] AS $key => $value) {
									if ($key != "id") {
										$fldarray[]= $key;
										$valuearray[]= $value;
									}
								}
								$updateOldUserQuery = OldCustomer::fnUpdateInchargeOLDMBDetails($fldarray,$valuearray,$tempvar);
							}
						}
					} else {
						Session::flash('success', 'Incharge Data Does NOt exist'); 
						Session::flash('type', 'alert-danger'); 
						return Redirect::to('OldCustomer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
					}

					// Clientempteam Details Insert
					$oldClientEmpUserQuery = OldCustomer::fnGetCustomerClientEmpDetailsMB();
					$g_val = count($oldClientEmpUserQuery);
					$oldClientEmpQueryRecordsAsArray = array();
					$O = 0;
					foreach ($oldClientEmpUserQuery as $key4 => $value4) {
						$oldClientEmpQueryRecordsAsArray[$O]['id'] = $value4->id;
						$oldClientEmpQueryRecordsAsArray[$O]['cust_id'] = $value4->cust_id;
						$oldClientEmpQueryRecordsAsArray[$O]['emp_id'] = $value4->emp_id;
						$oldClientEmpQueryRecordsAsArray[$O]['status'] = $value4->status;
						$oldClientEmpQueryRecordsAsArray[$O]['start_date'] = $value4->start_date;
						$oldClientEmpQueryRecordsAsArray[$O]['end_date'] = $value4->end_date;
						$oldClientEmpQueryRecordsAsArray[$O]['Ins_DT'] = $value4->Ins_DT;
						$oldClientEmpQueryRecordsAsArray[$O]['Ins_TM'] = $value4->Ins_TM;
						$oldClientEmpQueryRecordsAsArray[$O]['Up_DT'] = $value4->Up_DT;
						$oldClientEmpQueryRecordsAsArray[$O]['UP_TM'] = $value4->UP_TM;
						$oldClientEmpQueryRecordsAsArray[$O]['CreatedBy'] = $value4->CreatedBy;
						$oldClientEmpQueryRecordsAsArray[$O]['UpdatedBy'] = $value4->UpdatedBy;
						$oldClientEmpQueryRecordsAsArray[$O]['delFLg'] = $value4->delFLg;
						$oldClientEmpQueryRecordsAsArray[$O]['branch_id'] =	$value4->branch_id;
						$O++;
					}
					if ($oldClientEmpQueryRecordsAsArray != "") {
						for ($p = 0; $p < count($oldClientEmpQueryRecordsAsArray); $p++) {

							$exist = OldCustomer::fnOldClientEmpExist($oldClientEmpQueryRecordsAsArray[$p]["id"]);
							$existCount = count($exist);

							if ($existCount == 0) {
								$fldarray = "";
								$valuearray = "";
								foreach ($oldClientEmpQueryRecordsAsArray[$p] AS $key => $value) {
									$fldarray[]= $key;
									$valuearray[]= $value;
								}

								$insertOldClientempQuery = OldCustomer::fnInsertClientEmpOLDMBDetails($fldarray,$valuearray);

							}  else {
								$tempvar=$oldClientEmpQueryRecordsAsArray[$p]['id'];
								$fldarray = "";
								$valuearray = "";

								foreach ($oldClientEmpQueryRecordsAsArray[$p] AS $key => $value) {
									if ($key != "id") {
										$fldarray[]= $key;
										$valuearray[]= $value;
									}
								}

								$updateOldClientEmpQuery = OldCustomer::fnUpdateclientempOLDMBDetails($fldarray,$valuearray,$tempvar);
							}
						}
						Session::flash('success', 'Import Sucessfully'); 
						Session::flash('type', 'alert-success'); 
						return Redirect::to('OldCustomer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));

					} else {
						Session::flash('success', 'Data Does NOt exist'); 
						Session::flash('type', 'alert-danger'); 
						return Redirect::to('OldCustomer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
					}

				} else {
					Session::flash('success', 'Invalid Db Connection'); 
					Session::flash('type', 'alert-danger'); 
				}
			}
			else {
				Session::flash('success', 'Invalid Db Connection'); 
				Session::flash('type', 'alert-danger'); 
			}
		} catch (\Exception $e) {
	        Session::flash('success', 'Invalid Db Connection.'); 
			Session::flash('type', 'alert-danger'); 
    	}
		return Redirect::to('OldCustomer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
  	}

  	public function deleteCustomer(Request $request){
  		$delete = OldCustomer::deleteCusbranchincCli($request->custid);
  		if ($delete) {
  			Session::flash('success', 'Deleted Sucessfully'); 
			Session::flash('type', 'alert-success'); 
  		}else{
  			Session::flash('success', 'Deleted UnSucessfully'); 
			Session::flash('type', 'alert-danger'); 
  		}
  		return Redirect::to('OldCustomer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
  	}

}