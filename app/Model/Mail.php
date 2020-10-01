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
	* To view MailContent index
	* @author Sathish
	* Created At 01/10/2020
	* 
	* 
	*/
	public static function getMailContent($request) {
		$sql= DB::table('mailContent')
						->SELECT('mailContent.*','mailType.typeName')
						->leftjoin('mailType', 'mailContent.mailType', '=', 'mailType.id');
						if ($request->filvalhdn == 2) {
							$sql = $sql->where(function($joincont) use ($request) {
									$joincont->where('mailContent.delFlg', '=', '0');
									});
						}else if ($request->filvalhdn == 3) {
						$sql = $sql->where(function($joincont) use ($request) {
									$joincont->where('mailContent.delFlg', '=', '1');
									});
						} 
					$sql = $sql->orderBy('mailContent.mailId', 'ASC')
					->paginate($request->plimit);
		return $sql;
	}
	/**
	*
	* To view MailContent View
	* @author Sathish
	* Created At 01/10/2020
	* 
	* 
	*/
	public static function getMailcontentview($request){
		$sql= DB::table('mailContent')
				->SELECT('mailContent.*','mailType.typeName')
				->leftjoin('mailType', 'mailContent.mailType', '=', 'mailType.id')
				->WHERE('mailContent.mailId', '=', $request->mailid)
			  	->get();
		return $sql;
	}
	/**
	*
	* To Fetch MailType 
	* @author Sathish
	* Created At 01/10/2020
	* 
	* 
	*/
	public static function fnfetchmailtypes($request) {
		$sql= DB::table('mailType')
						->SELECT('*')
						->WHERE('delFlg', '=', 0)
						->lists('typeName','id');
			return $sql;
	}
	/**
	*
	* To Fetch After Update Record
	* @author Sathish
	* Created At 01/10/2020
	* 
	* 
	*/
	public static function fnfetchupdatedata($request){
		$sql= DB::table('mailContent')
						->SELECT('*')
						->WHERE('mailId', '=', $request->mailid)
						->get();
		return $sql;
	}
	/**
	*
	* To Update Delflg Value for use and non-use process
	* @author Sathish
	* Created At 01/10/2020
	* 
	* 
	*/
	public static function fnUpdateDelflg($request){
		$sql = DB::TABLE('mailContent')
				->WHERE('mailId', $request->mailid)
				->UPDATE(['delFlg' => $request->delflg]);
		return $sql;
	}
	/**
	*
	* To Fetch MaidId 
	* @author Sathish
	* Created At 01/10/2020
	* 
	* 
	*/
	public static function getcount(){
		   $query = DB::table('mailContent')
				->select('mailId',DB::RAW("IF(mailId=(SELECT mailId FROM mailContent
						ORDER BY id DESC LIMIT 1), CONCAT('MAIL', LPAD(SUBSTRING(mailId,5, 8)+1, 4, 0)),mailId) AS newmailId"))
				->orderby('mailId','DESC')
				->limit(1)
				->get();
				// ->toSql();dd($query);
			  return $query;
	}
	/**
	*
	* To Insert MailType Process
	* @author Sathish
	* Created At 01/10/2020
	* 
	* 
	*/
	public static function fninsertnewmailtype($request) {
			$name = Session::get('FirstName').' '.Session::get('LastName');
			$insert=DB::table('mailType')
			->insert(
				[
				'typeName' => $request->mailother,
				'delFlg' => 0,
				'createdDate' => date('Y-m-d'),
				'updatedDate' => date('Y-m-d'),
				'createdBy' => $name,
				'updatedBy' => $name]
		);
			$id = DB::getPdo()->lastInsertId();;
		return $id;
	}
	/**
	*
	* To Update MailContent Process
	* @author Sathish
	* Created At 01/10/2020
	* 
	* 
	*/
	public static function updMailcontent($request,$mailid,$mailTypeId) {
		$name = Session::get('FirstName').' '.Session::get('LastName');
			if ($request->mailtype == 999) {
				$mailtype = $mailTypeId;
			} else {
				$mailtype = $request->mailtype;
			}
			$update=DB::table('mailContent')
            ->where('mailId', $mailid)
            ->update(
            	['mailName' => $request->mailName,
				'mailType' => $mailtype,
				'content' => $request->content,
				'subject' => $request->subject,
				'defaultMail' => 0,
				'delFlg' => 0,
				'updatedDate' => date('Y-m-d'),
				'updatedBy' => $name]);
    	return $update;
	}
	/**
	*
	* To Insert MailContent Process
	* @author Sathish
	* Created At 01/10/2020
	* 
	* 
	*/
	public static function insMailcontent($request,$newmailId,$mailTypeId){
		$name = Session::get('FirstName').' '.Session::get('LastName');
		if ($request->mailtype == 999) {
				$mailtype = $mailTypeId;
			} else {
				$mailtype = $request->mailtype;
			}
		$sql = 	DB::table('mailContent')
					->insert(['mailId' => 	$newmailId,
						'mailName' 		=> 	$request->mailName,
						'mailType'		=> 	$mailtype,
						'subject'		=> 	$request->subject,							
						'content' 		=> 	$request->content,
						'defaultMail' 	=>  0,
						'createdBy'		=> 	$name,
						'createdDate'	=> 	date('Y-m-d H:m:s'),
						'updatedBy' 	=> 	$name,
						'updatedDate' 	=> 	date('Y-m-d H:m:s'),
						'delFlg' 		=>  0]);
		return $sql;
	}
}