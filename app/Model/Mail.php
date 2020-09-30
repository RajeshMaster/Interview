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
	public static function getMailstatus($request) {
		$sql = DB::TABLE('ams_mailstatus')
						->SELECT('ams_mailstatus.id', 'ams_mailstatus.userId',
								'ams_mailstatus.toMail', 'ams_mailstatus.subject',
								'ams_mailstatus.createdDateTime','ams_users.lastName',
								'ams_mailstatus.createdBy')
						->LEFTJOIN('ams_users','ams_mailstatus.userId','=','ams_users.userId')
						->WHERE('ams_mailstatus.delFlg',0)
						->orderBy('ams_mailstatus.createdDateTime','DESC')
						->paginate($request->plimit);
		return $sql;
	}

	/**
	*
	* To view MailStatus view
	* @author Sastha
	* Created At 26/08/2020
	* 
	*/
	public static function getMailview($request){
		$sql = DB::TABLE('ams_mailstatus AS mailstatus')
						->SELECT('mailstatus.userId','mailstatus.toMail',
								'mailstatus.subject','mailstatus.createdDateTime',
								'mailstatus.content','ams_users.lastName')
						->LEFTJOIN('ams_users','mailstatus.userId','=','ams_users.userId')
						->WHERE('mailstatus.delFlg',0)
						->WHERE('mailstatus.id',$request->mailid)
						->orderBy('mailstatus.createdDateTime','DESC')
						->get();
		return $sql;
	}

	/**
	*
	* To view MailContent index
	* @author Sastha
	* Created At 26/08/2020
	* 
	*/
	public static function getMailcontent($request) {
		$sql = DB::TABLE('ams_mailcontent')
				->SELECT('mailId', 'mailName','subject','delFlg');
				if ($request->filvalhdn == 2) {
						$sql = $sql->where(function($joincont) use ($request) {
									$joincont->where('delflg', '=', '0');
									});
				} else if ($request->filvalhdn == 3) {
						$sql = $sql->where(function($joincont) use ($request) {
									$joincont->where('delflg', '=', '1');
									});
				}
				if($request->searchmethod == 1) {
					// SINGLE SEARCH
					$sql = $sql->where(function($joincont) use ($request) {
						$joincont->where('mailId', 'LIKE', '%'.$request->singlesearch.'%')
								->orWhere('mailName', 'LIKE', '%'.$request->singlesearch.'%')
								->orWhere('subject', 'LIKE', '%'.$request->singlesearch.'%');
					});
				}
				$sql = $sql->orderBy($request->mailcontentsort, $request->sortOrder)
							->paginate($request->plimit);
		return $sql;
	}

	/**
	*
	* To Update delflg in MailContent
	* @author Sastha
	* Created At 26/08/2020
	* 
	*/
	public static function fnupdatedelflg($request) {
		$sql = DB::TABLE('ams_mailcontent')
				->WHERE('ams_mailcontent.mailId', $request->mailid)
				->UPDATE(['ams_mailcontent.delFlg' => $request->delflg]);
		return $sql;
	}

	/**
	*
	* To Get Count of MailId in MailContent
	* @author Sastha
	* Created At 26/03/2020
	* 
	*/
	public static function getcount(){
		   $query = DB::table('ams_mailcontent')
				->select('mailId',DB::RAW("IF(mailId=(SELECT mailId FROM ams_mailcontent
						ORDER BY id DESC LIMIT 1), CONCAT('MAIL', LPAD(SUBSTRING(mailId,5, 8)+1, 4, 0)),mailId) AS newmailId"))
				->orderby('mailId','DESC')
				->limit(1)
				->get();
				// ->toSql();dd($query);
			  return $query;
	}
	
	/**
	*
	* To Insert Mail content
	* @author Sastha
	* Created At 25/08/2020
	* 
	*/
	public static function insMailcontent($request,$newmailId){
		$sql = 	DB::table('ams_mailcontent')
					->insert([ 'mailId' => $newmailId,
						'mailName' 		=> $request->mailname,
						'mailType'		=> 	1,		
						'subject'		=> 	$request->mailSubject,							
						'header' 		=>  $request->mailheader,
						'content' 		=> 	$request->mailContent,
						'defaultMail' 	=>  0,
						'createdBy'		=> 	Auth::user()->loginId,
						'createdDate'	=> date('Y-m-d H:m:s'),
						'updatedBy' 	=> 	Auth::user()->loginId,
						'updatedDate' 	=> date('Y-m-d H:m:s'),
						'delFlg' 		=>  0]);
		return $sql;
	}

	
	/**
	*
	* To Get mailcontent for edit
	* @author Sastha
	* Created At 26/08/2020
	* 
	*/
	public static function getMailcontentindb($request,$mailid) {
		DB::setFetchMode(\PDO::FETCH_ASSOC);
		$mailDetails = DB::TABLE('ams_mailcontent')
						->SELECT('ams_mailcontent.id',
								'ams_mailcontent.mailId As mailId',
								'ams_mailcontent.mailName AS mailname',
								'ams_mailcontent.subject AS mailSubject',
								'ams_mailcontent.header AS mailheader',
								'ams_mailcontent.content AS mailContent')
						->WHERE('ams_mailcontent.mailId',$mailid)
						->WHERE('ams_mailcontent.delFlg',0)
						->GET();
		return $mailDetails[0];
	}

	/**
	*
	* To Update the mailcontent information
	* @author Sastha
	* Created At 25/08/2020
	* 
	*/
	public static function updMailcontent($request,$mailid) {
		$mailupdate = DB::TABLE('ams_mailcontent')
							->WHERE('mailId',$request->mailid)
							->update(['mailName' => $request->mailname,
								'subject' => $request->mailSubject,
								'header' => $request->mailheader,
								'content' => $request->mailContent,
								'updatedDate' => date('Y-m-d H:i:s')]);
						  return $mailupdate;
	}

	/**
	*
	* To view MailContent view
	* @author Sastha
	* Created At 25/08/2020
	* 
	*/
	public static function getMailcontentview($request) {
		$sql = DB::TABLE('ams_mailcontent AS mailcontent')
				->SELECT('mailcontent.mailId', 'mailcontent.mailName',
						'mailcontent.mailType','mailcontent.subject',
						'mailcontent.header','mailcontent.content','mailcontent.delFlg')
				->WHERE('mailcontent.mailId', $request->mailid)
				->GET();
		return $sql;
	}

	
}