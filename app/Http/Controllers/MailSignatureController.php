<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Model\MailSignature;
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
class MailSignatureController extends Controller {

	public function index(Request $request) {
		// Filter Process
		$disabledall = "";
		$disableduse = "";
		$disablednotuse = "";
		if (!isset($request->filvalhdn) || $request->filvalhdn == "") {
			$request->filvalhdn = 1;
		}
		if($request->filvalhdn == 1) {
			$disabledall = "disabled fb";
		} else if($request->filvalhdn == 2) {
			$disableduse = "disabled fb";
		} else if($request->filvalhdn == 3) {
			$disablednotuse = "disabled fb";
		}
		if ($request->plimit == "") {
			$request->plimit = 50;
		}
		$getlist=MailSignature::getMailSignatureData($request);
		return view('mailsignature.index',compact('request',
											'disabledall',
											'disableduse',
											'disablednotuse',
											'contenttotal',
											'getlist'));
	}
	public function mailSignatureFlg(Request $request){
		$signatureDelflg = MailSignature::fnUpdateDelflg($request);
		return Redirect::to('MailSignature/index?mainmenu=menu_mailsignature&time='.date('YmdHis'));
	}
	public function mailSignatureView(Request $request){
		if(Session::get('sigid') != ""){
			$request->signatureId = Session::get('sigid');
		}
		if(!isset($request->signatureId)){
			return Redirect::to('MailSignature/index?mainmenu=menu_mailsignature&time='.date('YmdHis'));
		}
		$mailSignatureView = MailSignature::getMailSignatureView($request);
		return view('mailsignature.mailsignatureview' ,compact('request',
											'mailSignatureView'
											));
	}

	public function mailSignatureAddEdit(Request $request){
		if (!isset($request->editflg)) {
			return Redirect::to('MailSignature/index?mainmenu=menu_mailsignature&time='.date('YmdHis'));
		}
		$getdataforupdate=array();
		$getname = "";
		if ($request->editflg == 1) {
			$getdataforupdate=MailSignature::fnFetchUpdateData($request);
			$getname = $getdataforupdate[0]->username." ".$getdataforupdate[0]->givenname." ".$getdataforupdate[0]->nickName;
		} 
		return view('mailsignature.mailsignatureaddedit',[
											'getdataforupdate' => $getdataforupdate,
											'request' => $request,
											'getname'=> $getname]);
	}
	public function mailSignaturePopup(Request $request){
		$empname = MailSignature::fnGetUserDetails($request);
		return view('mailsignature.mailsignaturepopup',['request' => $request,
														'empname' => $empname]);
	}
	public function getDataExist(Request $request){
		$dataExistCheck = MailSignature::fnFetchMailSigdata($request);
		if (!empty($dataExistCheck)) {
			$dataExistCheck = $dataExistCheck[0];
		}
		echo json_encode($dataExistCheck);exit();
	}
	public function mailSignatureRegValidation(Request $request){
		$commonrules=array();
		$commonrules = array(
			'txtuserid' => 'required',
			'content'=>'required',
		);
		$rules = $commonrules;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);exit;
        } else {
            $success = true;
            echo json_encode($success);
        }
	}
	public function mailSignatureAddEditProcess(Request $request){
		$signatureID = "SIGN00001";
		$signIdcnt = MailSignature::signIdGenerate($request);
		if(!empty($signIdcnt)){
			$signatureID = $signIdcnt[0]->signid;
		}
		if($request->editflg == 1){
			$id = "";
			if($request->updateprocess ==2){
				$id = $request->userid;
				$update=Mailsignature::fnFetchViewData($request,$id);
				$id = $update[0]->id;
			}else{
				$id = $request->signatureId;
			}
			$updatmailcontent=Mailsignature::fnUpdateMailSignature($request,$id);
			if($updatmailcontent){
				Session::flash('message', 'Inserted Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			}else{
				Session::flash('message', 'Inserted Unsucessfully!'); 
				Session::flash('type', 'alert-danger');
			}
			Session::flash('sigid', $id);
		}else{
			$insertmailsignature = MailSignature::fnInsertMailSignature($request,$signatureID);
			if($insertmailsignature) {
				Session::flash('message', 'Inserted Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('message', 'Inserted Unsucessfully!'); 
				Session::flash('type', 'alert-danger');
			}
			Session::flash('sigid', $insertmailsignature);
		}
		return Redirect::to('MailSignature/mailSignatureView?mainmenu=menu_mail&time='.date('YmdHis'));
	}
}
