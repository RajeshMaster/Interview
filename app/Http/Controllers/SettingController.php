<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Model\Setting;
use App\Http\Common\settingcommon;
use Redirect;
use Session;
use Input;
use Validator;
class SettingController extends Controller {

	/**
	*  For Setting Index
	*  @author Sarath 
	*  @param $request
	*  Created At 2020/08/25
	*/
	public function index(Request $request) {
		return view('setting.index',compact('request'));
	}

	/** View Single Text Popup
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/25
	*/
	public function singletextpopup(Request $request) {
		$getTableFields = settingcommon::getDbFieldsforProcess();
		$tablename = $request->tablename;
		$getdetails = Setting::selectOnefieldDatas($getTableFields[$tablename]['selectfields'],
											  $getTableFields[$tablename]['commitfields'][0],
											  $request);
		$requestAsJSONArray = json_encode($request->all());
		$headinglbl = $getTableFields[$tablename]['labels']['heading'];
		$field1lbl = $getTableFields[$tablename]['labels']['field1lbl'];
		$selectfiled  = $getTableFields[$tablename]['selectfields'];
		return view('setting.singletextpopup',compact('getdetails',
														'headinglbl',
														'field1lbl',
														'selectfiled',
														'getTableFields',
														'requestAsJSONArray',
														'request'));
	}

	/**  
	*  Exists check For Single field popup
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/25
	**/
	public function Already_Exists(Request $request) {
		$Already_Exists = Setting::chkNameExists($request);
		// echo json_encode($Already_Exists);exit();
		if ($Already_Exists != array()) {
			$existsChk = 1;
		} else {
			$existsChk = 0;
		}
		print_r($existsChk);exit();
	}

	/**
	*  For Use and Notuse for single field popup
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/25
	**/
	public function useNotuse(Request $request) {
		$usenotuse = setting::updateUseNotUse($request);
	}
	
	/**
	*  For Insert Process for single field popup
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/25
	**/
	public function SingleFieldaddedit(Request $request) {
		if ($request->flag == 2) {
			echo $update_query = Setting::updateSingleField($request);
			exit();
		} 
		$tbl_name = $request->tablename;
		$orderidval = Setting::Orderidgenerate($tbl_name);
		$orderidarray['orderid'] = $orderidval;
		$ins_query = Setting::insertquery($tbl_name,$request,$orderidval);
		$actualId = "";
		$actualVal = Setting::selectOrderId($request);
		foreach ($actualVal as $key => $value) {
			$actualId .=  $value->orderId.",";
		}
		$orderidarray['actualid'] = rtrim($actualId, ",");
		$location = "";
		$orderidval = Setting::Orderidgeneratefortotal($location,$tbl_name);
		$orderidarray['totalid'] = $orderidval;
		echo json_encode($orderidarray);
	}

	/**
	*  For View Two field popup
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/27
	**/
	public function twotextpopup(Request $request) {
		$tbl_name = $request->tablename;
		$getTableFields = settingcommon::getDbFieldsforProcess();
		$query = setting::selectOnefieldDatas($getTableFields[$tbl_name]['selectfields'],
											  $getTableFields[$tbl_name]['commitfields'][0],
											  $request);
		$requestAsJSONArray = json_encode($request->all());
		$headinglbl = $getTableFields[$tbl_name]['labels']['heading'];
		$field1lbl = $getTableFields[$tbl_name]['labels']['field1lbl'];
		$field2lbl = $getTableFields[$tbl_name]['labels']['field2lbl'];
		$selectfiled  = $getTableFields[$tbl_name]['selectfields'];
		return view('setting.twofieldpopup',['query' => $query,
												'request'=>$request,
												'headinglbl'=>$headinglbl,
												'field1lbl' => $field1lbl,
												'field2lbl' => $field2lbl,
												'selectfiled' => $selectfiled,
												'getTableFields'=> $getTableFields,
												'requestAsJSONArray' => $requestAsJSONArray]);
	}

	/**
	*  For Insert Process for single field popup
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/27
	**/
	public function twoFieldaddedit(Request $request) {
		if ($request->flag == 2) {
			echo $update_query = Setting::updatetwoField($request);
			exit();
		}
		$tbl_name = $request->tablename;
		$orderidval = Setting::Orderidgenerate($tbl_name);
		$orderid = $orderidval;
		$orderidarray['orderid'] = $orderidval;
		$ins_query = Setting::insertquerytwofield($tbl_name,$request,$orderid);
		$actualId = "";
		$actualVal = Setting::selectOrderId($request);
		foreach ($actualVal as $key => $value) {
			$actualId .=  $value->orderId.",";
		}
		$orderidarray['actualid'] = rtrim($actualId, ",");
		$location = "";
		$orderidval = Setting::Orderidgeneratefortotal($location,$tbl_name);
		$orderidarray['totalid'] = $orderidval;
		echo json_encode($orderidarray);
	}

	/** Single Text & Select Popup
	 *  @author Sastha.C 
	 *  @param $request
	 *  Created At 2020/08/28
	*/
	public function selecttextpopup(Request $request) {
		$getTableFields = settingcommon::getDbFieldsforProcess();
		$tablename = $request->tablename;
		if (isset($request->tableselect)) {
			$getdetails = Setting::selectTwofieldDatas(
						$getTableFields[$tablename]['selectfields'],
						$getTableFields[$tablename]['commitfields'][0],
						$getTableFields[$tablename]['selectboxfields'][1],
						$request);
		}
		$requestAsJSONArray = json_encode($request->all());
		$headinglbl = $getTableFields[$tablename]['labels']['heading'];
		$field1lbl = $getTableFields[$tablename]['labels']['field1lbl'];
		$field2lbl = $getTableFields[$tablename]['labels']['field2lbl'];
		$selectfiled  = $getTableFields[$tablename]['selectfields'];
		$selectboxval = "";
		if ($request->tableselect != "" && $request->tableselect != "text") {
			$selectboxval = Setting::selectboxDatas(
							$getTableFields[$tablename]['selectboxfields'],
							$getTableFields[$request->tablename]['commitfields'][0],
							$request);
		}
		return view('setting.selecttextpopup',compact('getdetails',
														'headinglbl',
														'field1lbl',
														'field2lbl',
														'selectfiled',
														'getTableFields',
														'selectboxval',
														'requestAsJSONArray',
														'request'));
	}

	/**  
	 *  Form Validation For Select Text
	 *  @author Sastha.C 
	 *  @param $request
	 *  Created At 2018/03/22
	 **/
	public function formValidationforsingletext(Request $request) {
		// print_r(json_encode($request->all()));exit;
		$rules = array(
			'selectbox1' => 'required',
			'textbox1' => 'required');
		$customizedNames = array(
								'textbox1' => 'Textbox1'
								);
		$validator = Validator::make($request->all(), $rules);
		$validator->setAttributeNames($customizedNames);
		if ($validator->fails()) {
			// If validation falis redirect back to Register Screen.
			return response()->json($validator->messages(), 200);exit;
		} else {
			$success = true;
			echo json_encode($success);exit;
		}
	}

	/**  
	 *  Exist Check For Select Text
	 *  @author Sastha.C 
	 *  @param $request
	 *  Created At 2018/03/23
	 **/
	function existforselecttext(Request $request){
		$dateexistcheck = Setting::checkforselecttext($request);
		$dateexistcheck = count($dateexistcheck);
		echo $dateexistcheck;exit();
	}

	/**  
	*  For Insert Process for Three field
	*  @author Sastha.C 
	*  @param $request
	*  Created At 2018/03/14
	**/
	public function SelecttextFieldaddedit(Request $request) {
		if ($request->flag == 2) {
			echo $update_query=Setting::updateselecttextField($request);
			exit();
		}
		$tbl_name = $request->tablename;
		$orderidval = Setting::Orderidgenerate($tbl_name);
		if ($orderidval == "") {
			$orderidval = 1;
		} else {
			$orderidval = $orderidval;
		}
		$orderidarray['orderid'] = $orderidval;
		$ins_query = Setting::insertqueryforselecttextfield($tbl_name,$request,$orderidval);
		$actualId = "";
		$actualVal = Setting::selectOrderId($request);
		foreach ($actualVal as $key => $value) {
			$actualId .=  $value->orderId.",";
		}
		$orderidarray['actualid'] = rtrim($actualId, ",");
		$location = "";
		$orderidval = Setting::Orderidgeneratefortotal($location,$tbl_name);
		$orderidarray['totalid'] = $orderidval;
		echo json_encode($orderidarray);exit();
	}

	/**  
	*  For Commit Process for All popup
	*  @author Sarath 
	*  @param $request
	*  Created At 2020/09/21
	**/
	public function commitProcess(Request $request) {
		$commit = Setting::fngetcommitProcess($request);
	}
}
?>