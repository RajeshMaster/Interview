<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Model\Mail;
use Redirect;
use Session;
use Input;
use Config;
use Carbon;
use File;
use Storage;
use View;
use Illuminate\Support\Facades\Validator;

/*Class: MailController
Some functions related to display the mail list and describing their particular details.*/
class MailController extends Controller {

	/**
	*
	* To view Mail Status Index Page
	* @author Sastha
	* @return object to particular view page
	* Created At 26/08/2020
	*
	*/
	public function index(Request $request) {
		$concatName = "";
		if ($request->filval == "") {
			$request->filval = 0;
		}
		$mailflt = $request->filval;
		if ($request->plimit == "") {
			$request->plimit = 50;
		}
		$mailStatus = Mail::getMailstatus($request);
		if ($mailflt == "") {
			$mailflter = 2;
		} elseif($mailflt == 0) {
			$mailflter = 0;
		} elseif ($mailflt == 1){
			$mailflter = 1;
		}
		return view('mail.index',['request' => $request,
								'mailStatus' => $mailStatus,
								'mailflt' => $mailflter]);
	}

	/**
	*
	* To view Mail Status View Page
	* @author Sastha
	* @return object to particular view page
	* Created At 26/08/2020
	*
	*/
	public function mailview(Request $request) {
		if ($request->mailid =="") {
			return Redirect::to('Mail/index?menuid=menu_mail&time='.date('YmdHis'));
		}
		$mailView = Mail::getMailview($request);
		return view('mail.mailView',['request' => $request,
								'mailView' => $mailView]);
	}

	/**
	*
	* To view MailContent Index Page
	* @author Sastha
	* @return object to particular view page
	* Created At 26/08/2020
	*
	*/
	public function mailcontent(Request $request) {
		$contenttotal = 0;
		// Filter Process
		$disabledall = "";
		$disableduse = "";
		$disablednotuse = "";
		if (!isset($request->filvalhdn) || $request->filvalhdn == "") {
			$request->filvalhdn = 1;
		}
		if($request->filvalhdn == 1) {
			$disabledall = "disabled fb";
		} else if($request->filvalhdn == 2) {
			$disableduse = "disabled fb";
		} else if($request->filvalhdn == 3) {
			$disablednotuse = "disabled fb";
		}
		// Pagination
		if ($request->plimit == "") {
			$request->plimit = 50;
		}
		//SORTING PROCESS
		if (!isset($request->mailcontentsort) || $request->mailcontentsort == "") {
			$request->mailcontentsort = "mailId";
		}
		if (empty($request->sortOrder)) {
			$request->sortOrder = "desc";
		}
		if ($request->sortOrder == "asc") {  
			$request->sortstyle = "sort_asc";
		} else {  
			$request->sortstyle = "sort_desc";
		}
		$sortarray = [$request->mailcontentsort => $request->mailcontentsort,
						'mailId' => trans('messages.lbl_mailid'),
						'mailName' =>trans('messages.lbl_mailname'),];
		$mailcontent = Mail::getMailcontent($request);
		return view('mail.contentindex' ,compact('request',
											'mailcontent',
											'sortarray', 
											'disabledall',
											'disableduse',
											'disablednotuse',
											'contenttotal'));
	}

	/**
	*
	* To view contentindex Page
	* @author Sastha
	* @return object to particular view page
	* Created At 25/08/2020
	*
	*/
	public function mailcontentflg(Request $request) {
		$contentdelflg = Mail::fnupdatedelflg($request);
		return Redirect::to('Mail/mailcontent?mainmenu=menu_mail&time='.date('YmdHis'));
		
	}

	/**
	*
	* To view Mail content register
	* @author Sastha
	* @return object to particular view page
	* Created At 26/08/2020
	*/
	public function mailContentreg(Request $request) {
		$mailid = $request->mailid;
		$mailDetails = "";
		if (!isset($request->mailid)) {
			return Redirect::to('Mail/mailcontentview?mainmenu=menu_mail&time='.date('YmdHis'));
		}
		if(!empty($mailid)){ 
			$mailDetails = Mail::getMailcontentindb($request,$mailid);
		}
		return view('mail.contentaddedit',compact('request',
												'mailDetails'));
	}

	/**
	*
	* To validate Mail content register 
	* @author Sastha
	* @return object to particular view page
	* Created At 26/08/2020
	*/
	public function mailregvalidation(Request $request) {
		$commonrules=array();
		$commonrules = array(
			'mailname' => 'required',
			'mailSubject'=>'required',
			'mailheader'=>'required',
			'mailContent'=>'required',
			// 'mailsignature'=>'required',
		);
		$rules = $commonrules;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);exit;
        } else {
            $success = true;
            echo json_encode($success);
        }
	}

	/**
	*
	* To register Mail content 
	* @author Sastha
	* @return object to particular view page
	* Created At 25/08/2020
	*/
	public function mailcontentregprocess(Request $request) {
		$mailid = $request->mailid;
		$newmailId = "MAIL0001";
		$generateUserId = Mail::getcount();
		if (!empty($generateUserId)) {
  			$newmailId = $generateUserId[0]->newmailId;
  		}
  		if(!empty($mailid)){
  			$mailContentedit = Mail::updMailcontent($request,$mailid);
  			if ($mailContentedit) {
				Session::flash('message', 'Updated Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			}
  			Session::flash('mailid', $request->mailid);
  		}else{ 
			$mailContentreg = Mail::insMailcontent($request,$newmailId);
			if ($mailContentreg) {
				Session::flash('message', 'Registered Successfully!'); 
				Session::flash('type', 'alert-success'); 
			}
			Session::flash('mailid', $newmailId);
		}
		return Redirect::to('Mail/mailcontentview?mainmenu=menu_mail&time='.date('YmdHis'));
	}

	/**
	*
	* To view contentview Page
	* @author Sastha
	* @return object to particular view page
	* Created At 25/08/2020
	*
	*/
	public function mailcontentview(Request $request) {
		if(Session::get('mailid') != ""){
			 $request->mailid = Session::get('mailid');
		}
		if (!isset($request->mailid)) {
			return Redirect::to('Mail/mailcontent?mainmenu=menu_mail&time='.date('YmdHis'));
		}
		$contentview = Mail::getMailcontentview($request);
		return view('mail.contentview' ,compact('request',
											'contentview'
											));
	}
}