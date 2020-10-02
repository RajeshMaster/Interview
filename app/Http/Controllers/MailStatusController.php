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
	public function index(Request $request) {
		if (empty($request->plimit)) {
			$request->plimit = 50;
		}
		$getlist=MailStatus::getMailStausData($request);
		return view('mailstatus.index',compact('request'));
	}
}