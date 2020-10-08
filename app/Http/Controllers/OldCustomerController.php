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
			return $this->index($request);
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
			$cushistory = OldCustomer::fnGetOnsiteHistory($currentempview[$i]['emp_id'],$request);
			foreach($cushistory as $key=>$rec) { 
				$currentempview[$i]['customername']=$rec->customer_name;
			}
			$i++;
		}
		
		$getdetails=OldCustomer::getcustomerdetails($request);
		return view('oldcustomer.View',['request' => $request,
										'getdetails' => $getdetails,
										'inchargeview' => $inchargeview,
										'branchview' => $branchview,
										'currentview' => $currentview,
										'currentempview' =>$currentempview,
										'getbranchdetails' =>$getbranchdetails
										]);
	}
}