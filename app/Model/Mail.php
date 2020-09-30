<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Session;
use Config;
class Mail extends Model {	

	/**
	*
	* To view MailStatus index
	* @author Mayandi
	* Created At 26/08/2020
	* 
	* 
	*/
	public static function getMailContent($request) {
		$sql= DB::table('mailContent')
						->SELECT('mailContent.*','mailType.typeName')
						->leftjoin('mailType', 'mailContent.mailType', '=', 'mailType.id')
						->WHERE('mailContent.delFlg', '=', 0)
						->orderBy('mailContent.mailId', 'ASC')
					  	->paginate($request->plimit);
		return $sql;
	}
	
	public static function getMailcontentview($request){
		$sql= DB::table('mailContent')
				->SELECT('mailContent.*','mailType.typeName')
				->leftjoin('mailType', 'mailContent.mailType', '=', 'mailType.id')
				->WHERE('mailContent.mailId', '=', $request->mailid)
			  	->get();
		return $sql;
	}

	public static function fnfetchmailtypes($request) {
		$sql= DB::table('mailType')
						->SELECT('*')
						->WHERE('delFlg', '=', 0)
						->lists('typeName','id');
			return $sql;
	}

	public static function fnfetchupdatedata($request){
		$sql= DB::table('mailContent')
						->SELECT('*')
						->WHERE('mailId', '=', $request->mailid)
						->get();
		return $sql;
	}
}