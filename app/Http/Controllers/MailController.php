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
	public function mailContentView(Request $request){
		$mailContentView = Mail::getMailcontentview($request);
		return view('mail.mailcontentview' ,compact('request',
											'mailContentView'
											));
	}
	public function mailContentAddEdit(Request $request){
		if (!isset($request->editflg)) {
			return Redirect::to('Mail/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$getmailtypes=Mailcontent::fnfetchmailtypes($request);
		$getdataforupdate=array();
		if ($request->editflg == 1) {
			$getdataforupdate=Mailcontent::fnfetchupdatedata($request);
		} 
		return view('mail.mailcontentaddedit',[
											'getmailtypes' => $getmailtypes,
											'getdataforupdate' => $getdataforupdate,
											'request' => $request]);
	}

}