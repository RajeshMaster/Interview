<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Model\MailSignature;
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
class MailSignatureController extends Controller {

	public function index(Request $request) {
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
		if ($request->plimit == "") {
			$request->plimit = 50;
		}
		$getlist=MailSignature::getMailSignatureData($request);
		return view('mailsignature.index',compact('request',
											'disabledall',
											'disableduse',
											'disablednotuse',
											'contenttotal',
											'getlist'));
	}
	public function mailSignatureFlg(Request $request){
		$signatureDelflg = MailSignature::fnUpdateDelflg($request);
		return Redirect::to('MailSignature/index?mainmenu=menu_mailsignature&time='.date('YmdHis'));
	}
	public function mailSignatureView(Request $request){
		$mailSignatureView = MailSignature::getMailSignatureView($request);
		return view('mailsignature.mailsignatureview' ,compact('request',
											'mailSignatureView'
											));
	}
}
