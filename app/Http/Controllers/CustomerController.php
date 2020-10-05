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

class CustomerController extends Controller {
	public function index(Request $request)
	{
		return View('customer.index',compact('request'));
	}
}