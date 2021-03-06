<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Model\Customer;
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

class CustomerController extends Controller {
	public function index(Request $request)
	{
		$cstviews = array();
		$branchNames = array();
		$disabledactive = "";
		$disabledinactive = "";
		$disabledusenotuse= "";
		$disabledNotGroup = "";
		$disabledGroup = "";
		$cntGrpCus = array();
		//Setting page limit
		if ($request->plimit=="") {
			$request->plimit = 50;
		}
		//Filter process
		if (!isset($request->filterval) || $request->filterval == "") {
			$request->filterval = 1;
		}
		if ($request->filterval == 1) {
			$disabledactive = "disabled fb";
		} else if($request->filterval == 2) {
			$disabledinactive = "disabled fb";
		} else if($request->filterval == 3) {
			$disabledusenotuse="disabled fb";
		}
		// Another Filter process
		if (!isset($request->filterval) || $request->filterval == "") {
			$request->filterval = 1;
		}
		if ($request->filterval == 1) {
			$disabledNotGroup = "disabled fb";
		} else {
			$disabledGroup =  "disabled fb";
		} 
		//Sorting process
		$customersortarray = array("contract"=>trans('messages.lbl_contractDate'),
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
		$customerchange=Customer::customerChangeFlg($request);
		$group = Customer::getGroupName();
		foreach ($group as $key => $value) {
			$cntGrpCus[$value->groupId] = Customer::cntGrpCus($value->groupId);
		}
		$customerdetailview = Customer::CustomerDetailsSelect($request);
		$i = 0;
		foreach($customerdetailview as $key=>$cstview) {
			$cstviews[$i]['customer_id'] = $cstview->customer_id;
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
	    	$cstviews[$i]['postalNumber'] = $cstview->postalNumber;
	    	$cstviews[$i]['shimei'] = $cstview->shimei;
	    	$cstviews[$i]['street_address'] = $cstview->street_address;
	    	$cstviews[$i]['buildingname'] = $cstview->buildingname;
	    	$kenname = Customer::getKenName($cstview->kenmei);
	    	if (isset($kenname[0]->prefecture_name_jp)) {
	    		$cstviews[$i]['kenmei'] = $kenname[0]->prefecture_name_jp;
	    	}
	    	$branchNames = Customer::getSelectedMember($cstviews[$i]['customer_id']);
	    	$j = 0;
	    	foreach($branchNames as $key=>$rec) { 
	 			$cstviews[$i]['BranchName'][$j]=$rec->branch_name;
	 			$j++;
			}
	    	$i++;
	    }
		return View('customer.index',['request' => $request,
									 'cstviews' => $cstviews,
									 'customersortarray' => $customersortarray,
									 'sortMargin' => $sortMargin,
									 'detailview' => $customerdetailview,
									 'group' => $group,
									 'cntGrpCus' => $cntGrpCus,
									 'disabledactive' => $disabledactive,
									 'disabledinactive' => $disabledinactive,
									 'disabledusenotuse' => $disabledusenotuse,
									'disabledNotGroup' => $disabledNotGroup,
									'disabledGroup' => $disabledGroup]);
	}
	public function selectGroup(Request $request){
		$getGroupCheck = Customer::getGroupCheck($request);
		if (!empty($getGroupCheck[0]->groupId)) {
			$flg = 1;
		}else{
			$flg = 0;
		}
		$getallGroup = Customer::getGroupName();
		return view('customer.groupselectpopup',['request' => $request,'getallGroup' => $getallGroup,'flg' => $flg,'getGroupCheck'=>$getGroupCheck]);
	}
	public function groupselpopup(Request $request){
		$updGrpId = Customer::updGrpId($request);
		if($updGrpId) {
			if(isset($request->grpId) && $request->grpId!="" ){
				Session::flash('success', 'Group Added Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			}else{
				Session::flash('success', 'Group Removed Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			}
		} else {
			if(isset($request->grpId) && $request->grpId!="" ){
				Session::flash('success', 'Group Added UnSucessfully!'); 
				Session::flash('type', 'alert-success'); 
			}else{
				Session::flash('success', 'Group Removed UnSucessfully!'); 
				Session::flash('type', 'alert-success'); 
			}
		}
		return Redirect::to('Customer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}
	public function CustomerView(Request $request){
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
	       return Redirect::to('Customer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	    }
	    $customer_id = substr($request->custid, 3,5);
		$cus = $customer_id+1;
		$cus = str_pad($cus,5,"0",STR_PAD_LEFT);
		if(isset($_REQUEST['hid_branch_id']) != "") {
			$branchid = "CST" . $cus;
		} else {
			$branchid = " ";
		}
		$id=$request->custid;
		$getinchargedetails=Customer::getInchargeDetails($id);
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
	    $getbranchdetails=Customer::getBranchDetails($id);
	    $i=0;
		foreach($getbranchdetails as $key=>$bview) {
	    	$branchview[$i]['branch_name'] = $bview->branch_name;
	    	$branchview[$i]['branch_contact_no'] = $bview->branch_contact_no;
	    	$branchview[$i]['branch_fax_no'] = $bview->branch_fax_no;
	    	$branchview[$i]['id'] = $bview->branch_id;
	    	$branchview[$i]['branch_address'] = $bview->branch_address;
	    	$branchview[$i]['customer_id'] = $bview->customer_id;
	    	$branchview[$i]['postalNumber'] = $bview->postalNumber;
	    	$branchview[$i]['kenmei'] = $bview->kenmei;
	    	$branchview[$i]['shimei'] = $bview->shimei;
	    	$branchview[$i]['street_address'] = $bview->street_address;
	    	$branchview[$i]['buildingname'] = $bview->buildingname;
	    	if (isset($bview->prefNameJP)) {
	    		$branchview[$i]['prefNameJP'] = $bview->prefNameJP;
	    	} 
	    	if (isset($bview->prefNameEN)) {
	    		$branchview[$i]['prefNameEN'] = $bview->prefNameEN;
	    	}
			$branchview[$i]['incharegdetails'] = Customer::getInchargeDetailsByBranch($id,$bview->branch_id);
	    	$i++;
	    }
	    $currentemployeedetails = Customer::selectIdclientDtl($id);
	    $i=0;
		foreach($currentemployeedetails as $key=>$cempview) {
	    	$currentview[$i]['customer_id'] = $cempview->customer_id;
	    	$currentview[$i]['customer_name'] = $cempview->customer_name;
	    	$currentview[$i]['emp_id'] = $cempview->emp_id;
	    	$currentview[$i]['status'] = $cempview->status;
	    	$currentview[$i]['start_date'] = $cempview->start_date;
	    	$currentview[$i]['end_date'] = $cempview->end_date;
	    	$currentview[$i]['update_by'] = $cempview->update_by;
	    	$viewname = Common::fnGetEmployeeInfo($currentview[$i]['emp_id']);
	    	foreach($viewname as $key=>$rec) { 
	 		$currentview[$i]['LastName']=$rec->LastName;
	 		$currentview[$i]['FirstName']=$rec->FirstName;
			}
			if($cempview->end_date=="0000-00-00") {
				$currentview[$i]['end_date'] ="";
			}
	    	$cusexpdetails = Customer::getYrMonCountBtwnDates($currentview[$i]['start_date'],$currentview[$i]['end_date']);
	    	if ($cusexpdetails['year'].".".$cusexpdetails['month'] == 0.0) {
				$currentview[$i]['experience'] = "-";
			} else {
				$currentview[$i]['experience'] = $cusexpdetails['year'].".".Customer::fnAddZeroSubstring($cusexpdetails['month']);
			}
	    	$i++;
	    }
	    $currentempdetails = Customer::selectByIdchangeclientDtl($id);
	    	    	
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
	    	$cusexpdetails = Customer::getYrMonCountBtwnDates($currentempview[$i]['start_date'],$currentempview[$i]['end_date']);
	    	if ($cusexpdetails['year'].".".$cusexpdetails['month'] == 0.0) {
				$currentempview[$i]['experience'] = "-";
			} else {
				$currentempview[$i]['experience'] = $cusexpdetails['year'].".".Customer::fnAddZeroSubstring($cusexpdetails['month']);
			}
	    	$i++;
	    }
	    $getdetails=Customer::getCustomerDetails($request);
		return view('customer.customerview',['request' => $request,
										'getdetails' => $getdetails,
										'inchargeview' => $inchargeview,
										'branchview' => $branchview,
										'currentview' => $currentview,
										'currentempview' =>$currentempview,
										'getbranchdetails' =>$getbranchdetails
										]);

	}
	public function CustomerAddedit(Request $request){
		$maxid=array();
		$getKenname= array();
		$getKenname=Customer::getKendetails();
		$group = Customer::getGroupName();
		if(isset($request->flg)){
			$customer_id = substr($request->custid, 3,5);
			$cus = $customer_id+1;
			$cus = str_pad($cus,5,"0",STR_PAD_LEFT);
			//print_r($cus);exit();
			if(isset($_REQUEST['hid_branch_id']) != "") {
				$branchid = "CST" . $cus;
			} else {
				$branchid = $_REQUEST['hid_branch_id'];
			}
			$getbranchdetails=Customer::getBranchdt($request,$branchid);
			$getdetails=Customer::getCustomerDetails($request);
			return view('customer.customeraddedit',['request' => $request,
											'getdetails' => $getdetails,
											'getKenname' => $getKenname,
											'getbranchdetails' => $getbranchdetails,
											'group'=> $group ]);
		}else{
			if (!isset($request->hdnempid)) {
				return Redirect::to('Customer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
			}
			$custmaxid=Customer::getMaxId();
			if($custmaxid == ""){
				$custmaxid = "CST00001";
			}
			return view('customer.customeraddedit',['request' => $request,
											'getKenname' => $getKenname,
											'maxid' => $custmaxid,'group'=> $group]);
		}
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
		if($request->flg!=1){
			$commonrules1 = array(
				'txt_incharge_name' => 'required',
				'txt_mailid' => 'required|email',
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
 	public function getEmailExists(Request $request) {
		$inchargeMailExist = Customer::fnGetEmailExistsCheck($request);
		print_r($inchargeMailExist);exit();
  	}
  	public function CustomerAddeditProcess(Request $request){
  		$groupIdList="";
  		if ($request->groupingID!="") {
  			$groupIdList = implode(';',preg_replace("/\s+/", "", $request->groupingID)); 
  		}
  		if($request->editid!="") {
  			$customer_id = substr($request->custid, 3,5);
			$cus = $customer_id+1;
			$cus = str_pad($cus,5,"0",STR_PAD_LEFT);
			if($_REQUEST['hid_branch_id'] == "") {
				$branchid = "CST" . $cus;
			} else {
				$branchid = $_REQUEST['hid_branch_id'];
			}	
			$update = Customer::updaterec($request,$groupIdList);
			$update= Customer::updatebranchrec($request,$branchid);
			// $update= Customer::updateincharge($request,$branchid);
			if($update) {
				Session::flash('success', 'Updated Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('type', 'Updated Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		    Session::flash('custid', $request->custid );
			Session::flash('id', $request->id );
  		}else{
  			$custmaxid=Customer::getMaxId();
  			if(!empty($custmaxid[0]->custid)){
				$maxCustID = $custmaxid[0]->custid;
			}else{
				$maxCustID="CST00001";
			}
			if($_REQUEST['hid_branch_id'] == "") {
				$customer = substr($maxCustID, 3,5);
				$cus4 = $customer+1;
				$cus5 = str_pad($cus4,5,"0",STR_PAD_LEFT);
			    $branchid = "CST" . $cus5;
			} else {
				$branchid = $_REQUEST['hid_branch_id'];
			}  
			$insertId = Customer::InsertCustomerRec($request,$maxCustID,$groupIdList);
			$insert= Customer::InsertBranchRec($request,$branchid,$maxCustID);
			$insert=Customer::InsertIncharge($request,$branchid,$maxCustID);
			if($insert) {
				Session::flash('success', 'Inserted Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('type', 'Inserted Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
			Session::flash('id', $insertId );
			Session::flash('custid', $maxCustID );
  		}
  		return Redirect::to('Customer/CustomerView?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
  	}

  	public function Branchaddedit(Request $request){
		$kenmeiarray = Customer::getKendetails();
		$bdetails = array();
		if(isset($request->flg) && $request->flg !="") {
			$bid = $request->branchid;
			$bdetails = Customer::getBranchdt($request,$bid);
			return view('customer.branchaddedit',['request' => $request,
													'kenmeiarray'=>$kenmeiarray,
													'bdetails' => $bdetails
												]);
		} else if(isset($request->flg) && $request->flg == ""){
			return view('customer.branchaddedit',['request' => $request,
													'kenmeiarray'=> $kenmeiarray
												]);
		} else {
			return Redirect::to('Customer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
	}

  	public function BranchRegValidation(Request $request){
  		$commonrules1 = array();
  		$commonrules = array(
			'txt_branch_name' => 'required',
			'txt_mobilenumber' => 'required',
			'txt_fax' => 'required',
			'txt_postal' => 'required|min:8',
			'kenmei' => 'required',
			'txt_shimei' => 'required',
			'txt_streetaddress' => 'required',
		);
		if($request->flg!=1){
			$commonrules1 = array(
				'txt_incharge_name' => 'required',
				'txt_mailid' => 'required|email',
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
  	public function Branchaddeditprocess(Request $request){
  		if($request->editid =="") {
  			if(Session::get('custid') !=""){
				$request->custid = Session::get('custid');
			}
			if(!isset($request->id)){
				return Redirect::to('Customer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
			}
			$maxbranchid = Customer::getMaxBranchId($request);
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
			$custid=$request->custid;
			$insert= Customer::InsertBranchRec($request,$cus3,$custid);
			$insert=Customer::InsertIncharge($request,$cus3,$custid);
			Session::flash('custid', $request->custid );
			Session::flash('id', $request->id );
			if($insert) {
				Session::flash('success', 'Branch Inserted Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('type', 'Inserted Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
  		}else{
  			$branchid=$request->branid;
			$update= Customer::updatebranchrec($request,$branchid);
			Session::flash('custid', $request->custid );
	    	Session::flash('id', $request->id );
			if($update) {
				Session::flash('success', 'Branch Updated Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('type', 'Updated Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
  		}
  		return Redirect::to('Customer/CustomerView?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
  	}
  	public function Inchargeaddedit(Request $request){
  		$details=Customer::getBranchDetails($request->custid);
  		$getbname = array();
  		$indetails = array();
		foreach ($details as $key => $value) {
			$getbname[$value->branch_id] = $value->branch_name;
		}
		$getdesname = Customer::getDesignationList();

  		if(isset($request->flg)){
  			if($request->flg!=""){
  				$inchargeid=$request->editid;
				$indetails=Customer::getInchargeUpdateDetails($request,$inchargeid);
  			}
  			return view('customer.inchargeaddedit',['request' => $request,
													'getbname' => $getbname,
													'indetails'=>$indetails,
													'getdesname' => $getdesname]);
  		}else{
  			return Redirect::to('Customer/CustomerView?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
  		}
  	}
  	public function InchargeRegValidation(Request $request){
  		$commonrules = array(
			'txt_incharge_name' => 'required',
			'txt_incharge_namekana' => 'required',
			'bname' => 'required|min:8',
			'designation' => 'required',
			'txt_mailid' => 'required|email',
		);
		
		$rules = $commonrules;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);exit;
        } else {
            $success = true;
            echo json_encode($success);
        }
  	}
  	public function Inchargeaddeditprocess(Request $request){
  		if($request->editid =="") {
  			if(Session::get('custid') !=""){
	          $request->custid = Session::get('custid');
	     	}
			if(!isset($request->id)){
		        return Redirect::to('Customer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		    }
			$custid =$request->custid;
			$insert = Customer::insertInchargeRecord($request,$custid);
			Session::flash('custid', $request->custid );
			Session::flash('id', $request->id );
			if($insert) {
				Session::flash('success', 'Incharge Added Successfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('type', 'Inserted Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
  		}else{
  			$id = $request->editid;
			$update = Customer::updateInchargeRec($request,$id);
			Session::flash('custid', $request->custid );
	    	Session::flash('id', $request->id );
			if($update) {
				Session::flash('success', 'Updated Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('type', 'Updated Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
  		}
  		return Redirect::to('Customer/CustomerView?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
  	}
  	public function EmpNamePopup(Request $request){

  		$cemployeeview=array();
		$cusdetail = Customer::getCusDetailEmp($request);
		$selectionaddress = Customer::selectEmpAddressInClient($request);
		$i=0;
		foreach($selectionaddress as $key=>$cpopupview) {
	    	$cemployeeview[$i]['branch_name'] = $cpopupview->branch_name;
	    	$cemployeeview[$i]['start_date'] = $cpopupview->start_date;
	    	$cemployeeview[$i]['end_date'] = $cpopupview->end_date;
	    	$cemployeeview[$i]['status'] = $cpopupview->status;
	    	$cemployeeview[$i]['incharge_name'] = $cpopupview->incharge_name;

	    	if($cpopupview->end_date=="0000-00-00") {
				$cemployeeview[$i]['end_date'] ="";
			} else {
				$cemployeeview[$i]['end_date'] = $cpopupview->end_date;
			}
			$i++;
	    }
		$emp_type1=Customer::getUserNameByEmployee($request);
		$empdt = Common::fnGetEmployeeInfo($request->employeeid);
		$branchdetails=Customer::getBranchDetailsEmp($request);
		return view('customer.empnamepopup',['request' => $request,
					'cusdetail' => $cusdetail,
					'cemployeeview' => $cemployeeview,
					'empname1' => $emp_type1,
					'bname' => $branchdetails,
					'empdt' => $empdt
					]);
  	}
  	public function incharge_ajax(Request $request){
		$customerId = $request->getcusId;
		$branchId = $request->getbranchId;
		$getInchargeDtl = Customer::fnGetinchargeName($customerId,$branchId);
		$inchargearray = json_encode($getInchargeDtl);
		echo $inchargearray;
		exit();
	}
	public function EmpNamePopupRegValidation(Request $request){
		$commonrules= array();
		if($request->selectionid !=1){
			$commonrules = array(
				'txt_start_date' => 'required|date_format:"Y-m-d"',
				'txt_end_date' => 'required|date_format:"Y-m-d"|after:txt_start_date',
			);
		}else{
			$commonrules = array(
			'newemployeename' => 'required',
			'inchargeId' => 'required',
			'newbranches' => 'required',
			'txt_start_date' => 'required|date_format:"Y-m-d"',
			);
		}
		$rules = $commonrules;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);exit;
        } else {
            $success = true;
            echo json_encode($success);
        }
	}
	public function EmpNamePopupAddEditprocess(Request $request){
		if($request->selectionid == 1){
			$insert = Customer::insclientdtl($request);
			if($insert){
				Session::flash('success', 'Registered Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			}else {
				Session::flash('type', 'Registered Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		    Session::flash('custid', $request->custid );
		    Session::flash('id', $request->id );
		}else{
			$update = Customer::updateEnddate($request);
			if($update) {
				Session::flash('success', 'Updated Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('type', 'Updated Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		    Session::flash('custid', $request->custid );
		    Session::flash('id', $request->id );
		}
		return Redirect::to('Customer/CustomerView?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}
	public function Onsitehistory(Request $request){
		if($request->hdnempid == "") {
			return Redirect::to('Customer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$customerhistory = array();
		if ($request->plimit=="") {
			$request->plimit = 50;
		}
		$empDt = Common::fnGetEmployeeInfo($request->hdnempid);
		$cushistory = Customer::fnGetOnsiteHistoryDetails($request);
		$i = 0;
	    foreach($cushistory as $key=>$chistory) {
	    	$customerhistory[$i]['start_date'] = $chistory->start_date;
	    	$customerhistory[$i]['end_date'] = $chistory->end_date;
	    	$customerhistory[$i]['status'] = $chistory->status;
	    	$customerhistory[$i]['customer_name'] = $chistory->customer_name;
	    	$customerhistory[$i]['branch_name'] = $chistory->branch_name;
	    	if($chistory->end_date=="0000-00-00") {
				$customerhistory[$i]['end_date'] ="";
			}
	    	$cusexpdetails = Customer::getYrMonCountBtwnDates($customerhistory[$i]['start_date'],$customerhistory[$i]['end_date']);
	    	if ($cusexpdetails['year'].".".$cusexpdetails['month'] == 0.0) {
				$customerhistory[$i]['experience'] = "0.0";
			} else {
				$customerhistory[$i]['experience'] = $cusexpdetails['year'].".".Customer::fnAddZeroSubstring($cusexpdetails['month']);
			}
	    	$i++;
	    }
	    return view('customer.onsitehistory',['request' => $request,
											'cushistory' => $cushistory,
											'customerhistory' => $customerhistory,
											'empDt' => $empDt
											]);
	}
}