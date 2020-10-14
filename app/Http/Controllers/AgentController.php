<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Model\Agent;
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

class AgentController extends Controller {
	public function index(Request $request){
		$agentViews = array();
		$disabledactive = "";
		$disabledinactive = "";
		$disabledusenotuse = "";
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
		//Sorting process
		$agentsortarray = array("agent_id"=>trans('messages.lbl_agentId'),
									"agent_name"=>trans('messages.lbl_name'),
									"agent_address"=>trans('messages.lbl_address')
		);
		
		if ($request->agentsort == "") {
			$request->agentsort = "agent_id";
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
		$agentChange = Agent::changeAgentFlg($request);
		$agentdetails = Agent::getAgentdetails($request);
		$i = 0;
		foreach($agentdetails as $key => $agentView) {
	    	$agentViews[$i]['id'] = $agentView->id;
			$agentViews[$i]['agent_id'] = $agentView->agent_id;
			$agentViews[$i]['agent_name'] = $agentView->agent_name;
			$agentViews[$i]['agent_kananame'] = $agentView->agent_kananame;
			$agentViews[$i]['agent_Contract'] = $agentView->contract;
			$agentViews[$i]['agent_contact_no'] = $agentView->agent_contact_no;
			$agentViews[$i]['agent_email_id'] = $agentView->agent_email_id;
			$agentViews[$i]['agent_fax_no'] = $agentView->agent_fax_no;
			$agentViews[$i]['agent_website'] = $agentView->agent_website;
			$agentViews[$i]['agent_address'] = $agentView->agent_address;
			$agentViews[$i]['delflg'] = $agentView->delflg;
			$agentViews[$i]['id'] = $agentView->id;
			$agentViews[$i]['postalNumber'] = $agentView->postalNumber;
			$agentViews[$i]['shimei'] = $agentView->shimei;
			$agentViews[$i]['street_address'] = $agentView->street_address;
			$agentViews[$i]['buildingname'] = $agentView->buildingname;
			$kenname = Agent::getKenName($agentView->kenmei);
			if (isset($kenname[0]->prefecture_name_jp)) {
				$agentViews[$i]['kenmei'] = $kenname[0]->prefecture_name_jp;
			}
			$i++;
	    }
		return view('agent.index',['request' => $request,
									 'agentViews' => $agentViews,
									 'agentsortarray' => $agentsortarray,
									 'agentdetails' => $agentdetails,
									 'src' => $src,
									 'disabledactive' => $disabledactive,
									 'disabledinactive' => $disabledinactive,
									 'disabledusenotuse' => $disabledusenotuse]);
	}
	public function AgentView(Request $request){
		if(Session::get('agentId') != ""){
			$request->agentId = Session::get('agentId');
		}
		if(!isset($request->agentId)){
			return $this->index($request);
		}
		$allcustomer = "";
		$allcustomernames ="";
		$getdetails = Agent::getSingleAgentRecord($request);
		$cusId = explode(",", $getdetails[0]->customerId);
		foreach ($cusId as $key => $val) {
			$getCusName = Agent::getCusName($request,$val);
			foreach ($getCusName as $key => $value) {
				$customername = $value->customer_name;
				$allcustomer .= $customername.',';
				$allcustomernames = substr($allcustomer,0,-1);
			}
		}
		return view('agent.agentview',['request' => $request,'getdetails' => $getdetails,'allcustomernames' => $allcustomernames]);
	}

	public function AgentAddedit(Request $request){
		if(!isset($request->editflg)){
			return $this->index($request);
		}
		$getKenname = array();
		$getKenname = Agent::getKendetails();
		if ($request->editflg == "edit") {
			$getSingleAgent = Agent::getSingleAgentRecord($request);
		} else {
			$getSingleAgent = array();
		}
		return view('agent.addedit',['request' => $request,
									'getKenname' => $getKenname,
									'getSingleAgent' => $getSingleAgent]);
	}

	public function AgentRegValidation(Request $request){
		$commonrules = array(
			'txt_agentName' => 'required',
			'txt_agentNameJp' => 'required',
			'txt_agentContract' => 'required|date_format:"Y-m-d"',
			'txt_emailId' => 'required|email',
			'txt_mobilenumber' => 'required',
			'txt_postal' => 'required',
			'kenmei' => 'required',
			'txt_shimei' => 'required',
			'txt_streetaddress' => 'required',
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
		$mailExist = Agent::fnGetEmailExistsCheck($request);
		$countEmail = count($mailExist);
		print_r($countEmail);exit();
  	}
  	public function AgentAddeditProcess(Request $request){
  		if($request->editflg == "edit") {
			$update = Agent::updateAgentRec($request);
			if($update) {
				Session::flash('success', 'Updated Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('type', 'Updated Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		    Session::flash('agentId', $request->agentId );
		} else{
			$agentMaxId = Agent::agentMaxIdGenerate();
			if(!empty($agentMaxId) && $agentMaxId[0]->agentid!=""){
				$agentId = $agentMaxId[0]->agentid;
			}else{
				$agentId = "AG0001";
			}
			print_r($agentId); exit();
			$insert = Agent::insertAgentRec($request,$agentId);
			if($insert) {
				Session::flash('success', 'Inserted Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('type', 'Inserted Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
			Session::flash('agentId', $agentId);
		}
		return Redirect::to('Agent/AgentView?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
  	}
  	public function addeditCustomer(Request $request) {
		if(!isset($request->cuseditflg)){
			return $this->index($request);
		}
		$customerUnSelectedMembers = "";
		$Agent = "";
		$Agentval = "";
		$customerValue = "";
		$SingleAgent = Agent::getSingleAgentRecord($request);
		$Agentdtls = Agent::getAgentdtls();
		foreach ($Agentdtls as $key => $val) {
			$variable1 = explode(",", $val->customerId);
			foreach ($variable1 as $key => $val1) {
				$Agentval .= "'".$val1."',";
			}
		}
		$customerUnSelectedMembers = rtrim($Agentval, ',');
		if ($customerUnSelectedMembers != "") {
			$customerName = Agent::getCustomergrp($customerUnSelectedMembers,2);
		} else {
			$customerName = Agent::getCustomergrp($customerUnSelectedMembers);
		}
		$customerUnSelectedMembers = str_replace("'", "",$customerUnSelectedMembers);
		if($request->cuseditflg == "edit") {
			foreach ($SingleAgent as $key => $value) {
				$variable = explode(",", $value->customerId);
				foreach ($variable as $key => $value1) {
					$Agent .= "'".$value1."',";
				}
			}
			$customerSelectedMembers = rtrim($Agent, ',');
			$customerValue = str_replace("'","",$customerSelectedMembers);
			$customerSelectedMembers = Agent::getCustomergrp($customerSelectedMembers,1);
		} else {
			$customerSelectedMembers = array();
			
		}
		return view('agent.cusaddedit',compact('request',
												'customerName',
												'customerSelectedMembers',
												'customerUnSelectedMembers',
												'SingleAgent',
												'customerValue'
											));
	}
	public static function cusaddeditprocess(Request $request) {
		if (!isset($request->agentId)) {
			return $this->index($request);
		}
		$updatedtls = Agent::updCusDtls($request);
		if ($updatedtls) {
			Session::flash('message', 'Updated Sucessfully'); 
			Session::flash('type', 'alert-success'); 
		} else {
			Session::flash('message', 'Update Unsucessfully'); 
			Session::flash('type', 'alert-warning');
		}
		Session::flash('agentId', $request->agentId);
		return Redirect::to('Agent/AgentView?mainmenu=Agent&time='.date('YmdHis'));
	}
}