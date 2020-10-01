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
						->LEFTJOIN('dev_mstuser as user','user.usercode','=','mailsignature.user_ID')
						->orderBy('signId', 'ASC')
					  	->paginate($request->plimit);
					  	//print_r($sql);exit();
		return $sql;
	}
}