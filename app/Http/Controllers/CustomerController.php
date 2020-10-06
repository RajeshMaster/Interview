<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Model\Customer;
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
		$getallGroup = Customer::getGroupName();
		return view('customer.groupselectpopup',['request' => $request,'getallGroup' => $getallGroup]);
	}
	public function groupselpopup(Request $request){
		$updGrpId = Customer::updGrpId($request);
		if($updGrpId) {
			Session::flash('success', 'Group Added Sucessfully!'); 
			Session::flash('type', 'alert-success'); 
		} else {
			Session::flash('type', 'Group Added Unsucessfully!'); 
			Session::flash('type', 'alert-danger'); 
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
	}
	public function CustomerAddedit(Request $request){
		$maxid=array();
		$getKenname= array();
		$getKenname=Customer::getKendetails();
		if(isset($request->flg)){

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
											'maxid' => $custmaxid]);
		}
	}
	public function CustomerRegValidation(Request $request){
		$commonrules=array();
		$commonrules = array(
			'txt_custnamejp' => 'required',
			'txt_kananame'=>'required',
			'txt_repname' => 'required',
			'txt_custagreement' => 'required',
			'txt_branch_name' => 'required',
			'txt_mobilenumber' => 'required',
			'txt_fax' => 'required',
			'txt_url' => 'required|url',
			'txt_postal' => 'required|min:8',
			'kenmei' => 'required',
			'txt_shimei' => 'required',
			'txt_streetaddress' => 'required',
			'txt_incharge_name' => 'required',
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
 	public function getEmailExists(Request $request) {
		$inchargeMailExist = Customer::fnGetEmailExistsCheck($request);
		$countEmail = count($inchargeMailExist);
		print_r($countEmail);exit();
  	}
  	public function CustomerAddeditProcess(Request $request){
  		if($request->editid!="") {

  		}else{
  			$maxCustID="CST00001";
  			$custmaxid=Customer::getMaxId();
  			if(!empty($custmaxid)){
				$maxCustID = $custmaxid[0]->custid;
			}
			if($_REQUEST['hid_branch_id'] == "") {
				$customer = substr($maxCustID, 3,5);
				$cus4 = $customer+1;
				$cus5 = str_pad($cus4,5,"0",STR_PAD_LEFT);
			    $branchid = "CST" . $cus5;
			} else {
				$branchid = $_REQUEST['hid_branch_id'];
			}  
			$insertId = Customer::InsertCustomerRec($request,$maxCustID);
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
  		return Redirect::to('Customer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
  		
  	}
}