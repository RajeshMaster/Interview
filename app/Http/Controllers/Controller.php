<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use App\Model\Common;
use Cookie;
use Auth;
use DB;
use Session;
use App;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    public function __construct() {
    	if (Auth::viaRemember()) {
			/*print_r(session()->all());print_r("<br/>");print_r("<br/>");
			print_r(Cookie::get());print_r("<br/>");
			print_r(Auth::user());print_r("<br/>");*/
			Session::put('loginId',Auth::user()->loginId);
			Session::put('langFlg',Auth::user()->langFlg);
			$userName = Common::fnGetDataFromOtherTable(Auth::user()->userId,Auth::user()->identFlag);
			if (isset($userName[0])) {
	        	Session::put('FirstName',$userName[0]->userName);
        	}
		}
    	if (Session::get('languageval') == "en") {
	        App::setLocale("en");
      	} else {
	        App::setLocale("jp");
      	}
    }
}
