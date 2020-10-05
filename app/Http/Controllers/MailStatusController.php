<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Model\MailStatus;
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
class MailStatusController extends Controller {

	public function index(Request $request) 
	{
		$disableddraft="";
		$disabledsent="";
		if (empty($request->plimit)) {
			$request->plimit = 50;
		}
		if (!isset($request->sendfilter) || $request->sendfilter=="") {
			$request->sendfilter = 1;
		}
		if(!isset($request->sendfilter) || $request->sendfilter == 1) {

			$disabledsent ="disabled fwb black";
		}
		if(!isset($request->sendfilter) || $request->sendfilter == 0) {
			$disableddraft ="disabled fwb black";
		}
		$getMailList=MailStatus::getMailStausData($request);
		return view('mailstatus.index',compact('request','getMailList','disableddraft','disabledsent'));
	}
	public function mailStatusView(Request $request){
		if (!isset($request->statusid)) {
			return Redirect::to('MailStatus/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$singlemailstatus = Mailstatus::getSingleMailStatus($request);
		return view('mailstatus.view',['singlemailstatus' => $singlemailstatus,
										'request' => $request]);
	}
}