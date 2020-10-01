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
use Carbon;
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

		$disabledEmp= "";
		$disabledNotEmp= "";
		$disabledRes= "";
		if ($request->plimit == "") {
			$request->plimit = 50;
		}

		if (empty($request->resignid)) {
			$resignid = 0;
			if (!empty($request->title) && $request->title != 2) {
				$title = 3;
				$disabledNotEmp= "disabled";
			} else {
				$title = 2;
				$disabledEmp= "disabled";
			}
		} else {
			$resignid = 1;
			$title = ""; 
			$disabledRes= "disabled";
		}

		//SORTING PROCESS
		if ($request->staffsort == "") {
			$request->staffsort = "Emp_ID";
		}
		if (empty($request->sortOrder)) {
			$request->sortOrder = "DESC";
		}
		if ($request->sortOrder == "asc") {  
			$request->sortstyle="sort_asc";
		} else {  
			$request->sortstyle="sort_desc";
		}

		//SORT POSITION
		if (!empty($request->singlesearch) || $request->searchmethod == 2) {
		  $sortMargin = "margin-right:200px;";
		} else {
		  $sortMargin = "margin-right:0px;";
		}

		$array = array("Emp_Id"=>trans('messages.lbl_empid'),
						"FirstName"=>trans('messages.lbl_empName'),
						"DOJ"=>trans('messages.lbl_doj'),
						"DOB"=>trans('messages.lbl_age')
						);

		$src = "";
		$noimage = "../public/images";
		$file = "../public/images/upload/";
		$disPath = "../public/images/upload/";
		$filename = "";
		
		$empdetailsdet=array();
		$empdetails = Employee::fnGetEmployeeDetails($request, $resignid,$title);
		$i = 0;
		foreach($empdetails as $key=>$data) {
			$empdetailsdet[$i]['FirstName'] = $data->FirstName;
			$empdetailsdet[$i]['LastName'] = $data->LastName;
			$empdetailsdet[$i]['KanaFirstName'] = $data->KanaFirstName;
			$empdetailsdet[$i]['KanaLastName'] = $data->KanaLastName;
			$empdetailsdet[$i]['Gender'] = $data->Gender;
			$empdetailsdet[$i]['Picture'] = $data->Picture;
			if (is_numeric($data->Address1)) {
				$japanaddress = Employee::fngetjapanaddress($data->Address1);
				$empdetailsdet[$i]['Address1'] = (!empty($japanaddress[0]->address)) ?  $japanaddress[0]->address : $data->Address1;
			} else {
				$empdetailsdet[$i]['Address1'] = $data->Address1;
			}

			$empdetailsdet[$i]['nickname'] = $data->nickname;
			$empdetailsdet[$i]['Mobile1'] = $data->Mobile1;
			$empdetailsdet[$i]['DOJ'] = $data->DOJ;
			$empdetailsdet[$i]['DOB'] = $data->DOB;
			$empdetailsdet[$i]['Emp_ID'] = $data->Emp_ID;
			$empdetailsdet[$i]['Emailpersonal'] = $data->Emailpersonal;
			$cusexpdetails = Employee::getYrMonCountBtwnDates($empdetailsdet[$i]['DOJ'],'');

			if ($cusexpdetails['year'].".".$cusexpdetails['month'] == 0.0) {
				$empdetailsdet[$i]['experience'] = "0.0";
			} else {
				$empdetailsdet[$i]['experience'] = $cusexpdetails['year'].".".Employee::fnAddZeroSubstring($cusexpdetails['month']);
			}

			$recentClient =Employee::fnGetClientTemp($empdetailsdet[$i]['Emp_ID']);
			$recentResume =Employee::fnGetResume($empdetailsdet[$i]['Emp_ID']);



			$cusname=Employee::fnGetcusname($request,$empdetailsdet[$i]['Emp_ID']);
			foreach($cusname as $key=>$value) {
				$empdetailsdet[$i]['customer_name'] = $value->customer_name;
			}
			$i++;
		}
		$detailage = Employee::GetAvgage($resignid);

		return view('employee.index', ['request' => $request,
										'array' => $array,
										'sortMargin' => $sortMargin,
										'noimage' => $noimage,
										'src' => $src,
										'resignid' => $resignid,
										'file' => $file,
										'filename' => $filename,
										'disPath' => $disPath,
										'empdetails' => $empdetails,
										'detailage' => $detailage,
										'empdetailsdet' => $empdetailsdet,
										'disabledEmp'	=>$disabledEmp,
										'disabledNotEmp'=>$disabledNotEmp,
										'disabledRes'	=>$disabledRes
										]);
	}
	/**
	*
	* To view Employee SingleView Page
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/13
	*
	*/
	public function view(Request $request){
		if(Session::get('empid') !="" && Session::get('resignid') !=""){
			$request->empid = Session::get('empid');
			$request->resignid = Session::get('resignid');
		} else {
			if(Session::get('empid') !=""){
				$request->empid = Session::get('empid');
				$request->resignid="";
			}
		}
		if(!isset($request->empid)){
			return $this->index($request);
		}
		$file = "../resources/assets/images/upload/";
		$noimage = "../resources/assets/images";
		$src = "";
		$empDetail=Employee::fnGetstaffDetail($request);
		return view('employee.view', [
										'empDetail' => $empDetail,
										'request' => $request,
										'file' => $file,
										'src' => $src,
										'noimage' => $noimage,
									]);
	}

		/**
	*
	* To view Employee Edit Page
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/13
	*
	*/
	public function empAddEdit(Request $request){
		// To View the picture in the path
		$filepath = "../resources/assets/images/upload/";
		$check = "";
		$dob_year = "";
		/*if(!isset($request->editflg)) {
			return view('Staff.addedit',['request' =>$request]);
		}*/
		$empview = Employee::fnGetstaffDetail($request);
		$dob_year = Carbon\Carbon::createFromFormat('Y-m-d', date("Y-m-d"));
		$dob_year   = $dob_year->subYears(18);
		$dob_year = $dob_year->format('Y-m-d');
		return view('employee.addedit',['request' =>$request,
									 'empview' => $empview,
									 'filepath' => $filepath,
									 'check' => $check,
									 'dob_year' => $dob_year]);
	}

	public function AddEditregvalidation(Request $request) {
		$commonrules=array();
		$common2 = array();
		$common1 = array(
			'OpenDate' => 'required',
			'Surname'=>'required',
			'Name'=>'required',
			'nickName'=>'required',
			'DateofBirth' => 'required',
			'MobileNo'=>'required',
			'Email'=>'required',
		);

		$commonrules = $common1 + $common2;
		$rules = $commonrules;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);exit;
        } else {
            $success = true;
            echo json_encode($success);
        }
	}

	public function employeeEditProcess(Request $request) {
		$update = Employee::updateprocess($request);
		if($update){
			Session::flash('success', 'Employee Updated Sucessfully!'); 
			Session::flash('type', 'alert-success'); 
		} else {
			Session::flash('success', 'Employee Updated UnSucessfully!'); 
			Session::flash('type', 'alert-danger'); 
		}
		Session::flash('empid', $request->empid);
		return Redirect::to('Employee/view?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}
}