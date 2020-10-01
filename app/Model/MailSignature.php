<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Session;
use Config;
class MailSignature extends Model {	

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
	public static function fnUpdateDelflg($request){
		$sql = DB::TABLE('mailsignature')
				->WHERE('id', $request->signatureId)
				->UPDATE(['delFlg' => $request->delflg]);
		return $sql;
	}
	public static function getMailSignatureView($request){
		$query= DB::table('mailsignature')
						->SELECT('mailsignature.*','user.nickName','user.usercode','user.givenname','user.username')
						->LEFTJOIN('dev_mstuser as user','user.usercode','=','mailsignature.user_ID')
						->WHERE('mailsignature.id', '=', $request->signatureId)
					  	->get();
		return $query;
	}
}