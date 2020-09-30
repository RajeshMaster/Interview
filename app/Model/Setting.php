<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use App;
use Auth;
use App\Http\Common\settingcommon;
class Setting extends Model { 

	/** Single Text Popup
	*  @author sarath 
	*  @param $request,$fieldArray,$orderid
	*  Created At 2020/08/25
	*/
	public static function selectOnefieldDatas($fieldArray,$orderid,$request) {
		$db = DB::connection('mysql');
		$fieldNames="";
		for ($i=0; $i < count($fieldArray); $i++) {
			$fieldNames .= "".$fieldArray[$i].",";
		}
		$fieldNames = rtrim($fieldNames, ',');
		$query = $db->table($request->tablename)
					->select(DB::raw($fieldNames))
					->orderBy('orderId','ASC')
					->get();
		return $query;
	}

	/** Get OrderId
	*  @author Sastha 
	*  @param $request
	*  Created At 2020/08/25
	*/
	public static function selectOrderId($request) {
		$db = DB::connection('mysql');
		$query = $db->table($request->tablename)
					->select('orderId')
					->orderBy('orderId','ASC')
					->get();
		return $query;
	}

	/**  
	*  Exists check For Single field popup
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/25
	**/
	public static function chkNameExists($request) {
		$db = DB::connection('mysql');
		$table_name = $request->tablename;
		$getTableFields = settingcommon::getDbFieldsforProcess();
		if (isset($request->textbox1) && $request->textbox1 != "") {
			$field = $getTableFields[$table_name]['selectfields'][1];
			$value = $request->textbox1;
		} else if (isset($request->textbox2) && $request->textbox2 != "") {
			$field = $getTableFields[$table_name]['selectfields'][2];
			$value = $request->textbox2;
		} else {
			$field = "";
			$value = "";
		}
		$id = $getTableFields[$table_name]['selectfields'][0];
		$value = "'".$value."'";
		$concat = "WHERE mergeall".".".$field." IN($value)";
		if ($request->flag != 2) {
			$query = DB::select("SELECT * FROM(SELECT ".$field." FROM ".$table_name.") AS mergeall $concat");
		} else {
			$query = DB::select("SELECT * FROM(SELECT ".$field." FROM ".$table_name." WHERE ".$id." != ".$request->id.") AS mergeall $concat");
		}
		return $query;
	}

	/**  
	*  Addedit For Single field popup
	*  @author sarath 
	*  @param $request,$tbl_name,$orderidval
	*  Created At 2020/08/25
	**/
	public static function insertquery($tbl_name,$request,$orderidval) {
		$db = DB::connection('mysql');
		$getTableFields = settingcommon::getDbFieldsforProcess();
		$DBType = $getTableFields[$tbl_name]['insertfields'][0];
		$DelFlg = $getTableFields[$tbl_name]['insertfields'][1];
		$InsDT = $getTableFields[$tbl_name]['insertfields'][2];
		$UpDT = $getTableFields[$tbl_name]['insertfields'][3];
		$CreatedBy = $getTableFields[$tbl_name]['insertfields'][4];
		$UpdatedBy = $getTableFields[$tbl_name]['insertfields'][5];
		$orderid = $getTableFields[$tbl_name]['insertfields'][6];
		$sql=$db->table($tbl_name)->insert(
				[$DBType => $request->textbox1,
				$DelFlg =>'0',
				$InsDT => date('Y-m-d H-i-s'),
				$UpDT => date('Y-m-d H-i-s'),
				$CreatedBy => Session::get('FirstName'),
				$UpdatedBy => Session::get('FirstName'),
				$orderid => $orderidval]
				);
		return  $sql;
	}

	/**  
	*  orderId generate For Single field popup
	*  @author sarath 
	*  @param $location,$tbl_name
	*  Created At 2020/08/25
	**/
	public static function Orderidgeneratefortotal($location,$tbl_name) {
		$db = DB::connection('mysql');
		$query = $db->TABLE($tbl_name)
					->max('id');
		return $query;
	}

	/**  
	*  orderId generate For Single field popup
	*  @author sarath 
	*  @param $tbl_name
	*  Created At 2020/08/25
	**/
	public static function Orderidgenerate($tbl_name) {
		$statement = DB::select("show table status like '$tbl_name'");
		return $statement[0]->Auto_increment;
	}

	/**  
	*  Update process For Single field popup
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/25
	**/
	public static function updateSingleField($request) {
		$getTableFields = settingcommon::getDbFieldsforProcess();
		$Typename = $getTableFields[$request->tablename]['updatefields'][0];
		$UpDT = $getTableFields[$request->tablename]['updatefields'][1];
		$UpdatedBy = $getTableFields[$request->tablename]['updatefields'][2];
		$db = DB::connection('mysql');
		$update = $db->table($request->tablename)
				->where('id', $request->id)
				->update(
				[$Typename => $request->textbox1,
				$UpDT => date('Y-m-d H-i-s'),
				$UpdatedBy => Session::get('FirstName')]
				);
		return $update;
	}

	/**
	*  For Use and Notuse for single field popup
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/27
	**/
	public static function updateUseNotUse($request) {
		$db = DB::connection('mysql');
		$getTableFields = settingcommon::getDbFieldsforProcess();
		$tablename = $request->tablename;
		$updfield = $getTableFields[$request->tablename]['usenotusefields'][0];
		if ($request->curtFlg == 0) {
			$upvalue = 1;
		} else {
			$upvalue = 0;
		} 
		$sql = $db->table($tablename)
					->where('id', $request->editid)
					->update([$updfield => $upvalue]);
		return $sql;
	}

	/**  
	*  Insert process For Two field popup
	*  @author sarath 
	*  @param $tbl_name,$request,$order_id
	*  Created At 2020/08/27
	**/
	public static function insertquerytwofield($tbl_name,$request,$order_id) {
		$db = DB::connection('mysql');
		$getTableFields = settingcommon::getDbFieldsforProcess();
		$DBType = $getTableFields[$tbl_name]['insertfields'][0];
		$DBType1 = $getTableFields[$tbl_name]['insertfields'][1];
		$DelFlg = $getTableFields[$tbl_name]['insertfields'][2];
		$InsDT = $getTableFields[$tbl_name]['insertfields'][3];
		$UpDT = $getTableFields[$tbl_name]['insertfields'][4];
		$CreatedBy = $getTableFields[$tbl_name]['insertfields'][5];
		$UpdatedBy = $getTableFields[$tbl_name]['insertfields'][6];
		$orderId = $getTableFields[$tbl_name]['insertfields'][7];
		$sql = $db->table($tbl_name)->insert([
					$DBType => $request->textbox1,
					$DBType1 => $request->textbox2,
					$orderId => $order_id,
					$DelFlg =>'0',
					$InsDT => date('Y-m-d H-i-s'),
					$UpDT => date('Y-m-d H-i-s'),
					$CreatedBy => Session::get('FirstName'),
					$UpdatedBy => Session::get('FirstName')]
				);
		return  $sql;
	}

	/**  
	*  Update process For Two field popup
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/25
	**/
	public static function updatetwoField($request) {
		$getTableFields = settingcommon::getDbFieldsforProcess();
		$Typename1 = $getTableFields[$request->tablename]['updatefields'][0];
		$Typename2 = $getTableFields[$request->tablename]['updatefields'][1];
		$UpDT = $getTableFields[$request->tablename]['updatefields'][2];
		$UpdatedBy = $getTableFields[$request->tablename]['updatefields'][3];
		$db = DB::connection('mysql');
		$update = $db->table($request->tablename)
			->where('id', $request->id)
			->update(
				[$Typename1 => $request->textbox1,
				$Typename2 => $request->textbox2,
				$UpDT => date('Y-m-d H-i-s'),
				$UpdatedBy => Session::get('FirstName')]
		);
		return $update;            
	}

	/**  
	*  Select process For Select Text Popup
	*  @author Sastha 
	*  @param $request
	*  Created At 2020/08/28
	**/
	public static function selectTwofieldDatas($fieldArray,$orderId,$selectfield=null,$request) {
		$db = DB::connection('mysql');
		$fieldNames = "";
		$mainfield = "";
		$con = "";
		if ($_REQUEST['tableselect'] != "" && $_REQUEST['tableselect'] != "text") {
			for ($i = 0; $i < count($fieldArray); $i++) {
				if ($i==2) {
					$con = " ON main.".$fieldArray[$i]." = sub.id";
					$mainfield = "main.".$fieldArray[$i];
					$fieldNames .= "sub.".$selectfield." AS ".$fieldArray[$i].",";
				} else {
					$fieldNames .= "main.".$fieldArray[$i].",";
				}
				if ($i == (count($fieldArray)-1)) {
					$fieldNames .= $mainfield." AS selectfield,";
				}
			}
			$maintbl = " FROM $_REQUEST[tablename] main";
			$join = " LEFT JOIN";
			$subtbl = " $_REQUEST[tableselect] sub";
			$orderby = " ORDER BY ".$orderId." ASC";
		}
		$fieldNames = rtrim($fieldNames, ',');
		if ($_REQUEST['tableselect'] != "" && $_REQUEST['tableselect'] != "text") {
			$sql = $db ->select("SELECT $fieldNames $maintbl $join $subtbl $con $orderby");
		}
		return $sql;
	}

	/**  
	*  Select process For other Popup
	*  @author Sastha 
	*  @param $request
	*  Created At 2020/08/28
	**/
	public static function selectboxDatas($selectfieldArray,$orderid,$request) {
		$db = DB::connection('mysql');
		$wheredelflg = "";
		$getTableFields = settingcommon::getDbFieldsforProcess();

		$wheredelflg = $getTableFields[$request->tablename]['usenotusefields'][0];
		$fieldNames = "";
		for ($i = 0; $i < count($selectfieldArray); $i++) {
			$fieldNames .= "".$selectfieldArray[$i].",";
		}
		$fieldNames = rtrim($fieldNames, ',');
		$idvalue = $selectfieldArray[0];
		$textvalue = $selectfieldArray[1];
		$query = $db->table($request->tableselect)
					->select(DB::raw($fieldNames))
					->where($wheredelflg,0);
		$query = $query->orderBy($selectfieldArray[0],'ASC')
					->lists($textvalue,$idvalue);
		return $query;
	}

	public static function checkforselecttext($request) {
		if ($request->tablename == "ams_master_expenses_sub") {
			$type1 = 'categoryId';
			$type2 = 'category';
		} else if($request->tablename == "ams_master_houseimg_sub") {
			$type1 = 'imageId';
			$type2 = 'imageName';
		}
		$db = DB::connection('mysql');
		$result= $db->TABLE($request->tablename)
					->select($type1,$type2)
					->WHERE($type1, '=', $request->selectbox1)
					->WHERE($type2, '=', $request->textbox1);
		if ($request->editid != 0) {
			$result = $result->WHERE('id', '!=', $request->editid);
		}
		$result = $result->get();
		return $result;
	}

	public static function updateselecttextField($request) {
		$getTableFields = settingcommon::getDbFieldsforProcess();
		$Typename1 = $getTableFields[$request->tablename]['updatefields'][0];
		$Typename2 = $getTableFields[$request->tablename]['updatefields'][1];
		$UpDT = $getTableFields[$request->tablename]['updatefields'][3];
		$UpdatedBy = $getTableFields[$request->tablename]['updatefields'][2];
		$db = DB::connection('mysql');
		$update = $db->table($request->tablename)
					->where('id', $request->id)
					->update(
					[$Typename1 => ucfirst($request->textbox1),
					$Typename2 => $request->selectbox1,
					$UpDT => date('Y-m-d H-i-s'),
					$UpdatedBy => Session::get('FirstName')]
		);
		return $update;            
	}

	public static function insertqueryforselecttextfield($tbl_name,$request,$orderidval) { 
		$getTableFields = settingcommon::getDbFieldsforProcess();
		$DBType1 = $getTableFields[$tbl_name]['insertfields'][0];
		$DBType2 = $getTableFields[$tbl_name]['insertfields'][1];
		$DelFlg = $getTableFields[$tbl_name]['insertfields'][2];
		$InsDT = $getTableFields[$tbl_name]['insertfields'][4];
		$UpDT = $getTableFields[$tbl_name]['insertfields'][6];
		$CreatedBy = $getTableFields[$tbl_name]['insertfields'][3];
		$UpdatedBy = $getTableFields[$tbl_name]['insertfields'][5];
		$orderid = $getTableFields[$tbl_name]['insertfields'][7];
		$insert= DB::table($request->tablename)->insert(
					[$DBType1 => ucfirst($request->textbox1),
					$DBType2 => $request->selectbox1,
					$DelFlg =>'0',
					$InsDT => date('Y-m-d H-i-s'),
					$UpDT => date('Y-m-d H-i-s'),
					$CreatedBy => Session::get('FirstName'),
					$UpdatedBy => Session::get('FirstName'),
					$orderid => $orderidval]
		);
		return $insert;
	}

	/**  
	*  For Commit Process for All popup
	*  @author Sarath 
	*  @param $request
	*  Created At 2020/09/21
	**/
	public static function fngetcommitProcess($request) {
		$tablename = $request->tablename;
		$getTableFields = settingcommon::getDbFieldsforProcess();
		$cmtfield = $getTableFields[$tablename]['commitfields'][0];
		$splitactualid = explode(",", $request->actualId);
		$splitidnew = explode(",", $request->idnew);
		$db = DB::connection('mysql');
		for ($i = 0; $i < count($splitactualid); $i++) {
			$update = $db->table($tablename)
						->where('id', $splitidnew[$i])
						->update([ $cmtfield => $splitactualid[$i] ]);
		}
		return true;
	}

}