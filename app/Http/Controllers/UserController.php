<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\User;
use DB;
use Input;
use Redirect;
use Session;
use Carbon;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
	/**  
    *  List Page Process
    *  @author Easa 
    *  @param $request
    *  Created At 2020/10/02
    **/
	function index(Request $request) {
		//Variable Declaration 
		$disabledall="";
		$disabledunused="";
		$disabledadmin="";
		$disabledsuperadmin="";
		$disableduser="";
		//Setting page limit
		if ($request->plimit=="") {
			$request->plimit = 50;
		}
		//Filter process
   		if (!isset($request->filterval) || $request->filterval == "") {
        	$request->filterval = 3;
      	}
    	if ($request->filterval == 3) {
        	$disabledall="disabled fb";
  		} elseif ($request->filterval == 0) {
    		$disableduser="disabled fb";
  		} elseif ($request->filterval == 1) {
    		$disabledadmin="disabled fb";
  		} elseif ($request->filterval == 2) {
    		$disabledsuperadmin="disabled fb";
  		} elseif ($request->filterval == 4) {
    		$disabledunused="disabled fb";
  		}
    	//SORTING PROCESS
		if (!isset($request->usersort)) {
    		$request->usersort = "usercode";
  		}
  		if ($request->usersort == "") {
    		$request->usersort = "usercode";
  		}
  		if (empty($request->sortOrder)) {
    		$request->sortOrder = "asc";
  		}
  		if ($request->sortOrder == "asc") {  
  			$request->sortstyle="sort_asc";
  		} else {  
  			$request->sortstyle="sort_desc";
  		}
  		$sortarray = [$request->usersort=>$request->usersort,
                'usercode'=> trans('messages.lbl_usercode'),
                'usercode'=> trans('messages.lbl_usercode')];
    	//SORT POSITION
        if (!empty($request->singlesearch) || $request->searchmethod == 2) {
          $sortMargin = "margin-right:260px;";
        } else {
          $sortMargin = "margin-right:0px;";
        }
    	//Changing User status
        if ($request->userid) {
        	$changeuserflag=User::fnChnagingTheUserFlag($request);
        	if($changeuserflag) {
              Session::flash('success', 'User status changed Sucessfully!'); 
              Session::flash('type', 'alert-success'); 
            } else {
              Session::flash('type', 'User status change is Unsucessfully!'); 
              Session::flash('type', 'alert-danger'); 
            }
        }
    	//values for multisearch select box
		$Classificationarray = array("0"=>trans('messages.lbl_user'),
									"1"=>trans('messages.lbl_admin'),
									"2"=>trans('messages.lbl_superadmin'));
		//Query to get data
		$userdetails=User::getUserDetails($request);
		//returning to view page
		return view('user.index',['userdetails' => $userdetails,
								  'disabledall' => $disabledall,
								  'disabledunused' => $disabledunused,
								  'disabledadmin' => $disabledadmin,
								  'disabledsuperadmin' => $disabledsuperadmin,
								  'disableduser' => $disableduser,
								  'sortarray' => $sortarray,
								  'Classificationarray'=>$Classificationarray,
								  'sortMargin' => $sortMargin,
								  'request' => $request]);
	}

	function addedit(Request $request) {

		if(!isset($request->editflg)){
			return $this->index($request);
		}

		$userview = User::viewdetails($request->editid);
		$dob_year = Carbon\Carbon::createFromFormat('Y-m-d', date("Y-m-d"));
		$dob_year   = $dob_year->subYears(18);
		$dob_year = $dob_year->format('Y-m-d');
		/*if (Session::get('userclassification') == "1" || Session::get('userclassification') == "2") {
			$Classificationarray = array("0"=>trans('messages.lbl_user'),
									"1"=>trans('messages.lbl_admin'),
									"2"=>trans('messages.lbl_superadmin'),
									);

		} else {
			$Classificationarray = array("0"=>trans('messages.lbl_user'),
									);
		}*/
		$Classificationarray = array("0"=>trans('messages.lbl_user'),
									"1"=>trans('messages.lbl_admin'),
									"2"=>trans('messages.lbl_superadmin'),
									);
		return view('user.addedit',['Classificationarray' => $Classificationarray,
									'userview' => $userview,
									'request' => $request,
									'dob_year' => $dob_year]);

	}

	function UserRegValidation (Request $request) {
		$commonrules=array();
		$commonrules1=array();
		$commonrules = array(
			'MstuserUserID' => 'required',
			
			'MstuserUserKbn' => 'required',
			'MstuserSurNM' => 'required',
			'MstuserSurNMK' => 'required',
			'Mstusernickname' => 'required',
			'MstuserSex' => 'required',
			'MstuserBirthDT' => 'required|date_format:"Y-m-d"',
			'MstuserTelNO' => 'required',
			'MstuserTelNO1' => 'required',
			'MstuserTelNO2' => 'required',
			'MstuserTelNO2' => 'required',
			'MstuserMailID' => 'required|email',
		);

		if($request->editflg != 'edit'){
			$commonrules1 = array(
				'MstuserPassword' => 'required',
				'MstuserConPassword' => 'required|same:MstuserPassword',
			);
		}
		$customizedNames = array(
           'MstuserPassword' => 'Password',
           'MstuserConPassword' => 'Confirm Password',
           'MstuserMailID' => 'Email',
           'MstuserSex' => 'Gender',
        );

		$rules = $commonrules+$commonrules1;
        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($customizedNames);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);exit;
        } else {
            $success = true;
            echo json_encode($success);
        }
	}

	function addeditprocess(Request $request) {
		if($request->editid !="") {
			$update = User::UpdateReg($request);
	        Session::flash('viewid', $request->editid); 
			if($update) {
				Session::flash('success', 'Updated Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('type', 'Updated Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		} else {

			$autoincId=User::getautoincrement();
			$Usercode="MBINV".(str_pad($autoincId,'3','0',STR_PAD_LEFT));
			$insert = User::insertRec($request,$Usercode);
	        Session::flash('viewid', $autoincId); 
			if($insert) {
				Session::flash('success', 'Inserted Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('danger', 'Inserted Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		}
		return Redirect::to('user/view?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}

	/**  
    *  Single View Page
    *  @author Easa 
    *  @param $request
    *  Created At 2020/10/02
    **/
	function view(Request $request) {
		if(Session::get('viewid') !=""){
	        $request->viewid = Session::get('viewid');
	    }
	    if(Session::get('id') !=""){
	        $request->viewid = Session::get('viewid');
			Session::flash('success', 'Password Updated Sucessfully!'); 
			Session::flash('type', 'alert-success'); 
	    }
		//ON URL ENTER REDIRECT TO INDEX PAGE
		if(!isset($request->viewid)){
			return $this->index($request);
		}
		$userview = User::viewdetails($request->viewid);
		// For Gender
		if ($userview[0]->gender == 1) {
			$userview[0]->gender = "Male";
		} else if ($userview[0]->gender == 2) {
			$userview[0]->gender = "Female";
		}
		// For User Classification
		if ($userview[0]->userclassification == 0 && $userview[0]->delflg == 0) {
			$userview[0]->userclassification = trans('messages.lbl_user');
		} else if ($userview[0]->userclassification == 1 && $userview[0]->delflg == 0) {
			$userview[0]->userclassification = trans('messages.lbl_admin');
		} else if ($userview[0]->userclassification == 2 && $userview[0]->delflg == 0) {
			$userview[0]->userclassification = trans('messages.lbl_superadmin');
		} 
		return view('user.view',['userview' => $userview,
								'request' => $request]);
	}

	function changepassword(Request $request) {

		if(!isset($request->id)){
			return $this->index($request);
		}

		$view = User::viewdetails($request->id);
		return view('user.changepassword',['view' => $view,'request' => $request]);

	}

	function passwordchangeprocess(Request $request) {
		$update = User::passwordchange($request);
		if($update) {
			Session::flash('message', 'Password Updated Sucessfully!'); 
			Session::flash('type', 'alert-success'); 
		} else {
			Session::flash('type', 'Password Updated Unsucessfully!'); 
			Session::flash('type', 'alert-danger'); 
		}

		Session::flash('viewid', $request->id);
		Session::flash('id', $request->id); 
		return Redirect::to('user/view?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}

	function PasswordValidation (Request $request) {
		$commonrules=array();
		$commonrules1=array();
		$oldPasswordCheck = array();
		$commonrules = array(
			'MstuserPassword' => 'required|different:MstuserOldPassword',
			'MstuserConPassword' => 'required|same:MstuserPassword',
		);

		$customizedNames = array(
           'MstuserPassword' => 'Password',
           'MstuserConPassword' => 'Confirm Password',
           'MstuserOldPassword' => 'Old Password',
        );
        if (Session::get('usercode') == $request->hidusercode) {
        	$oldPasswordCheck = array(
				'MstuserOldPassword' => 'required',
				/*'MstuserPassword' => 'required|different:MstuserOldPassword',*/
			);
        }
		
		$rules = $commonrules+$commonrules1+$oldPasswordCheck;
        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($customizedNames);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);exit;
        } else {
            $success = true;
            echo json_encode($success);
        }
	}

	public function CheckUserIdExist(Request $request)
	{
		$check = User::fnCheckUserIdExist($request);
		$cnt = count($check);
		print_r($cnt);exit();
	}

	public function CheckUserEmailExist(Request $request){
		$checkMail = User::fnCheckUserEmailExist($request);
		/*$cnt = count($checkMail);*/
		print_r($checkMail);exit();
	}
	public function PasswordCheckValidation(Request $request){
		$mdpass = md5($request->MstuserOldPassword);
		if ($mdpass == $request->hidpassword) {
			$count = 1;
		}else{
			$count = 2;
		}
		print_r($count);exit();
	}

}