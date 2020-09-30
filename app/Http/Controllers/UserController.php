<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\User;
use Input;
use Redirect;
use DB;
use Session;
use Config;
use App\Model\Common;
use Illuminate\Support\Facades\Validator;
use Mail;
use View;
use Auth;
class UserController extends Controller {

	const MAIL_ID = "MAIL0001";
	/** Userindex Page view process
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/20
	*/
	public function userindex(Request $request) {
		//Filter process
		$disabledall = "";
		$disabledverified = "";
		$disabledunverified = "";
		if (!isset($request->filterval) || $request->filterval == "") {
			$request->filterval = 1;
		}
		if ($request->filterval == 1) {
			$disabledall = "disabled fb";
		} elseif ($request->filterval == 2) {
			$disabledverified = "disabled fb";
		} elseif ($request->filterval == 3) {
			$disabledunverified = "disabled fb";
		} 
		// PAGINATION
		if ($request->plimit == "") {
			$request->plimit = 50;
		}
		//SORTING PROCESS
		if (!isset($request->usersort) || $request->usersort == "") {
			$request->usersort = "userId";
		}
		if (empty($request->sortOrder)) {
			$request->sortOrder = "desc";
		}
		if ($request->sortOrder == "asc") {  
			$request->sortstyle = "sort_asc";
		} else {  
			$request->sortstyle = "sort_desc";
		}
		$sortarray = [$request->usersort=>$request->usersort,
						'userId'=> trans('messages.lbl_userid'),
						'firstName'=>trans('messages.lbl_givenname'),
						'dob'=>trans('messages.lbl_dob'),];
		$userDetails = User::fnGetUserDetails($request);
		return view('user.userindex',compact('request','userDetails',
											'sortarray','disabledall',
											'disabledverified','disabledunverified'));

	}

	/** Register Page view process
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/20
	*/
	public function register(Request $request) {
		return view('user.register',compact('request'));
	}

	/** Addedit and Mail send process in Register page
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/20
	*/
	public function addeditprocess(Request $request) {
		//update process
		if($request->editid != "") {
			$updateuser = User::Updateuserdetails($request);
			if($updateuser) {
				Session::flash('message', 'Updated Sucessfully!');
				Session::flash('type', 'alert-success');
			} else {
				Session::flash('danger', 'Updated Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
			return Redirect::to('User/profile?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		//End Update process
		$Usercode = "AMS0001";
		$generateUserId = User::getcount();
		if (!empty($generateUserId)) {
			$Usercode = $generateUserId[0]->Usercode;
		}
		$visiturl = Config::get('constants.CONST_MAIL');
		$signature = Config::get('constants.CONST_SIGNATURE');
		// Mail Process
		$get_mail_content =  Common::get_mail_content(UserController::MAIL_ID);
		foreach ($get_mail_content as $key => $value) {
			$mailcontent['name'] = $request->firstname."  ".$request->lastname;
			$mailcontent['userid'] = $Usercode;
			$mailcontent['password'] = $request->password;
			$mailcontent['subject'] = $value->subject;
			$mailcontent['header'] = $value->header;
			$value->content = str_replace("LLLLL",$Usercode,$value->content);
			$value->content = str_replace("PPPPP",$request->password,$value->content);
			$value->content = str_replace("MMMMM",$request->mobileno,$value->content);
			$mailcontent['content'] = $value->content;
			$mailcontent['contactno'] = $request->mobileno;
		}
		$content = $mailcontent['subject'];
		$send = Mail::send('commontemplate/mail',compact('mailcontent','visiturl','signature'), 
			function($message) use ($request,$content) {	
				$message->from('staff@microbit.co.jp','MICROBIT');
				$message->to($request->emailid,$request->firstname)->subject($content);
		});
		$candidate_view = View::make('commontemplate/mail',
							compact('mailcontent',
									'visiturl',
									'signature'));
		$contentsCandidate = $candidate_view->render();
		$insert = User::insertRec($request,$Usercode,$mailcontent,$contentsCandidate);
		if($insert) {
			Session::flash('message', 'Registered and Mail send Sucessfully!');
			Session::flash('type', 'alert-success'); 
		} else {
			Session::flash('danger', 'Registered Unsucessfully!');
			Session::flash('type', 'alert-danger'); 
		}
		return Redirect::to('/');
	}

	/** Exists check process in register page
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/20
	*/
	public function mailexistcheck(Request $request) {
		$UserMailExist = User::fnGetEmailExistsCheck($request);
		$countEmail = count($UserMailExist);
		print_r($countEmail);exit();
	}

	/** User profile view process
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/21
	*/
	public function userprofile(Request $request) {
		$userId = "";
		if ($request->mainmenu == "menu_userlist" && isset($request->userId)) {
			$userId = $request->userId;
		} else {
			$userId = Auth::user()->userId;
		}
		if ($userId == "") {
			return Redirect::to('User/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$profileview = User::viewprofiledetails($userId);
		if ($profileview[0]->gender == 1) {
			$profileview[0]->gender = "Male";
		} else if ($profileview[0]->gender == 2) {
			$profileview[0]->gender = "Female";
		}
		return view('user.userprofileview',compact('request','profileview'));
	}

	/** User Register page view process in edit
	*  @author sarath 
	*  @param $request
	*  Created At 2020/08/21
	*/
	public function useredit(Request $request) {
		if(!isset($request->editflg)){
			return Redirect::to('User/profile?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$useredit = User::editview($request->editid);
		return view('user.register',compact('request','useredit'));
	}

	/** Verify login check process
	*  @author sastha 
	*  @param $request
	*  Created At 2020/08/24
	*/
	public function verifyLoginCheck(Request $request) {
		$verifyFlg = User::updVerifyFlg($request);
		Session::flash('message', 'Email Verified Sucessfully!');
		Session::flash('type', 'alert-success');
		return Redirect::to('/');
	}

}
?>
