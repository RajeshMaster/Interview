<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Model\Employee;
use App\Model\Common;
use Auth;
use Redirect;
use Session;
use Input;
use Config;
use View;
use Illuminate\Support\Facades\Validator;
class EmployeeController extends Controller
{
	/**
	*
	* To view Employee ListView Page
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/09/13
	*
	*/
	public function index(Request $request) {
		if ($request->plimit == "") {
			$request->plimit = 50;
		}

		$userDtls = Employee::fnGetEmployeeDetails($request);


		return view('income.listview', ['request' => $request,
											'userDtls' => $userDtls,
											'userPayIncomeDtls' => $userPayIncomeDtls,
											'incomedtls' => $incomedtls,
											'grantTotal' => $grantTotal,
											'incomeMnth' => $incomeMnth,
											'prev_yrs' => $prev_yrs,
											'cur_year' => $cur_year,
											'total_yrs' => $total_yrs,
											'curtime' => $curtime
										]);
	}
}