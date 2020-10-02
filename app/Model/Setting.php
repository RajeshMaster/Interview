<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Input;
use App;
use Auth;
use App\Http\Common\settingscommon;
class Setting extends Model { 
    /**  
    *  Get Record From DataBase
    *  @author Easa 
    *  @param $fieldArray,$orderid,$request
    *  Created At 2020/10/01
    **/
    public static function selectOnefieldDatas($fieldArray,$orderid,$request) {
        $db = DB::connection('mysql');
        $fieldNames="";
        for ($i=0; $i < count($fieldArray); $i++) {
            $fieldNames .= "".$fieldArray[$i].",";
        }
        $fieldNames = rtrim($fieldNames, ',');
        if ($request->tablename == 'sysunfixedreason') {
            $query = $db->table($request->tablename)
                ->select(DB::raw($fieldNames))
                ->orderBy($orderid,'ASC')
                ->get();
        } else {
           $query = $db->table($request->tablename)
                ->select(DB::raw($fieldNames))
                ->orderBy($orderid,'ASC')
                ->get();
        }
        return $query;
    }

    /**  
    *  Exists check For Single field popup
    *  @author Easa 
    *  @param $request,$getTableFields
    *  Created At 2020/10/01
    **/
    public static function chkNameExists($request,$getTableFields) {
        $db = DB::connection('mysql');
        $table_name = $request->tablename;
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
    *  For Commit Process for All popup
    *  @author Easa 
    *  @param $request,$getTableFields
    *  Created At 2020/09/21
    **/
    public static function fngetcommitProcess($request,$getTableFields) {
        $tablename = $request->tablename;
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

	public static function Orderidgenerateforbank($location,$tbl_name) {
        $db = DB::connection('mysql');
        $query = $db->TABLE($tbl_name)
                    ->WHERE('location','=', $location)
                    ->count('id');
        return $query;            
    }

    /** Get OrderId
    *  @author Easa 
    *  @param $request
    *  Created At 2020/10/01
    */
    public static function selectOrderId($request) {
        $db = DB::connection('mysql');
        $query = $db->table($request->tablename);
        if ($request->tablename == "emp_roletypes") {
            $query =$query->select('orderId AS orderId')
            ->orderBy('orderId','ASC');
        } else {
            $query =$query->select('Order_id AS orderId')
            ->orderBy('Order_id','ASC');  
        }
                    
        $query =$query->get();
        return $query;
    }

    /** Get maximum ID Count
    *  @author Easa 
    *  @param $location,$tbl_name
    *  Created At 2020/10/01
    */
    public static function Orderidgeneratefortotal($location,$tbl_name) {
        $db = DB::connection('mysql');
        $query = $db->TABLE($tbl_name);
            if ($location != '') {
                $query =$query->WHERE('location','=', $location);
            }
            $query =$query->max('id');
        return $query;            
    }

    /**  
     *  Get Maximum ID
     *  @author Easa
     *  @param $location,$tbl_name
     *  Created At 2020/10/01
     **/
    public static function Orderidgenerateforbranchtotal($location,$tbl_name) {
        $db = DB::connection('mysql');
        $query = $db->TABLE($tbl_name)
                    ->max('id');
        return $query;            
    }

    /** Order ID Generate
    *  @author Easa 
    *  @param $tbl_name
    *  Created At 2020/10/01
    */
    public static function Orderidgenerate($tbl_name) {
        $statement = DB::select("show table status like '$tbl_name'");
        return $statement[0]->Auto_increment;
    }

    public static function insertqueryforbranch($tbl_name,$request) { 
        $db = DB::connection('mysql');
        $getTableFields = settingscommon::getDbFieldsforProcess();
        $DBTypeCD = $getTableFields[$tbl_name]['insertfields'][0];
        $DBType1 = $getTableFields[$tbl_name]['insertfields'][1];
        $DBType2 = $getTableFields[$tbl_name]['insertfields'][2];
        $DelFlg = $getTableFields[$tbl_name]['insertfields'][3];
        $InsDT = $getTableFields[$tbl_name]['insertfields'][4];
        $UpDT = $getTableFields[$tbl_name]['insertfields'][5];
        $CreatedBy = $getTableFields[$tbl_name]['insertfields'][6];
        $UpdatedBy = $getTableFields[$tbl_name]['insertfields'][7];
        $fieldcount = count($getTableFields[$tbl_name]['insertfields']);
        $CreatedByname = Session::get('FirstName');
        $sql= $db->table($tbl_name)->insert(
                [$DBTypeCD => $request->selectbox1,
                $DBType1 => $request->textbox1,
                $DBType2 => $request->textbox2,
                $DelFlg =>'0',
                $InsDT => date('Y-m-d H-i-s'),
                $UpDT => date('Y-m-d H-i-s'),
                $CreatedBy => $CreatedByname,
                $UpdatedBy => $CreatedByname]
        );
        return  $sql;
    }

    /**  
     *  Single Text Insert Process
     *  @author Easa
     *  @param $tbl_name,$request,$order_id
     *  Created At 2020/10/01
     **/
    public static function insertquery($tbl_name,$request,$order_id) {
        $db = DB::connection('mysql');
        $getTableFields = settingscommon::getDbFieldsforProcess();
        $DBType = $getTableFields[$tbl_name]['insertfields'][0];
        $DelFlg = $getTableFields[$tbl_name]['insertfields'][1];
        $InsDT = $getTableFields[$tbl_name]['insertfields'][2];
        $UpDT = $getTableFields[$tbl_name]['insertfields'][3];
        $CreatedBy = $getTableFields[$tbl_name]['insertfields'][4];
        $UpdatedBy = $getTableFields[$tbl_name]['insertfields'][5];
        $orderId = $getTableFields[$tbl_name]['insertfields'][6];
        $CreatedByname = Session::get('FirstName');
        if ($tbl_name == 'sysunfixedreason' || $tbl_name == 'language_skill' || $tbl_name == 'jplanguage_skill') {
            $sql=$db->table($tbl_name)->insert(
                [$DBType => $request->textbox1,
                $DelFlg =>'0',
                $orderId =>$order_id,
                $CreatedBy => $CreatedByname,
                $UpdatedBy => $CreatedByname]
            );
        } else {
            $DBTypeCD = $getTableFields[$tbl_name]['insertfields'][7];
            $sql=$db->table($tbl_name)->insert(
                [$DBType => $request->textbox1,
                $DBTypeCD => $order_id,
                $DelFlg => '0',
                $orderId => $order_id,
                $CreatedBy => $CreatedByname,
                $UpdatedBy => $CreatedByname]
            );
        }
        return  $sql;
    }

    /**  
     *  Two Text Insert Process
     *  @author Easa
     *  @param $tbl_name,$request,$order_id
     *  Created At 2020/10/01
     **/
    public static function insertquerytwofield($tbl_name,$request,$order_id) {
        $db = DB::connection('mysql');
        $getTableFields = settingscommon::getDbFieldsforProcess();
        $DBType = $getTableFields[$tbl_name]['insertfields'][0];
        $DBType1 = $getTableFields[$tbl_name]['insertfields'][1];
        $DelFlg = $getTableFields[$tbl_name]['insertfields'][2];
        $InsDT = $getTableFields[$tbl_name]['insertfields'][3];
        $UpDT = $getTableFields[$tbl_name]['insertfields'][4];
        $CreatedBy = $getTableFields[$tbl_name]['insertfields'][5];
        $UpdatedBy = $getTableFields[$tbl_name]['insertfields'][6];
        $orderId = $getTableFields[$tbl_name]['insertfields'][7];
        $DBTypeCD = $getTableFields[$tbl_name]['insertfields'][8];
        $CreatedByname = Session::get('FirstName');
        $sql = $db->table($tbl_name)->insert([
                    $DBType => $request->textbox1,
                    $DBType1 => $request->textbox2,
                    $DBTypeCD => $order_id,
                    $orderId => $order_id,
                    $DelFlg =>'0',
                    $InsDT => date('Y-m-d H-i-s'),
                    $UpDT => date('Y-m-d H-i-s'),
                    $CreatedBy => $CreatedByname,
                    $UpdatedBy => $CreatedByname]
                );
        return  $sql;
    }

    /**  
     *  Two Text Group Insert Process
     *  @author Easa
     *  @param $tbl_name,$request,$order_id
     *  Created At 2020/10/01
     **/
    public static function insertquerytwofieldgrp($tbl_name,$request,$order_id) {
        $db = DB::connection('mysql');
        $getTableFields = settingscommon::getDbFieldsforProcess();
        $DBType = $getTableFields[$tbl_name]['insertfields'][0];
        $DBType1 = $getTableFields[$tbl_name]['insertfields'][1];
        $DelFlg = $getTableFields[$tbl_name]['insertfields'][2];
        $InsDT = $getTableFields[$tbl_name]['insertfields'][3];
        $UpDT = $getTableFields[$tbl_name]['insertfields'][4];
        $CreatedBy = $getTableFields[$tbl_name]['insertfields'][5];
        $UpdatedBy = $getTableFields[$tbl_name]['insertfields'][6];
        $orderId = $getTableFields[$tbl_name]['insertfields'][7];
        $CreatedByname = Session::get('FirstName');
        $sql = $db->table($tbl_name)->insert([
                    $DBType => $request->textbox1,
                    $DBType1 => $request->textbox2,
                    $orderId => $order_id,
                    $DelFlg =>'0',
                    $InsDT => date('Y-m-d H-i-s'),
                    $UpDT => date('Y-m-d H-i-s'),
                    $CreatedBy => $CreatedByname,
                    $UpdatedBy => $CreatedByname]
                );
        return  $sql;
    }

    /**  
     *  Single Text Update Process
     *  @author Easa
     *  @param $request
     *  Created At 2020/10/01
     **/
    public static function updateSingleField($request) {
        $getTableFields = settingscommon::getDbFieldsforProcess();
        $Typename = $getTableFields[$request->tablename]['updatefields'][0];
        // if ($request->tablename == 'sysunfixedreason') {
            $UpdatedBy = $getTableFields[$request->tablename]['updatefields'][1];
        /*} else {
            $UpdatedBy = $getTableFields[$request->tablename]['updatefields'][1];
        }*/
        $db = DB::connection('mysql');
        $CreatedByname = "Sathish Kumar";
        // if ($request->tablename == 'sysunfixedreason') {
              $update = $db->table($request->tablename)
            ->where('id', $request->id)
            ->update(
                [$Typename => $request->textbox1,
                $UpdatedBy => $CreatedByname]
            );
        /*} else {
            $update = $db->table($request->tablename)
            ->where('id', $request->id)
            ->update(
                [$Typename => $request->textbox1,
                $UpDT => date('Y-m-d H-i-s'),
                $UpdatedBy => $CreatedByname]
            );
        }*/
        return $update;            
    }

    /**  
     *  Two Text Update Process
     *  @author Easa
     *  @param $request
     *  Created At 2020/10/01
     **/
    public static function updatetwoField($request) {
        $getTableFields = settingscommon::getDbFieldsforProcess();
        $Typename1 = $getTableFields[$request->tablename]['updatefields'][0];
        $Typename2 = $getTableFields[$request->tablename]['updatefields'][1];
        $UpDT = $getTableFields[$request->tablename]['updatefields'][2];
        $UpdatedBy = $getTableFields[$request->tablename]['updatefields'][3];
        $db = DB::connection('mysql');
        $CreatedByname = Session::get('FirstName');
        $update = $db->table($request->tablename)
            ->where('id', $request->id)
            ->update(
                [$Typename1 => $request->textbox1,
                $Typename2 => $request->textbox2,
                $UpDT => date('Y-m-d H-i-s'),
                $UpdatedBy => $CreatedByname]
        );
        return $update;            
    }
    public static function updatethreeField($request) {
        $getTableFields = settingscommon::getDbFieldsforProcess();
        $selectbox1 = $getTableFields[$request->tablename]['updatefields'][0];
        $Typename1 = $getTableFields[$request->tablename]['updatefields'][1];
        $Typename2 = $getTableFields[$request->tablename]['updatefields'][2];
        $UpDT = $getTableFields[$request->tablename]['updatefields'][3];
        $UpdatedBy = $getTableFields[$request->tablename]['updatefields'][4];
        $db = DB::connection('mysql');
        $CreatedByname = Session::get('FirstName');
        $update = $db->table($request->tablename)
            ->where('id', $request->id)
            ->update(
                [$selectbox1 => $request->selectbox1,
                $Typename1 => $request->textbox1,
                $Typename2 => $request->textbox2,
                $UpDT => date('Y-m-d H-i-s'),
                $UpdatedBy => $CreatedByname]
        );
        return $update;            
    }

    /**  
     *  Use/Not Use Process
     *  @author Easa
     *  @param $request,$getTableFields
     *  Created At 2020/10/01
     **/
    public static function updateUseNotUse($request,$getTableFields) {
        $db = DB::connection('mysql');
        //$getTableFields = settingscommon::getDbFieldsforProcess();
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
                print_r($request->editid);
        return $sql;
    }
    public static function selectTwofieldDatas($fieldArray,$orderid,$request) {
        $fieldNames="";
        $mainfield="";
        $db = DB::connection('mysql');
        $con="";
        if ($request->tableselect!="" && $request->tableselect!="text") {
            for ($i=0; $i < count($fieldArray); $i++) {
                if ($i==2) {
                    $con=" ON main.".$fieldArray[$i]."=sub.id";
                    $mainfield="main.".$fieldArray[$i];
                    $fieldNames .= "sub.".$selectfield." AS ".$fieldArray[$i].",";
                } else {
                    $fieldNames .= "main.".$fieldArray[$i].",";
                }
                if ($i==(count($fieldArray)-1)) {
                    $fieldNames .= $mainfield." AS selectfield,";
                }
            }
            $maintbl=" FROM $request->tablename main";
            $join=" LEFT JOIN";
            $subtbl=" $request->tableselect sub";
            $orderby=" ORDER BY ".$orderid." ASC";
        } else {
            for ($i=0; $i < count($fieldArray); $i++) { 
                $fieldNames .= $fieldArray[$i].",";
            }
        }
        $fieldNames = rtrim($fieldNames, ',');
        if ($request->tableselect!="" && $request->tableselect!="text") {
            $sql = $db ->select("SELECT $fieldNames $maintbl $join $subtbl $con $orderby");
        } else {
            $sql = $db ->select("SELECT $fieldNames FROM $_REQUEST[tablename] ORDER BY $orderid ASC");
        }
        $bypopupAjax = 1;
        return $sql;
    }
    public static function selectthreefieldDatasforbank($fieldArray,$orderid,$selectfield=null,$request) {
        $db = DB::connection('mysql');
        $location="";
        $fieldNames="";
        $mainfield="";
        $con="";
        for ($i=0; $i < count($fieldArray); $i++) {
            if ($i==1) {
                $con=" ON main.".$fieldArray[$i]."=sub.id";
                $mainfield="main.".$fieldArray[$i];
                $fieldNames .= "sub.".$selectfield." AS ".$fieldArray[$i].",";
            } else {
                $fieldNames .= "main.".$fieldArray[$i].",";
            }
            if ($i==(count($fieldArray)-1)) {
                $fieldNames .= $mainfield." AS selectfield,";
            }
        }
        $maintbl=" FROM $request->tablename main";
        $join=" LEFT JOIN ";
        $subtbl=" $request->tableselect sub";
        $cond=" WHERE sub.location=".$request->location;
        $fieldNames = rtrim($fieldNames, ',');
        $query = $db->select("SELECT $fieldNames $maintbl $join $subtbl $con $cond");
        return $query;
    }
    public static function selectthreefieldDatas($fieldArray,$orderid,$selectfield,$request) {
        $db = DB::connection('mysql');
        $fieldNames="";
        $mainfield="";
        $con="";
        for ($i=0; $i < count($fieldArray); $i++) {
            if ($i==1) {
                $con=" ON main.".$fieldArray[$i]."=sub.id";
                $mainfield="main.".$fieldArray[$i];
                /*if ($request->tablename == "inv_set_salarysub") {
                    $fieldNames .= "sub."."main_eng"." AS ".$fieldArray[$i].",";
                } else {*/
                    $fieldNames .= "main.".$selectfield." AS ".$fieldArray[$i].",";
                // }
            } else {
                $fieldNames .= "main.".$fieldArray[$i].",";
            }
            if ($i==(count($fieldArray)-1)) {
                $fieldNames .= $mainfield." AS selectfield,";
            }
        }
        $maintbl=" FROM $request->tablename main";
        $join=" LEFT JOIN ";
        $subtbl=" $request->tableselect sub";
        $fieldNames = rtrim($fieldNames, ',');
        $query = $db->select("SELECT $fieldNames $maintbl $join $subtbl $con");
        return $query;
    }
    public static function selectboxDatas($selectfieldArray,$orderid,$request) {
        $db = DB::connection('mysql');
        $wheredelflg="";
        $getTableFields = settingscommon::getDbFieldsforProcess();
        $wheredelflg = $getTableFields[$request->tablename]['usenotusefields'][0];
        $fieldNames="";
        for ($i=0; $i < count($selectfieldArray); $i++) {
            $fieldNames .= "".$selectfieldArray[$i].",";
        }
        if ($request->tableselect == "mstbanks") {
            if ($request->location==2) {
                $location=2;
            } else {
                $location=1;
            }
        }
        $fieldNames = rtrim($fieldNames, ',');
        $idvalue = $selectfieldArray[0];
        $textvalue = $selectfieldArray[1];
        $query = $db->table($request->tableselect)
                    ->select(DB::raw($fieldNames))
                    ->where($wheredelflg,0);
                    if ($request->location != "") {
                        $query=$query->where('location',$location);
                    }
        $query=$query->orderBy($selectfieldArray[0],'ASC')
                    ->lists($textvalue,$idvalue);
        return $query;
    }

    /**  
     *  Get Customer Group Details
     *  @author Easa
     *  Created At 2020/10/01
     **/
    public static function fnGetgroup(){
		$db = DB::connection('mysql');
		$result = DB::TABLE('mst_cus_group')
				->select('id','groupId','groupName','delFlg')
				->get();
		return $result;
	}

    /**  
     *  Get Maximum Group ID
     *  @author Easa
     *  Created At 2020/10/01
     **/
	public static function getmaxid() {
		$db = DB::connection('mysql');
		$maxid = DB::table('mst_cus_group')
				->max('groupId');
		return $maxid;
	}

    /**  
     *  Insert Customer Group
     *  @author Easa
     *  @param $newgroupId,$request
     *  Created At 2020/10/01
     **/
	public static function insGrpDtls($newgroupId,$request) {
		$insert = DB::table('mst_cus_group')
					->insert([
						'groupId' => $newgroupId,
						'groupName' => $request->grpName,
						'createdBy' => Session::get('FirstName'),
						'updatedBy' => Session::get('FirstName'),
					]);
		return $insert; 
	}

    /**  
     *  Update Customer Group
     *  @author Easa
     *  @param $request
     *  Created At 2020/10/01
     **/
	public static function updGrpDtls($request) {
		$db = DB::connection('mysql');
		$update = DB::table('mst_cus_group')
			->where('groupId', $request->groupId)
			->update(['groupName' => $request->grpName]);
		return $update;
	}

    /**  
     *  Flag Change Process
     *  @author Easa
     *  @param $request
     *  Created At 2020/10/01
     **/
	public static function flagchange($request) {
		$db = DB::connection('mysql');
		if ($request->curtFlg == 0) {
			$upvalue = 1;
		} else {
			$upvalue = 0;
		} 
		$result = DB::TABLE('mst_cus_group')
				->where('id','=',$request->editid)
				->update(['delFlg' => $upvalue]);
		return $result;
	}
    
	public static function fnGetCus($groupId){
		$db = DB::connection('mysql');
		$result = DB::TABLE('mst_customerdetail')
				->select('customer_id','customer_name')
				->where('groupId',$groupId)
				->get();
		return $result;
	}
	public static function getonlymaxid() {
        $db = DB::connection('mysql');
        $maxid = DB::table('mst_cus_group')
                ->max('id');
        return $maxid;
    }
     public static function fnGetrequirment(){
        $db = DB::connection('mysql');
        $result = DB::TABLE('requirmentSetting')
                ->select('id','Requirment','commShow','delFlg')
                ->get();
        return $result;
    }
    public static function insreqDtls($data) {
        $db = DB::connection('mysql');
        $retunval=$db->table('requirmentSetting')
                    ->updateOrInsert(
                    [
                    'id' => $data['id'],
                    ],
                    $data
                    );
        return $retunval;
    }
    public static function getonlymaxidrequirment() {
        $db = DB::connection('mysql');
        $maxid = DB::table('requirmentSetting')
                ->max('id');
        return $maxid;
    }
    public static function delflgforrrquirment($request) {
        $db = DB::connection('mysql');
        if ($request->curtFlg == 0) {
            $upvalue = 1;
        } else {
            $upvalue = 0;
        } 
        $result = DB::TABLE('requirmentsetting')
                ->where('id','=',$request->editid)
                ->update(['delFlg' => $upvalue]);
        return $result;
    }
    public static function fnGetOldRecords($table){
        $db = DB::connection('otherdb');
        $query = $db->table($table)
                ->SELECT('*')
                ->get();
        return $query;
    }
    public static function fnUpdateOrInsert($tableName,$oldRecordAsArray) {
        $db = DB::connection('mysql');
        $update = $db->table($tableName)
                ->updateOrInsert(
                  [
                    'id' => $oldRecordAsArray['id'],
                  ],
                  $oldRecordAsArray
                );
        return $update;
    }
    public static function fnGetConnectionQuery($request){
            $db = DB::connection('mysql');
            $query= DB::table('olddbdetailsregistration')
                            ->SELECT('*')
                            ->where([['Delflg', '=', 0],['id', '=', $request->contentsel]])
                            ->get();
            return $query;
    } 
    public static function fnOldDbDetails(){
        $db = DB::connection('mysql');
        $result= DB::table('olddbdetailsregistration')
                        ->SELECT('*')
                        ->WHERE('Delflg', '=', 0)
                        ->lists('DBName','id');
        return $result;
    }
}