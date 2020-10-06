<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Model\OldCustomer;
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
}