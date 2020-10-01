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
	* To view MailContent Index Page
	* @author Sathish
	* @return object to particular view page
	* Created At 01/10/2020
	*
	*/
	public function index(Request $request) {
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
	
		$mailcontent = Mail::getMailcontent($request);
		return view('mail.index' ,compact('request',
											'mailcontent',
											'disabledall',
											'disableduse',
											'disablednotuse',
											'contenttotal'));
	}
	/**
	*
	* To view MailContent View Page
	* @author Sathish
	* @return object to particular view page
	* Created At 01/10/2020
	*
	*/
	public function mailContentView(Request $request){
		if(Session::get('mailid') != ""){
			$request->mailid = Session::get('mailid');
		}
		if(!isset($request->mailid)){
			return Redirect::to('Mail/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$mailContentView = Mail::getMailcontentview($request);
		return view('mail.mailcontentview' ,compact('request',
											'mailContentView'
											));
	}
	/**
	*
	* To view MailContent AddEdit page
	* @author Sathish
	* Created At 01/10/2020
	*
	*/
	public function mailContentAddEdit(Request $request){
		if (!isset($request->editflg)) {
			return Redirect::to('Mail/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$getmailtypes=Mail::fnfetchmailtypes($request);
		$getdataforupdate=array();
		if ($request->editflg == 1) {
			$getdataforupdate=Mail::fnfetchupdatedata($request);
		} 
		return view('mail.mailcontentaddedit',[
											'getmailtypes' => $getmailtypes,
											'getdataforupdate' => $getdataforupdate,
											'request' => $request]);
	}
	/**
	*
	* To view MailContent AddEdit Process
	* @author Sathish
	* Created At 01/10/2020
	*
	*/
	public function mailContentAddEditProcess(Request $request){
		$mailid = $request->mailid;
		$newmailId = "MAIL0001";
		$generateUserId = Mail::getcount();
		$getmailtypeid = "";
		if ($request->mailtype == 999) {
			$getmailtypeid=Mail::fninsertnewmailtype($request);
		}
		if(!empty($generateUserId)){
			$newmailId = $generateUserId[0]->newmailId;
		}
		if(!empty($mailid)){
			$mailContentedit = Mail::updMailcontent($request,$mailid,$getmailtypeid);
  			if ($mailContentedit) {
				Session::flash('message', 'Updated Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			}
  			Session::flash('mailid', $request->mailid);
		}else{
			$mailContentreg = Mail::insMailcontent($request,$newmailId,$getmailtypeid);
			if ($mailContentreg) {
				Session::flash('message', 'Registered Successfully!'); 
				Session::flash('type', 'alert-success'); 
			}
			Session::flash('mailid', $newmailId);
		}
		return Redirect::to('Mail/mailContentView?mainmenu=menu_mail&time='.date('YmdHis'));
	}
	/**
	*
	* To view MailContent AddEdit Validation Process
	* @author Sathish
	* Created At 01/10/2020
	*
	*/
	public function mailregvalidation(Request $request) {
		$commonrules=array();
		$common2 = array();
		$common1 = array(
			'mailName' => 'required',
			'subject'=>'required',
			'mailtype'=>'required',
			'content'=>'required',
		);
		if($request->mailtype == 999){
			$common2 = array('mailother' => 'required');
		}
		$commonrules = $common1 + $common2;
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
	* To view MailContent update Delflg
	* @author Sathish
	* Created At 01/10/2020
	*
	*/
	public function mailContentFlg(Request $request) {
		$contentdelflg = Mail::fnUpdateDelflg($request);
		return Redirect::to('Mail/index?mainmenu=menu_mail&time='.date('YmdHis'));
	}
}