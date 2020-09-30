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
		if (empty($request->plimit)) {
			$request->plimit = 50;
		}
		$mailContent = Mail::getMailContent($request);
		return view('mail.index',['request' => $request,
								'mailContent' => $mailContent,
								]);
	}

}