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
use App\Model\SendingMail;

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

			$recentClient =Employee::fnGetClientDtl($empdetailsdet[$i]['Emp_ID']);
			/*
				Point To remember
				clientStatus = 0 ->able to edit end date
				clientStatus = 1 ->Unable to edit end date
			*/
			if (isset($recentClient->status)) {
				$empdetailsdet[$i]['clientStatus'] = $recentClient->status;
				$empdetailsdet[$i]['clientEndDate'] = $recentClient->Ins_DT;
			} else {
				$empdetailsdet[$i]['clientStatus'] = 0;
				$empdetailsdet[$i]['clientEndDate'] = "";
			}

			$recentResume =Employee::fnGetResume($empdetailsdet[$i]['Emp_ID']);
			if(isset($recentResume->resume)) {
				$empdetailsdet[$i]['recentResume'] = $recentResume->resume;
				$empdetailsdet[$i]['resumeInsDate'] = $recentResume->createdDate;
			} else {
				$empdetailsdet[$i]['recentResume'] = "";
				$empdetailsdet[$i]['resumeInsDate'] = "";
			}

			if ($empdetailsdet[$i]['clientEndDate'] != "" && $empdetailsdet[$i]['resumeInsDate'] != "") {
				if ($empdetailsdet[$i]['resumeInsDate'] > $empdetailsdet[$i]['clientEndDate']) {
					$empdetailsdet[$i]['presentResume'] = 1;
				} else {
					$empdetailsdet[$i]['presentResume'] = 0;
				}
			} else {
				$empdetailsdet[$i]['presentResume'] =0;
			}


			$cusname=Employee::fnGetcusname($request,$empdetailsdet[$i]['Emp_ID']);
			foreach($cusname as $key=>$value) {
				$empdetailsdet[$i]['customer_name'] = $value->customer_name;
			}
			$i++;
		}
// 		echo "<pre>";
// print_r($empdetailsdet);
// echo "</pre>";
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
	* Created At 2020/10/2
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

	/**
	*
	* To view Employee Edit Validation
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/2
	*
	*/
	public function AddEditregvalidation(Request $request) {
		$commonrules=array();
		$common2 = array();
		$common1 = array(
			'OpenDate' => 'required|date_format:"Y-m-d"',
			'Surname'=>'required',
			'Name'=>'required',
			'nickName'=>'required',
			'DateofBirth' => 'required|date_format:"Y-m-d"',
			'MobileNo'=>'required|numeric',
			'Email'=>'required|email',
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

	/**
	*
	* Employee Edit Process
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/2
	*
	*/
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

	/**
	*
	* Work End Process
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/2
	*
	*/
	public function workend(Request $request) {
		if(!isset($request->empid) || $request->empid == ""){
			return $this->index($request);
		}
		$customerarray = array();
		$clientDtl = Employee::clientWorkDetails($request);

		$custDtl = Employee::selectcustomer();
		foreach ($custDtl as $key => $value) {
			$customerarray[$value->customer_id] = $value->customer_name;
		}

		return view('employee.workendReg',[
											'request' =>$request,
											'customerarray' => $customerarray,
											'clientDtl' => $clientDtl,
										]);
	}

	/**
	*
	* Get Branch Process
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/2
	*
	*/
	public function branch_ajax(Request $request){
		$customerid = $request->getcustId;
		$get_sub_query = Employee::fnGetbranchName($customerid);
		$brancharray = json_encode($get_sub_query);
		echo $brancharray;
		exit();
	}

	/**
	*
	* Get Incharge Process
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/2
	*
	*/
	public function incharge_ajax(Request $request) {
		$customerId = $request->getcusId;
		$branchId = $request->getbranchId;
		$getInchargeDtl = Employee::fnGetinchargeName($customerId,$branchId);
		$inchargearray = json_encode($getInchargeDtl);
		echo $inchargearray;
		exit();
	}

	/**
	*
	* Get Customer Details For Popup
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/2
	*
	*/
	public function customerSelpopup(Request $request) {
		$custDtl = Employee::selectcustomer();
		return view('employee.customerSelPopup',['custDtl' => $custDtl,'request' => $request]);
	}

	/**
	*
	* Validation for work end Date
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/02
	*
	*/
	public function wrkEndValidation(Request $request) {
		$commonrules=array();
		$common2 = array();

		$after = $request->startDate;
		$before = $request->endDate;

		$common1 = array(
			'customerName' => 'required',
			'branchId'=>'required',
			'inchargeDetails'=>'required',
			'startDate'=>'required|date_format:"Y-m-d|before:' . $before,
			'endDate' => 'required|date_format:"Y-m-d|after:' . $after,
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

	/**
	*
	* Validation for work end Date
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/03
	*
	*/
	public function wrkEndProcess(Request $request) {
		$updateEnddate = Employee::insertEnddate($request);
		if ($updateEnddate) {
			$mailid = "MAIL0014";
			$cont = Employee::getContentFirst($mailid);
			$content = "";
			$content.="\r\n EmployeeID   :".$request->empId;
			$data[0] =  str_replace('AAAA',$content, $cont[0]->content);
			$email=Common::fnGetEmployeeInfo($request->empid); 
			$mail=SendingMail::sendIntimationMail($data,$email[0]->Emailpersonal,"Update Resume");
			if($mail){
				Session::flash('success', 'Mail Sent And End Date Updated Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('danger', 'Mail Not Sent But End Date Updated Sucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		} else {
			Session::flash('danger', 'End Date Updated UnSucessfully!'); 
			Session::flash('type', 'alert-success'); 
		}
		return Redirect::to('Employee/index?mainmenu=menu_employee&time='.date('YmdHis'));
	}

	/**
	*
	* Upload Resume Page
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/05
	*
	*/
	public function uploadResume(Request $request) {
		return view('employee.uploadResumePopup',['request' => $request]);
	}

	/**
	*
	* Resume Upload Proces
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/05
	*
	*/
	public function popupuploadProcess(Request $request) {
		if($request->pdffile != "") {
			$resume_name = $request->empId."resume_".date("Ymdhis");
			$destinationPath = '../ResumeUpload/employeResume';
			if(!is_dir($destinationPath)) {
				mkdir($destinationPath, 0777, true);
			}
			$ifile = $resume_name.".". self::getExtension($_FILES["pdffile"]["name"]);

			move_uploaded_file($_FILES["pdffile"]['tmp_name'],$destinationPath ."/".$ifile);

		/*	if ($request->xlfile != "") {
				$jfile = $resume_name.".". self::getExtension($_FILES["xlfile"]["name"]);
				move_uploaded_file($_FILES["xlfile"]['tmp_name'],$destinationPath ."/".$jfile);
			}*/
			$empResumeIns = Employee::InsResumeHistory($request,$ifile);
			if($empResumeIns) {
				Session::flash('success','Resume Uploaded Sucessfully!'); 
				Session::flash('type','alert-success'); 
			} else {
				Session::flash('type','Resume Updated Unsucessfully!'); 
				Session::flash('type','alert-danger'); 
			}
		}
		return Redirect::to('Employee/index?mainmenu=menu_employee&time='.date('YmdHis'));
	}

	/**
	*
	* Resume HistoryScreen
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/05
	*
	*/
	public function resumeHistory(Request $request) {
		if (!isset($request->empid) || $request->empid == "") {
			return Redirect::to('Employee/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}

		if ($request->plimit == "") {
			$request->plimit = 50;
		}

		$viewResumedetails = Employee::viewResumedetails($request);
		$employeeInfo = Common::fnGetEmployeeInfo($request->empid);

		return view('employee.resumeHistory',['request' => $request,
										'resumedetails' => $viewResumedetails,
										'employeDetail' => $employeeInfo]);
	}

	/**
	*
	* Resume HistoryScreen
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/05
	*
	*/
	public function downloadprocess(Request $request) {
		$fileName = basename($request->filenamePdf);
		$path = '../ResumeUpload/employeResume/';
		$filePath = $path.$fileName;
		if(!empty($fileName) && file_exists($filePath)){
			header("Cache-Control: public");
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=$fileName");
			header("Content-Type: application/zip");
			header("Content-Transfer-Encoding: binary");
			// Read the file
			readfile($filePath);
			exit;
		} else {
			echo 'The file does not exist.';
		}
	}

	/**
	*
	* Resume HistoryScreen
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/05
	*
	*/
	public function Onsitehistory(Request $request) {
		$customerhistory = array();
		if ($request->plimit=="") {
			$request->plimit = 50;
		}
		$cushistory = Employee::fnGetOnsiteHistoryDetails($request->empid,$request);
		$i = 0;
		foreach($cushistory as $key=>$chistory) {
			$customerhistory[$i]['LastName'] = $request->hdnempname;
			$customerhistory[$i]['start_date'] = $chistory->start_date;
			$customerhistory[$i]['end_date'] = $chistory->end_date;
			$customerhistory[$i]['status'] = $chistory->status;
			$customerhistory[$i]['customer_name'] = $chistory->customer_name;
			$customerhistory[$i]['branch_name'] = $chistory->branch_name;
			if($chistory->end_date=="0000-00-00") {
				$customerhistory[$i]['end_date'] ="";
			}
			$cusexpdetails = Employee::getYrMonCountBtwnDates($customerhistory[$i]['start_date'],$customerhistory[$i]['end_date']);
			if ($cusexpdetails['year'].".".$cusexpdetails['month'] == 0.0) {
				$customerhistory[$i]['experience'] = "0.0";
			} else {
				$customerhistory[$i]['experience'] = $cusexpdetails['year'].".".Employee::fnAddZeroSubstring($cusexpdetails['month']);
			}
			$i++;
		}
		return view('employee.onsitehistory',['request' => $request,
											'cushistory' => $cushistory,
											'customerhistory' => $customerhistory
											]);
	}

	/**
	*
	* Resume Upload Proces
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/05
	*
	*/
	public static function getExtension($str) {
		$i = strrpos($str,".");
		if (!$i) { return ""; }
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
	}
}