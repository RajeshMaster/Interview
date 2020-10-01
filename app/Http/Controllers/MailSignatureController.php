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
}
