<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Session;
use Config;
class Bank extends Model {	

	/**
	*
	* To User Bank Details
	* @author Sastha
	* @param $request,$flg
	* Created At 2020/08/27
	* 
	*/
	public static function getUserBankDetails($request,$flg) {
		$sql = DB::TABLE('ams_bank_details as bankDetails')
						->SELECT('bankDetails.id','user.lastName',
								'bankDetails.kanaName', 'bankDetails.accountNo',
								'bankNameMst.bankName','bankNameMst.nickName',
								'bankDetails.branchName','bankDetails.branchNo',
								'bankDetails.mainFlg','bankNameMst.id as bankId',
								'familyMst.id as familyId','familyMst.familyName',
								'buildingMst.id as houseId','buildingMst.buildingName',
								'bankDetails.createdDateTime','bankDetails.bankUserName')
						->LEFTJOIN('ams_users as user','bankDetails.userId','=','user.userId')
						->LEFTJOIN('ams_bankname_master as bankNameMst','bankDetails.bankName','=','bankNameMst.id')
						->LEFTJOIN('ams_family_master as familyMst','bankDetails.belongsTo','=','familyMst.id')
						->LEFTJOIN('ams_master_buildingname as buildingMst','bankDetails.houseId','=','buildingMst.id')
						->WHERE('bankDetails.delFlg',0)
						->WHERE('bankDetails.userId',$request->userId);
		if (isset($request->bankId) && $request->bankId != "") {
			$sql = $sql->WHERE('bankDetails.id', '=', $request->bankId);
		}
		if($flg == 2) {
			$sql = $sql->WHERE('bankDetails.mainFlg', '=', 0)
						->orderBy('bankDetails.belongsTo','ASC')
						->paginate($request->plimit);
		} else if($flg == 3){
			$sql = $sql->WHERE('bankDetails.mainFlg', '=', 1)
						->orderBy('bankDetails.houseId','ASC')
						->paginate($request->plimit);
		} else {
			$sql = $sql ->get();
		}
		return $sql;
	}

	/**  
	*  User Details
	*  @author Sastha 
	*  @param $userId
	*  Created At 2020/08/27
	**/
	public static function fnGetUserDetails($userId){
		$db = DB::connection('mysql');
		$query = $db->table('ams_users')
					->select('*')
					->where('userId', '=', $userId)
					->get();
		return $query;
	}

	/**  
	*  Bank Insert
	*  @author Sastha 
	*  @param $request
	*  Created At 2020/08/27
	**/
	public static function insertBankDetails($request){
		$db = DB::connection('mysql');
		$insert = $db->table('ams_bank_details')
					->insert(['userId' => $request->userId,
								'kanaName' => $request->kanaName,
								'bankUserName' => $request->bankUserName,
								'accountNo' => $request->accountNo,
								'bankName' => $request->bankName,
								'bankNickName' => $request->bankNickName,
								'branchName' => $request->branchName,
								'branchNo' => $request->branchNo,
								'createdBy' => Session::get("FirstName"),
							]);
		$bankId = self::getlatestBankDetails();
		if ($request->pageview == "bankAddEdit") {
			$update = $db->table('ams_bank_details')
					->where('id', $bankId)
					->update(['belongsTo' => $request->belongsTo,
								'mainFlg' => 0,
								'updatedBy' => Session::get("FirstName"),
							]);
		} else {
			$update = $db->table('ams_bank_details')
					->where('id', $bankId)
					->update(['houseId' => $request->houseId,
								'mainFlg' => 1,
								'updatedBy' => Session::get("FirstName"),
							]);
		}
		return $insert;
	}

	/**  
	*  Bank Update
	*  @author Sastha 
	*  @param $request
	*  Created At 2020/08/27
	**/
	public static function updateBankDetails($request) {
		$db = DB::connection('mysql');
		$update = $db->table('ams_bank_details')
					->where('id', $request->bankId)
					->update(['userId' => $request->userId,
								'kanaName' => $request->kanaName,
								'bankUserName' => $request->bankUserName,
								'accountNo' => $request->accountNo,
								'bankName' => $request->bankName,
								'bankNickName' => $request->bankNickName,
								'branchName' => $request->branchName,
								'branchNo' => $request->branchNo,
								'belongsTo' => $request->belongsTo,
								'houseId' => $request->houseId,
								'updatedBy' => Session::get("FirstName"),
							]);
		return $update;

	}

	/**  
	*  Latest Bank Details
	*  @author Sastha 
	*  @param 
	*  Created At 2020/08/27
	**/
	public static function getlatestBankDetails() {
		$db = DB::connection('mysql');
		$latDetails = $db->table('ams_bank_details')->max('id');
		return $latDetails;
	}

	
}