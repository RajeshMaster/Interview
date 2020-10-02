<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Session;
use Config;
class MailSignature extends Model {	
	/**
	*
	* To view MailSignature Index Page
	* @author Sathish
	* Created At 02/10/2020
	*
	*/
	public static function getMailSignatureData($request){
		$sql= DB::table('mailsignature')
						->SELECT('mailsignature.*','user.nickName','user.usercode','user.givenname','user.username')
						->LEFTJOIN('dev_mstuser as user','user.usercode','=','mailsignature.user_ID');
						if ($request->filvalhdn == 2) {
							$sql = $sql->where(function($joincont) use ($request) {
									$joincont->where('mailsignature.delFlg', '=', '0');
									});
						}else if ($request->filvalhdn == 3) {
						$sql = $sql->where(function($joincont) use ($request) {
									$joincont->where('mailsignature.delFlg', '=', '1');
									});
						} 
					$sql= $sql->orderBy('signId', 'ASC')
					  	->paginate($request->plimit);
		return $sql;
	}
	/**
	*
	* To Update DelFlg
	* @author Sathish
	* Created At 02/10/2020
	*
	*/
	public static function fnUpdateDelflg($request){
		$sql = DB::TABLE('mailsignature')
				->WHERE('id', $request->signatureId)
				->UPDATE(['delFlg' => $request->delflg]);
		return $sql;
	}
	/**
	*
	* To View MailSignature View
	* @author Sathish
	* Created At 02/10/2020
	*
	*/
	public static function getMailSignatureView($request){
		$query= DB::table('mailsignature')
						->SELECT('mailsignature.*','user.nickName','user.usercode','user.givenname','user.username')
						->LEFTJOIN('dev_mstuser as user','user.usercode','=','mailsignature.user_ID')
						->WHERE('mailsignature.id', '=', $request->signatureId)
					  	->get();
		return $query;
	}
	/**
	*
	* To Fetch UserDetails
	* @author Sathish
	* Created At 02/10/2020
	*
	*/
	public static function fnGetUserDetails($request) {
		$query= DB::table('dev_mstuser')
					->SELECT('usercode','userid','username','givenname','nickName')
					->WHERE('delflg', '=', 0)
					->orderBy('usercode', 'ASC')
				  	->get();
		return $query;
	}
	/**
	*
	* To Fetch MailSignature Data
	* @author Sathish
	* Created At 02/10/2020
	*
	*/
	public static function fnFetchMailSigdata($request){
		$query= DB::table('mailsignature')
						->SELECT('user_ID',
								'content')
						->WHERE('user_ID', '=', $request->userid)
					  	->get();
		return $query;
	}
	/**
	*
	* To MailSignatureID Generate Process
	* @author Sathish
	* Created At 02/10/2020
	*
	*/
	public static function signIdGenerate($request){
		$query = DB::select("SELECT CONCAT('SIGN', LPAD(MAX(SUBSTRING(signID,5))+1,5,0)) AS signid FROM mailsignature WHERE signID LIKE '%SIGN%'");
		return $query;
	}
	/**
	*
	* To Insert MailSignature Process
	* @author Sathish
	* Created At 02/10/2020
	*
	*/
	public static function fnInsertMailSignature($request,$signatureId) {
		$name = Session::get('FirstName').' '.Session::get('LastName');
		$insert=DB::table('mailsignature')
		->insert(
			[
			'signID' => $signatureId,
			'user_ID' => $request->userid,
			'content' => $request->content,
			'delFlg' => 0,
			'Ins_DT' => date('Y-m-d'),
			'UP_DT' => date('Y-m-d'),
			'createdBy' => $name,
			'updatedBy' => $name]);
		$id = DB::getPdo()->lastInsertId();;
		return $id;
	}
	/**
	*
	* To Fetch MailSignature Data After Update
	* @author Sathish
	* Created At 02/10/2020
	*
	*/
	public static function fnFetchUpdateData($request){
		$result= DB::table('mailsignature')
						->SELECT('mailsignature.*','user.nickName','user.usercode','user.givenname','user.username')
						->LEFTJOIN('dev_mstuser as user','user.usercode','=','mailsignature.user_ID')
						->WHERE('mailsignature.id', '=', $request->signatureId)
						->get();
		return $result;
	}
	/**
	*
	* To Fetch MailSignature ID
	* @author Sathish
	* Created At 02/10/2020
	*
	*/
	public static function fnFetchViewData($request,$id){
		$query= DB::table('mailsignature')
						->SELECT('*')
						->WHERE('user_ID', '=', $id)
					  	->get();
		return $query;
	}
	/**
	*
	* To Update MailSignature Data
	* @author Sathish
	* Created At 02/10/2020
	*
	*/
	public static function fnUpdateMailSignature($request,$id){
		$name = Session::get('FirstName').' '.Session::get('LastName');
		$update=DB::table('mailsignature')
				->where('id', $id)
				->update(
				['content' => $request->content,
				'delFlg' => 0,
				'UP_DT' => date('Y-m-d'),
				'updatedBy' => $name]);
	return $update;
	}
}