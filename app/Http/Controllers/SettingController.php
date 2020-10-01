<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Model\Setting;
use App\Http\Common\settingscommon;
use session;
use Redirect;
use Auth;
use Input;
use Config;
use DB;

class SettingController extends Controller {
	/**  
	*  Exists check For Single field popup
	*  @author Easa 
	*  @param $request
	*  Created At 2020/09/30
	**/
	public static function index(Request $request) { 
		return view('setting.index',['request'=> $request]);
	}

	/**  
	*  Exists check For Single field popup
	*  @author Easa 
	*  @param $request
	*  Created At 2020/10/01
	**/
	public function Already_Exists(Request $request) {
		$getTableFields = settingscommon::getDbFieldsforProcess();
		$Already_Exists = Setting::chkNameExists($request,$getTableFields);
		 //echo json_encode($Already_Exists);exit();
		if ($Already_Exists != array()) {
			$existsChk = 1;
		} else {
			$existsChk = 0;
		}
		print_r($existsChk);exit();
	}

	/**  
	*  For Commit Process for All popup
	*  @author Easa 
	*  @param $request
	*  Created At 2020/10/01
	**/
	public function commitProcess(Request $request) {
		$getTableFields = settingscommon::getDbFieldsforProcess();
		$commit = Setting::fngetcommitProcess($request,$getTableFields);
	}

	/**  
	*  Single Text Popup Data Fetch
	*  @author Easa 
	*  @param $request
	*  Created At 2020/10/01
	**/
	public static function singletextpopup(Request $request) {
		$getTableFields = settingscommon::getDbFieldsforProcess();
		$tablename = $request->tablename;
	 	$query = setting::selectOnefieldDatas($getTableFields[$tablename]['selectfields'],
	 										  $getTableFields[$tablename]['commitfields'][0],
	 										  $request);
		$requestAsJSONArray = json_encode($request->all());
		$headinglbl = $getTableFields[$tablename]['labels']['heading'];
		$field1lbl = $getTableFields[$tablename]['labels']['field1lbl'];
		$selectfiled  = $getTableFields[$tablename]['selectfields'];
		return view('setting.singletextpopup',['getdetails' => $query,
												'request'=>$request,
												'headinglbl'=>$headinglbl,
												'field1lbl' => $field1lbl,
												'selectfiled' => $selectfiled,
												'getTableFields'=> $getTableFields,
												'requestAsJSONArray' => $requestAsJSONArray]);
	}

	/**  
	 *  Single Add & Update Process
	 *  @author Easa
	 *  @param $request
	 *  Created At 2020/10/01
	 **/
	public static function SingleFieldaddedit(Request $request) {
		if ($request->flag == 2) {
	 		echo $update_query=Setting::updateSingleField($request);
	 		exit();
		} 
		$tbl_name = $request->tablename;
		$orderidval = Setting::Orderidgenerate($tbl_name);
 		$orderidarray['orderid'] = $orderidval;
 		$ins_query = Setting::insertquery($tbl_name,$request,$orderidval);
 		$location = "";
 		$orderidval = Setting::Orderidgenerateforbranchtotal($location,$tbl_name);
 		$orderidarray['totalid'] = $orderidval;
 		echo json_encode($orderidarray);
	}

	/**  
	 *  Two TextPopup Data Fetch
	 *  @author Easa
	 *  @param $request
	 *  Created At 2020/10/01
	 **/
	public static function twotextpopup(Request $request) {
		$tbl_name = $request->tablename;
		$getTableFields = settingscommon::getDbFieldsforProcess();
		$query = Setting::selectOnefieldDatas($getTableFields[$tbl_name]['selectfields'],
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
	 *  Two Text Add & Update Process
	 *  @author Easa
	 *  @param $request
	 *  Created At 2020/10/01
	 **/
	public static function twoFieldaddedit(Request $request) {
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

	/**  
	 *  Use/Not Use Process
	 *  @author Easa
	 *  @param $request
	 *  Created At 2020/10/01
	 **/
	public static function useNotuse(Request $request) {
		$usenotuse = setting::updateUseNotUse($request);
	}

	public static function getExtension($str) {
	    $i = strrpos($str,".");
	    if (!$i) { return ""; }
	    $l = strlen($str) - $i;
	    $ext = substr($str,$i+1,$l);
	    return $ext;
	}

	/**  
	 *  Group Data Fetch Process
	 *  @author Easa
	 *  @param $request
	 *  Created At 2020/10/01
	 **/
	public static function grouppopup(Request $request) {  
		$groupname = Setting::fnGetgroup();
		$Selgroupname = array();
		$i = 0;
		$j = 0;
		foreach ($groupname as $key => $value) {
			$Selgroupname[$i]['id'] = $value->id;
			$Selgroupname[$i]['groupId'] = $value->groupId;
			$Selgroupname[$i]['groupName'] = $value->groupName;
			$Selgroupname[$i]['delFlg'] = $value->delFlg;
			$SelCustomer = Setting::fnGetCus($value->groupId);
			foreach($SelCustomer as $key => $val) {
				$Selgroupname[$i]['customer'][$j]['cusId'] = $val->customer_id;
				$Selgroupname[$i]['customer'][$j]['cusName'] = $val->customer_name;
				$j++;
			}
			$i++;
		}
		return view('setting.grouppopup',['groupname' => $groupname,'Selgroupname' => $Selgroupname]);
	}

	/**  
	 *  Group Register & Update Process
	 *  @author Easa
	 *  @param $request
	 *  Created At 2020/10/01
	 **/
	public static function groupaddprocess(Request $request) {  
		$groupid = Setting::getmaxid();
		if($groupid == "") {
			$group = "GRP00001";
		} else {
			$id = $groupid;
			$groups = substr($id, 3,5);
			$group = (int)$groups + 1;
			$group = str_pad($group,5,"0",STR_PAD_LEFT);
			$group = "GRP" . $group;
		}
		if ($request->flag != "edit") {
			$insertGroupdetails = Setting::insGrpDtls($group,$request);
			$maxId = Setting::getonlymaxid();
			$orderidarray['orderid'] = $maxId;
			$orderidarray['totalid'] = $maxId;
			$orderidarray['group'] = $group;
			echo json_encode($orderidarray);
		} else {
			$updateGroupdetails = Setting::updGrpDtls($request);
			print_r($updateGroupdetails);exit();
		}
	}

	/**  
	 *  Group Use/Not Use Process
	 *  @author Easa
	 *  @param $request
	 *  Created At 2020/10/01
	 **/
	public static function useNotuses(Request $request) {
		$usenotuse = setting::flagchange($request);
		print_r($usenotuse);exit();
	}
	public static function requirmentSetting(Request $request) {  
		$requirmentSetting =array();
		$requirmentSetting = Setting::fnGetrequirment();
		$Selgroupname = array();
		$i = 0;
		return view('Setting.requirmentSettingpopup',[
														'request' => $request,
														'requirmentSetting' => $requirmentSetting
													]);
	}
	public static function reqirmentaddprocess(Request $request) {
		$data['id'] = $request->id;
		$data['Requirment'] = $request->requirTxt;
		$data['commShow'] = $request->checkbox;
		$data['UpdatedBy'] = Auth::user()->username;
		if ($request->flag != "edit") {
			$data['CreatedBy'] = Auth::user()->username;
			$data['delFlg'] = 0;
		}
		$requimentdtl = Setting::insreqDtls($data);
		if ($request->flag != "edit") {
			$maxId = Setting::getonlymaxidrequirment();
			$orderidarray['orderid'] = $maxId;
			$orderidarray['totalid'] = $maxId;
			$orderidarray['Requirment'] = $request->requirTxt;
			echo json_encode($orderidarray);
		} else {
			$updateGroupdetails = Setting::updGrpDtls($request);
			print_r($requimentdtl);exit();
		}
	}
	public static function useNotusesrequirment(Request $request) {
		$usenotuse = Setting::delflgforrrquirment($request);
		print_r($usenotuse);exit();
	}
	public static function importpopup(Request $request){
		//For Get The DataBase List
		$getOldDbDetails = Setting::fnOldDbDetails();
		return view('Setting.importpopup',['getOldDbDetails'=> $getOldDbDetails,
										'request' => $request]);
	}
	public static function importprocess(Request $request) {
		//Get The New DataBase Details
		$getConnectionQuery = Setting::fnGetConnectionQuery($request);
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
				$tables = array('emp_sysostypes','emp_sysprogramlangtypes','emp_systooltypes','emp_sysdbtypes');
				foreach ($tables as $key => $tableName) {
					$oldRecords = array();
					$oldRecords = Setting::fnGetOldRecords($tableName);
					foreach ($oldRecords as $key1 => $record) {
						$oldRecordAsArray = (array)$record;
						$result = Setting::fnUpdateOrInsert($tableName,$oldRecordAsArray);               
					}
				}
			} else {
				Session::flash('success', 'Invalid Db Connection'); 
				Session::flash('type', 'alert-danger'); 
			}
		} catch (\Exception $e) {
			Session::flash('success', 'Invalid Db Connection.'); 
			Session::flash('type', 'alert-danger'); 
		}
		return Redirect::to('Setting/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}
}