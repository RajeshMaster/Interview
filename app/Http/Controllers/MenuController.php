<?php
namespace App\Http\Controllers;
use App\Model\Invoice;
use App\Model\Estimation;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
class MenuController extends Controller {
	/**  
	 *  Menu
	 *  @author Easa
	 *  @param $request
	 *  Created At 2020/09/30
	 **/
	function index(Request $request) { 
		date_default_timezone_set(Session::get('timezone')); 
		return view('menu.index',['request'=> $request]);
	}
}
?>