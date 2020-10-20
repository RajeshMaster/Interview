<?php
namespace App\Http\Controllers;
use App\Model\Invoice;
use App\Model\Ourdetail;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
class OurdetailController extends Controller {
	/**  
	 *  Menu
	 *  @author Rajesh
	 *  @param $request
	 *  Created At 2020/09/30
	 **/
	function index(Request $request) {
		$result = Ourdetail::viewdetails($request);
		/*$viewtaxdetails = Ourdetail::viewtaxdetails($request);*/
		/*$kessan = Ourdetail::viewkessandetails();*/
		
		return view('ourDetail.index',['result' => $result,
										/*'viewtaxdetails'=> $viewtaxdetails,*/
										/*'kessan' => $kessan,*/
										'request' => $request]);
	}
}
?>