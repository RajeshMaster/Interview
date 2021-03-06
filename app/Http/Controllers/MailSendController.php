<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Model\MailSend;
use App\Model\Employee;
use App\Http\Common\settingscommon;
use App\Model\Common;
use App\Model\SendingMail;
use Redirect;
use Session;
use Input;
use Config;
use Carbon;
use File;
use Storage;
use View;
use Illuminate\Support\Facades\Validator;
use FPDI_Protection;
use Mail;


/*Class: MailController
Some functions related to display the mail list and describing their particular details.*/
class MailSendController extends Controller {
	/**
	*
	* To Mail Status Index View
	* @author Rajesh
	* Created At 06/10/2020
	*
	*/

	public function index(Request $request) 
	{
		$resignid = 0;
		$empdetails = MailSend::fnGetEmployeeDetailsstart($request, $resignid);
		$empdetailsdet=array();
		$i = 0;
		foreach($empdetails as $key=>$data) {
			$recentClient = MailSend::fnGetClientDtl($data->Emp_ID);
			if (isset($recentClient->status) && $recentClient->status == 1 && $recentClient->delFLg == 1) {
				$empdetailsdet[$i] = $data->Emp_ID;
				$i++;
			}
		}

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

		$empdetails = mailsend::fnGetEmployeeDetails($request, $resignid,$empdetailsdet);
		// print_r($empdetails);exit;
		$empdetailsdet=array();
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

			/*$empdetailsdet[$i]['nickname'] = $data->nickname;*/
			$empdetailsdet[$i]['Mobile1'] = $data->Mobile1;
			$empdetailsdet[$i]['DOJ'] = $data->DOJ;
			$empdetailsdet[$i]['DOB'] = $data->DOB;
			$empdetailsdet[$i]['Emp_ID'] = $data->Emp_ID;
			$empdetailsdet[$i]['Emailpersonal'] = $data->Emailpersonal;
			$cusexpdetails = Common::getYrMonCountBtwnDates($empdetailsdet[$i]['DOJ'],'');

			if ($cusexpdetails['year'].".".$cusexpdetails['month'] == 0.0) {
				$empdetailsdet[$i]['experience'] = "0.0";
			} else {
				$empdetailsdet[$i]['experience'] = $cusexpdetails['year'].".".Common::fnAddZeroSubstring($cusexpdetails['month']);
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
				$empdetailsdet[$i]['recentxlResume'] = $recentResume->xlResume;
			} else {
				$empdetailsdet[$i]['recentResume'] = "";
				$empdetailsdet[$i]['resumeInsDate'] = "";
				$empdetailsdet[$i]['recentxlResume'] = "";
			}

			if ($empdetailsdet[$i]['clientEndDate'] != "" && $empdetailsdet[$i]['resumeInsDate'] != "") {
				if ($empdetailsdet[$i]['resumeInsDate'] > $empdetailsdet[$i]['clientEndDate']) {
					$empdetailsdet[$i]['presentResume'] = 1;
				} else {
					$empdetailsdet[$i]['presentResume'] = 0;
				}
			} else {
				$empdetailsdet[$i]['presentResume'] = 0;
			}
			$skill =MailSend::getSkillDetail($empdetailsdet[$i]['Emp_ID']);
			if (isset($skill[0]->youTubeUrl)){
				$empdetailsdet[$i]['youTubeUrl'] = $skill[0]->youTubeUrl;
			}else{
				$empdetailsdet[$i]['youTubeUrl'] = "";
			}
			$pgSkil = array();
			if (isset($skill[0]->japanese_skill)) {
				$jpSkil =explode(',', $skill[0]->japanese_skill);
				foreach ($jpSkil as $key => $value) {
					if($key == 0) {
						$jpSkil = MailSend::getJpSkill($value);
						$empdetailsdet[$i]['JpSkills'] = $jpSkil[0]->skillName;
					} else {
						$jpSkil = MailSend::getJpSkill($value);
						$empdetailsdet[$i]['JpSkills'] = $empdetailsdet[$i]['JpSkills'].','.$jpSkil[0]->skillName;
					}
				}
			}
			if (isset($skill[0]->programming_lang)) {
				$pgSkil =explode(',', $skill[0]->programming_lang);
				foreach ($pgSkil as $key => $value) {
					if($key == 0) {
						$singleSkill = MailSend::getSkillsingle($value);
						$empdetailsdet[$i]['PgSkills'] = $singleSkill[0]->ProgramLangTypeNM;
					} else {
						$singleSkill = MailSend::getSkillsingle($value);
						$empdetailsdet[$i]['PgSkills'] = $empdetailsdet[$i]['PgSkills'].','.$singleSkill[0]->ProgramLangTypeNM;
					}
				}
			}
			if (isset($skill[0]->os)) {
				$osSkill = explode(',', $skill[0]->os);
				foreach ($osSkill as $key => $value) {
					if($key == 0) {
						$OsSkill = MailSend::getOsName($value);
						$empdetailsdet[$i]['OsSkills'] = $OsSkill[0]->OSTypeNM;
					} else {
						$OsSkill = MailSend::getOsName($value);
						$empdetailsdet[$i]['OsSkills'] = $empdetailsdet[$i]['OsSkills'].','.$OsSkill[0]->OSTypeNM;
					}
				}
			}
			if (isset($skill[0]->data_base)) {
				$databaseSkill = explode(',', $skill[0]->data_base);
				foreach ($databaseSkill as $key => $value) {
					if($key == 0) {
						$databaseSkill = MailSend::getDataBaseName($value);
						$empdetailsdet[$i]['DataBaseSkills'] = $databaseSkill[0]->DBType;
					} else {
						$databaseSkill = MailSend::getDataBaseName($value);
						$empdetailsdet[$i]['DataBaseSkills'] = $empdetailsdet[$i]['DataBaseSkills'].','.$databaseSkill[0]->DBType;
					}
				}
			}
			if (isset($skill[0]->tool)) {
				$softwaretool = explode(',', $skill[0]->tool);
				foreach ($softwaretool as $key => $value) {
					if($key == 0) {
						$softwaretool = MailSend::getSoftWareToolName($value);
						$empdetailsdet[$i]['SoftWareTool'] = $softwaretool[0]->ToolTypeNM;
					} else {
						$softwaretool = MailSend::getSoftWareToolName($value);
						$empdetailsdet[$i]['SoftWareTool'] = $empdetailsdet[$i]['SoftWareTool'].','.$softwaretool[0]->ToolTypeNM;
					}
				}
			}	
			$i++;
		}
			
		$detailage = Employee::GetAvgage($resignid);

		return view('mailsend.index', ['request' => $request,
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
										'disabledRes'	=>$disabledRes]);
	}

	public function sendMailPost(Request $request) {
		if (!isset($request->selSendMail)) {
			return Redirect::to('MailSend/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$selSendMail = explode(',', $request->selSendMail);
		$empdetailsdet = array();
		$SelectedEmpid = "";
		$selectedEmpName = "";
		$firstLastName = "";
		$resuemPdf = "";
		$langSkills = "";
		$pSkill="";
		$lSkill="";
		$jSkill="";
		$OSkill="";
		$dbSkill="";
		$tSkill="";
		$dateTime = date("Ymd");
		$url = "";
		$tempdir = '../ResumeUpload/employeResume/temp';
		$directory = '../ResumeUpload/employeResume';

		foreach ($selSendMail as $key => $value) {
			$employeDetail = Common::fnGetEmployeeInfo($value);

			$empSkillDtls = mailsend::getSkillDetail($value);

			$recentClient = Employee::fnGetClientDtl($value);
			$recentResume = Employee::fnGetResume($value);

			if(isset($recentResume->resume)) {
				$recentResumeNm = $recentResume->resume;
				$resumeInsDate = $recentResume->createdDate;
			} else {
				$recentResumeNm = "";
				$resumeInsDate = "";
			}
			if ($SelectedEmpid == "") {
				$SelectedEmpid = $value;
				$selectedEmpName = $employeDetail[0]->FirstName;
				$firstLastName = strtoupper(substr($employeDetail[0]->LastName, 0, 1)).strtoupper(substr($employeDetail[0]->FirstName, 0, 1));
				$resuemPdf = $recentResumeNm;
			} else {
				$SelectedEmpid = $SelectedEmpid.','.$value;
				$selectedEmpName = $selectedEmpName.' , '.$employeDetail[0]->FirstName;
				$firstLastName =  $firstLastName.','.strtoupper(substr($employeDetail[0]->LastName, 0, 1)).strtoupper(substr($employeDetail[0]->FirstName, 0, 1));
				$resuemPdf = $resuemPdf.','.$recentResumeNm;
			}
			// Skill Setting Process
			if (isset($empSkillDtls[0]->programming_lang)) {
					$pgmLang = explode(',', $empSkillDtls[0]->programming_lang);
					foreach ($pgmLang as $keyskill => $skillVal) {
						if($keyskill == 0) {
							$singleSkill = MailSend::getSkillsingle($skillVal);
							$pgmLangSkills = $singleSkill[0]->ProgramLangTypeNM;
						} else {
							$singleSkill = MailSend::getSkillsingle($skillVal);
							$pgmLangSkills = $pgmLangSkills.','.$singleSkill[0]->ProgramLangTypeNM;
						}
					}

					$pSkill = trans('messages.lbl_skillname')." : ".$pgmLangSkills;
			}else{
				$pSkill="";
			}
			if (isset($empSkillDtls[0]->japanese_skill)){
					$jpskill = explode(',', $empSkillDtls[0]->japanese_skill);
					foreach ($jpskill as $keyskill => $jpVal) {
						if($keyskill == 0) {
							$jpskill = MailSend::getJpSkill($jpVal);
							$jpSkills = $jpskill[0]->skillName;
						} else {
							$jpskill = MailSend::getJpSkill($jpVal);
							$jpSkills = $jpSkills.','.$jpskill[0]->skillName;
						}
					}
					$jSkill = " ".trans('messages.lbl_japanese_skills')." : ".$jpSkills;
			}else{
				$jSkill="";
			}
			if (isset($empSkillDtls[0]->os)){
					$osskill = explode(',', $empSkillDtls[0]->os);
					foreach ($osskill as $keyskill => $osVal) {
						if($keyskill == 0) {
							$osskill = MailSend::getOsName($osVal);
							$osskills = $osskill[0]->OSTypeNM;
						} else {
							$osskill = MailSend::getOsName($osVal);
							$osskills = $osskills.','.$osskill[0]->OSTypeNM;
						}
					}
					$OSkill = " OS: ".$osskills;
			}else{
				$OSkill ="";
			}
			if (isset($empSkillDtls[0]->data_base)){
					$data_baseskill = explode(',', $empSkillDtls[0]->data_base);
					foreach ($data_baseskill as $keyskill => $dbVal) {
						if($keyskill == 0) {
							$dbskill = MailSend::getDataBaseName($dbVal);
							$dbskills = $dbskill[0]->DBType;
						} else {
							$dbskill = MailSend::getDataBaseName($dbVal);
							$dbskills = $dbskills.','.$dbskill[0]->DBType;
						}
					}
					$dbSkill = " DB: ".$dbskills;
			}else{
				$dbSkill="";
			}
			if (isset($empSkillDtls[0]->tool)) {
				$softwaretool = explode(',', $empSkillDtls[0]->tool);
				foreach ($softwaretool as $key => $value) {
					if($key == 0) {
						$softwaretool = MailSend::getSoftWareToolName($value);
						$softwaretools = $softwaretool[0]->ToolTypeNM;
					} else {
						$softwaretool = MailSend::getSoftWareToolName($value);
						$softwaretools = $softwaretools.','.$softwaretool[0]->ToolTypeNM;
					}
				}
				$tSkill =" Tool: ".$softwaretools;
			}else{
				$tSkill ="";
			}	
			if ($langSkills == ""){
				if ($pSkill!="" || $jSkill!="" ||  $OSkill!="" ||  $dbSkill!="" || $tSkill!="") {
					$langSkills = $employeDetail[0]->FirstName." -> ".$pSkill.$jSkill.$OSkill.$dbSkill.$tSkill;
				}
			}else{
				if ($pSkill!="" || $jSkill!="" ||  $OSkill!="" ||  $dbSkill!="" || $tSkill!="") {
					$langSkills = $langSkills.';'.$employeDetail[0]->FirstName." -> ".$pSkill.$jSkill.$OSkill.$dbSkill.$tSkill;
				}
			}
			
			if ($recentResumeNm == "") {
				Session::flash('danger','Add Cv to all Selected Employee!'); 
				Session::flash('type','alert-danger');
				return Redirect::to('MailSend/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
			} else if($recentResume->createdDate < $recentClient->Ins_DT) {
				Session::flash('danger','Add Cv to all Selected Employee!'); 
				Session::flash('type','alert-danger');
				return Redirect::to('MailSend/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
			}
			$Nameletters = strtoupper(substr($employeDetail[0]->LastName, 0, 1)).strtoupper(substr($employeDetail[0]->FirstName, 0, 1));
		
			if ($url == "") {
				if (isset($empSkillDtls[0]->youTubeUrl)) {
					
					$url = $Nameletters .'->'. $empSkillDtls[0]->youTubeUrl ;
				}
			} else {
				if (isset($empSkillDtls[0]->youTubeUrl)) {
					$url = $url.','. $Nameletters .'->'.$empSkillDtls[0]->youTubeUrl;
				}
			}
			$empdetailsdet[$key]['name'] = $employeDetail[0]->FirstName;
			$empdetailsdet[$key]['resume'] = $recentResumeNm;

			if($recentResumeNm != ""){
				if (!is_dir($tempdir)) {
					if (@mkdir($tempdir)) {
						$file = $directory ."/".$recentResumeNm;
						$newfile = $tempdir."/".$recentResumeNm;
						
						if(file_exists($file)) {
							copy($file,$newfile);
						}
					}
				} else {
					$file = $directory ."/".$recentResumeNm;
					$newfile = $tempdir."/".$recentResumeNm;

					if(file_exists($file)) {
						copy($file,$newfile);
					}
				}
			}
		}
		$details = mailsend::selCustomer();
		foreach ($details as $key => $value) {
			$customerarray[$value->customer_id] = $value->customer_name;
		}
		
		$noimage = "../public/images";
		return view('mailsend.postaddedit',['request' => $request,
										'customerarray' => $customerarray,
										'SelectedEmpid' => $SelectedEmpid,
										'selectedEmpName' => $selectedEmpName,
										'firstLastName' => $firstLastName,
										'resuemPdf' => $resuemPdf,
										'langSkills' => $langSkills,
										'dateTime' => $dateTime,
										'url' => $url,
										'noimage' => $noimage,
										'empdetailsdet'=> $empdetailsdet ]);
	}

	/**
	*
	* Validation for work end Date
	* @author Rajesh
	* @return object to particular view page
	* Created At 2020/10/02
	*
	*/
	public function sendMialvalidation(Request $request) {
		$commonrules=array();
		$common2 = array();
		$common3 = array();
		$common4 = array();

		$common1 = array(
			'subject'=>'required',
			'txt_content'=>'required',
		);

		if($request->selectedType == 1) {
			$common3 = array(
				'groupname'=>'required',
			);
		}

		if($request->selectedType == 2) {
			$common2 = array(
				'customerName' => 'required',
				'branchId'=>'required',
				'inchargeDetails'=>'required',
			);
		}
			
		$commonrules = $common1 + $common2 + $common3 + $common4;
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
	* Created At 2020/10/02
	*
	*/
	public function sendMailpostProcess(Request $request) {
		$ProjectLink = "http://localhost/Interview/";
		// print_r($request->all());exit();
		$customerId = $request->customerId;
		$branchId = $request->branchId;
		$inchargeId = $request->hidincharge;
		$selectedEmp = $request->selectedEmployee;
		$currentDateTime = date('YmdHis');
		if ($request->ccemail != "") {
			$ccemail = $request->ccemail;
		} else {
			$ccemail = NULL;
		}
		if($request->hidccid != "") {
			$hidccid = $request->hidccid;
		} else {
			$hidccid = "";
		}
		$selectedEmployeeResume = $request->selectedEmployeeResume;
		$pdf_array = array();
		$email_array = array();
		$cus_array = array();
		$customerval = "";
		$sendmail = "";

		$OlddestinationPath = '../ResumeUpload/employeResume';
		$pdfpassword = substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', 8)), 0, 8);
		$selectedEmp = explode(',', $selectedEmp);
		$selectedEmployeeResume = explode(',', $selectedEmployeeResume);
		$destinationPath = '../ResumeUpload/employeResume/temp';
		$mailId = "MAIL0007";
		$data = Common::getContentFirst($mailId);
		$mailIdboth = "MAIL0008";
		$databoth = Common::getContentFirst($mailIdboth);
		$mailAgent = "MAIL0010";
		$dataAgent= Common::getContentFirst($mailAgent);

		if(trim($request->txt_content) == "") {
			$data[0]->content = str_replace('Remark : RRRR','', $data[0]->content);
			$databoth[0]->content = str_replace('Remark : RRRR','', $databoth[0]->content);
			$dataAgent[0]->content = str_replace('Remark : RRRR','', $dataAgent[0]->content);
		} else {
			$data[0]->content = str_replace('RRRR',$request->txt_content, $data[0]->content);
			$data[0]->content = str_replace('RRRR',$request->txt_content, $data[0]->content);
			$data[0]->content = str_replace('RRRR',$request->txt_content, $data[0]->content);
		}
		if(trim($request->videoUrl) == "") {
			$data[0]->content = str_replace('Video','', $data[0]->content);
			$data[0]->content = str_replace('LINK','', $data[0]->content);
			$databoth[0]->content = str_replace('Video','', $databoth[0]->content);
			$databoth[0]->content = str_replace('LINK','', $databoth[0]->content);
			$dataAgent[0]->content = str_replace('Video','', $dataAgent[0]->content);
			$dataAgent[0]->content = str_replace('LINK','', $dataAgent[0]->content);
		} else {
			$data[0]->content = str_replace('Video','依頼頼んだ方の自己PR動画のURLを添付しております。', $data[0]->content);
			$databoth[0]->content = str_replace('Video','依頼頼んだ方の自己PR動画のURLを添付しております。', $databoth[0]->content);
			$dataAgent[0]->content = str_replace('Video','依頼頼んだ方の自己PR動画のURLを添付しております。', $dataAgent[0]->content);
			$url = explode(',', $request->videoUrl);
			$urlValue = "";
			foreach ($url as $Ukey => $Uvalue) {
				$urlValue .= $Uvalue."\r\n";
			}
			$data[0]->content = str_replace('LINK',$urlValue, $data[0]->content);
			$databoth[0]->content = str_replace('LINK',$urlValue, $databoth[0]->content);
			$dataAgent[0]->content = str_replace('LINK',$urlValue, $dataAgent[0]->content);
		}
		//if (isset($request->chk_passwordencryption) && $request->chk_passwordencryption!="") {
			$data[0]->content = str_replace('<password>',$pdfpassword, $data[0]->content);
		/*} else{
			$data[0]->content = str_replace('パスワード　:<password>','', $data[0]->content);
			$data[0]->content = str_replace('添付したファイルのパスワードは下記のようです。','',$data[0]->content);
		}*/
		if(trim($request->empSkills) == "") {
			$data[0]->content = str_replace('Skills','', $data[0]->content);
			$databoth[0]->content = str_replace('Skills','', $databoth[0]->content);
			$dataAgent[0]->content = str_replace('Skills','', $dataAgent[0]->content);
		} else {
			$data[0]->content = str_replace('Skills',"Skills : ".$request->empSkills,$data[0]->content);
			$databoth[0]->content = str_replace('Skills',"Skills : ".$request->empSkills, $databoth[0]->content);
			$dataAgent[0]->content = str_replace('Skills',"Skills : ".$request->empSkills, $dataAgent[0]->content);
		}
		$dateTime = $request->dateTime;
		foreach ($selectedEmp as $key => $value) {
			$getDateTime = Common::getSystemDateTime();
			$currentDate = $getDateTime[0]->CURRENT_TIMESTAMP;
			// $updIntDateTime = Interview::updIntDateTime($value,$currentDate);
			$empName = Common::fnGetEmployeeInfo($value);
			$getmailId = "";
			$getmailIds = "";
			$getmail = "";
			$getAgentmailIds = "";
			$securePath = '../ResumeUpload/employeResume/secure/'; 
			if(!is_dir($securePath)) {
				mkdir($securePath, 0777, true);
			}
			$pdfOldFile = $destinationPath.'/'. $selectedEmployeeResume[$key];
			$pdfNewFile = $destinationPath.'/'.strtoupper(substr($empName[0]->LastName, 0, 1)).strtoupper(substr($empName[0]->FirstName, 0, 1))."_".$dateTime.'.pdf';
			$securename = '../ResumeUpload/employeResume/secure/'.strtoupper(substr($empName[0]->LastName, 0, 1)).strtoupper(substr($empName[0]->FirstName, 0, 1))."_".$dateTime.str_pad($key+1,2,"0",STR_PAD_LEFT).'.pdf';
			$tochangesecure = $OlddestinationPath.'/'. $selectedEmployeeResume[$key];
			if(file_exists($pdfOldFile)) {
				 self::pdfEncrypts($tochangesecure,$pdfpassword,$securename,$request);
				rename($pdfOldFile,$pdfNewFile);
				//if (isset($request->chk_passwordencryption) && $request->chk_passwordencryption!="") {
					array_push($pdf_array, $securename);
				//} else {
			//		array_push($pdf_array, $pdfNewFile);
			//	}
			}
		}
		$groupId = $request->groupvalue;
		$inchGrpNameArr =array();
		if($groupId != "") {
			$value = explode(';', $groupId);
			for ($i=0; $i <count($value)-1 ; $i++) { 
				$groupsends = mailsend::groupsends($value[$i]);
				// For Group Senmail
				foreach ($groupsends as $key => $groups) {
					// Check to send mail onlyg one time
					if (!in_array($groups->incharge_email_id,$inchGrpNameArr)) {
						array_push($inchGrpNameArr,$groups->incharge_email_id);
						// if($groupId!="" && $groups->sendpasswrodFlg == 1) {
						$customerid = $groups->customer_id;
						$groupid = $groups->incharge_email_id;
						$getmailIds .= $groupid.',';
						if($customerid!=""){
							$customerval = $customerid;
							array_push($cus_array,$customerid);
						}
						$branchID = $groups->branch_name;
						$inchargename = $groups->incharge_name;
						$CustomerName = mailsend::getCustomerName($customerid);
						$mailId = $groupid;
						$customerIdCom = $customerid;
						$ProjectFolder = $ProjectLink.'User/verifyLogin?customerId='.$customerIdCom.'&mailId='.$mailId.'&dateTime='.$currentDateTime;
						$data[0]->content = str_replace('EMPURL', 'URL:'.$ProjectFolder, $data[0]->content);
						$body = $data[0]->content;
						$replace_contents = ['Admin','CustomerName','InchargeName','<password>'];
						$real_contents = [$groupid,$CustomerName[0]->customer_name,$inchargename,$pdfpassword];
						$bodyrep = str_replace($replace_contents, $real_contents, $body);
						$subject = str_replace('XXXX', 'Post Mail Successfully', $request->subject);
						$mailformat = [$bodyrep];
						/*$mailId = $groupid;
						$customerIdCom = $customerid;
						$sendmail = Mail::send('commontemplate/mail',compact('mailformat','mailId','customerIdCom','currentDateTime'), 
						function($message) use ($request,$groupid,$pdf_array,$hidccid) {	
							$message->from('staff@microbit.co.jp','MICROBIT');
							$message->to($groupid)
									->subject($request->subject);
							if ($pdf_array != array()) {
								$message->attach($pdf_array);
							}*/
							if ($hidccid != "") {
								$cusIdCC = explode(",", $hidccid);
								foreach ($cusIdCC as $keyCC => $valueCC) {
									$inchargeCC = mailsend::fnGetmail($valueCC);
									$inchargeCC = rtrim($inchargeCC,",");
									$inchargeCC = explode(",", $inchargeCC);
									// $message->cc($inchargeCC);
									$sendmail = SendingMail::sendIntimationMail($mailformat,$groupid,$subject,$inchargeCC,'','',$pdf_array);
								}
							} else {
								$sendmail = SendingMail::sendIntimationMail($mailformat,$groupid,$subject,'','','',$pdf_array);
							}
						// });
						// $sendmail = SendingMail::sendIntimationMail($mailformat,$groupid,$subject,$ccemail,'','',$pdf_array);
						/*} else {
							$customerid= $groups->customer_id;
							$groupid = $groups->incharge_email_id;
							$getmailIds .= $groupid.',';
							if($customerid!=""){
								$customerval = $customerid;
								array_push($cus_array,$customerid);
							}
							$branchID = $groups->branch_name;
							$inchargename = $groups->incharge_name;
							$body = $databoth[0]->header."\n";
							$body .= $databoth[0]->content;
							$CustomerName = mailsend::getCustomerName($customerid);
							$replace_contents = ['TTTT','CustomerName','InchargeName','DDDD','<password>'];
							$real_contents = [$groupid,$CustomerName[0]->customer_name,$inchargename,'mb',$pdfpassword];
							$bodyrep = str_replace($replace_contents, $real_contents, $body);
							$subject = str_replace('XXXX', 'Post Mail Successfully', $request->subject);
							$mailformat = [$bodyrep];
							$sendmail = SendingMail::sendIntimationMail($mailformat,$groupid,$subject,$ccemail,'','',$pdf_array);
						}*/
					}

				}
				
				$groupAgentsends = mailsend::groupAgentsends($value[$i]);
				foreach ($groupAgentsends as $key => $agent) {
					if (!in_array($agent->agent_email_id,$inchGrpNameArr)) {
						array_push($inchGrpNameArr,$agent->agent_email_id);
						$agentMail = $agent->agent_email_id;
						if ($agentMail  != "") {
							if(trim($request->txt_content) == "") {
								$dataAgent[0]->content = str_replace('Remark : RRRR','', $dataAgent[0]->content);
							} else {
								$dataAgent[0]->content = str_replace('RRRR',$request->txt_content, $dataAgent[0]->content);
							}
							$cusId = $agent->customer_id;
							$getAgentmailIds .= $agentMail.',';
							$agentName = $agent->agent_name;
							$CustomerName = mailsend::getCustomerName($cusId);
							$mailId = $agentMail;
							$customerIdCom = $cusId;
							$ProjectFolder = $ProjectLink.'User/verifyLogin?customerId='.$customerIdCom.'&mailId='.$mailId.'&dateTime='.$currentDateTime;
							$dataAgent[0]->content = str_replace('EMPURL', 'URL:'.$ProjectFolder, $dataAgent[0]->content);
							$body1 = $dataAgent[0]->content;
							$replace_contents1 = ['Admin','CustomerName','InchargeName','<password>'];
							$real_contents1 = [$agentMail,$CustomerName[0]->customer_name,$agentName,$pdfpassword];
							$bodyrep1 = str_replace($replace_contents1, $real_contents1, $body1);
							$subject1 = str_replace('XXXX', 'Post Mail Successfully', $request->subject);
							$mailformat1 = [$bodyrep1];
							/*$mailId = $agentMail;
							$customerIdCom = $cusId;
							$sendmail1 = Mail::send('commontemplate/mail',compact('mailformat1','mailId','customerIdCom','currentDateTime'), 
							function($message) use ($request,$subject1,$agentMail,$pdf_array,$hidccid) {	
								$message->from('staff@microbit.co.jp','MICROBIT');
								$message->to($agentMail)
										->subject($subject1);
								if ($pdf_array != array()) {
									$message->attach($pdf_array);
								}*/
								if ($hidccid != "") {
									$cusIdCC = explode(",", $hidccid);
									foreach ($cusIdCC as $keyCC => $valueCC) {
										$inchargeCC = mailsend::fnGetmail($valueCC);
										$inchargeCC = rtrim($inchargeCC,",");
										$inchargeCC = explode(",", $inchargeCC);
										// $message->cc($inchargeCC);
										$sendmail1 = SendingMail::sendIntimationMail($mailformat1,$agentMail,$subject1,$inchargeCC,'','',$pdf_array);
									}
								} else {
									$sendmail1 = SendingMail::sendIntimationMail($mailformat1,$agentMail,$subject1,'','','',$pdf_array);
								}
							// });
							// $sendmail1 = SendingMail::sendIntimationMail($mailformat1,$agentMail,$subject1,$ccemail,'','',$pdf_array);
						}
					}
				}
			}
		}
		if ($groupId != "" &&  $sendmail != "") {
			$email_array = array_unique($cus_array);
			foreach ($selectedEmp as $key => $value) {
				if($sendmail) {
					$subject = $request->subject;
					foreach ($email_array as $keys => $customerID) {
						$getmail = mailsend::fnGetmail($customerID);
						$getAgentMail = mailsend::getAgentMail($customerID);
						if (isset($getAgentMail[0])) {
							$allmailIds = $getmail.$getAgentMail[0]->agent_email_id;
						} else {
							$allmailIds = substr($getmail,0,-1);
						}
						$mailSendList = mailsend::mailPostSendList($allmailIds,$subject,$value,$customerID,$branchID,$selectedEmployeeResume[$key],$currentDateTime);
					}
				}
			}
		}


		$inchargeId = "";
    	if ($request->hidincharge != "") {
    		$rest = substr($request->hidincharge, 0, -1);  
    		$inchargeId = explode(";", $rest);
    	}
		$getInchargeDetails = mailsend::fngetInchargeDetails($request,$customerId,$branchId,$inchargeId);
		foreach ($getInchargeDetails as $key1 => $value1) {
			// if ($value1->sendpasswrodFlg == 1) {
			$email = $value1->incharge_email_id;
			$getmailId .= $email.',';
			$custID= $value1->customer_id;
			$BranchId= $value1->branch_name;
			$name = $value1->incharge_name;
			$mailId = $email;
			$customerIdCom = $custID;
			$ProjectFolder = $ProjectLink.'User/verifyLogin?customerId='.$customerIdCom.'&mailId='.$mailId.'&dateTime='.$currentDateTime;
			$data[0]->content = str_replace('EMPURL','URL:'.$ProjectFolder, $data[0]->content);
			$body = $data[0]->content;
			$CustomerName = mailsend::getCustomerName($custID);
			$replace_contents = ['Admin','CustomerName','InchargeName','<password>'];
			$real_contents = [$email,$CustomerName[0]->customer_name,$name,$pdfpassword];
			$bodyrep = str_replace($replace_contents, $real_contents, $body);
			$subject = str_replace('XXXX', 'Post Mail Successfully', $request->subject);
			$mailformat = [$bodyrep];
			if(!in_array($customerId,$email_array)){
				/*$mailId = $email;
				$customerIdCom = $custID;
				$sendmail = Mail::send('commontemplate/mail',compact('mailformat','mailId','customerIdCom','currentDateTime'), 
				function($message) use ($request,$subject,$email,$pdf_array,$hidccid) {
					$message->from('staff@microbit.co.jp','MICROBIT');
					$message->to($email)
							->subject($subject);
					if ($pdf_array != array()) {
						$message->attach($pdf_array);
					}*/
					if ($hidccid != "") {
						$cusIdCC = explode(",", $hidccid);
						foreach ($cusIdCC as $keyCC => $valueCC) {
							$inchargeCC = mailsend::fnGetmail($valueCC);
							$inchargeCC = rtrim($inchargeCC,",");
							$inchargeCC = explode(",", $inchargeCC);
							// $message->cc($inchargeCC);
							$sendmail = SendingMail::sendIntimationMail($mailformat,$email,$subject,$inchargeCC,'','',$pdf_array);
						}
					} else {
						$sendmail = SendingMail::sendIntimationMail($mailformat,$email,$subject,'','','',$pdf_array);
					}
				// });
				// $sendmail = SendingMail::sendIntimationMail($mailformat,$email,$subject,$ccemail,'','',$pdf_array);
			}
					
			// } else {
			// 	$email = $value1->incharge_email_id;
			// 	$getmailId .= $email.',';
			// 	$custID= $value1->customer_id;
			// 	$BranchId= $value1->branch_name;
			// 	$name = $value1->incharge_name;
			// 	$body = $databoth[0]->header."\n";
			// 	$body .= $databoth[0]->content;
			// 	$CustomerName = mailsend::getCustomerName($custID);
			// 	$replace_contents = ['TTTT','CustomerName','InchargeName','DDDD','<password>'];
			// 	$real_contents = [$email,$CustomerName[0]->customer_name,$name,'mb',$pdfpassword];
			// 	$bodyrep = str_replace($replace_contents, $real_contents, $body);
			// 	$subject = str_replace('XXXX', 'Post Mail Successfully', $request->subject);
			// 	$mailformat = [$bodyrep];
			// 	if(!in_array($customerId,$email_array)){
			// 		$sendmail = SendingMail::sendIntimationMail($mailformat,$email,$subject,$ccemail,'','',$pdf_array);
			// 	} if ($sendmail) {
			// 		$changeMAilFlg = SendingMail::changeMailFlg($email);
			// 	}
			// }
		}
		/*if($getmailId != ""){
			$allmailId = substr($getmailId,0,-1);
			if($sendmail){
				$mailSendList = mailsend::mailPostSendList($allmailId,$subject,$request->selectedEmployee,$custID,$BranchId,$request->selectedEmployeeResume,$currentDateTime);
			}
		}*/
		$agentMail = mailsend::getAgentMail($customerId);
		$CustomerName = mailsend::getCustomerName($customerId);
		if (isset($agentMail[0]->agent_email_id) && $agentMail[0]->agent_email_id != "") {
			$mailId = $agentMail[0]->agent_email_id;
			$customerIdCom = $customerId;
			$ProjectFolder = $ProjectLink.'User/verifyLogin?customerId='.$customerIdCom.'&mailId='.$mailId.'&dateTime='.$currentDateTime;
			$dataAgent[0]->content = str_replace('EMPURL', 'URL:'.$ProjectFolder, $dataAgent[0]->content);
			$body1 = $dataAgent[0]->content;
			$replace_contents1 = ['Admin','CustomerName','InchargeName','<password>'];
			$real_contents1 = [$agentMail[0]->agent_email_id,$CustomerName[0]->customer_name,$agentMail[0]->agent_name,$pdfpassword];
			$bodyrep1 = str_replace($replace_contents1, $real_contents1, $body1);
			$subject1 = str_replace('XXXX', 'Post Mail Successfully', $request->subject);
			$mailformat1 = [$bodyrep1];
			if(!in_array($customerId,$email_array)){
				/*$mailId = $agentMail[0]->agent_email_id;
				$customerIdCom = $customerId;
				$sendmail1 = Mail::send('commontemplate/mail',compact('mailformat','mailId','customerIdCom','currentDateTime'), 
				function($message) use ($request,$subject1,$agentMail,$pdf_array,$hidccid) {	
					$message->from('staff@microbit.co.jp','MICROBIT');
					$message->to($agentMail[0]->agent_email_id)
							->subject($subject1);
					if ($pdf_array != array()) {
						$message->attach($pdf_array);
					}*/
					if ($hidccid != "") {
						$cusIdCC = explode(",", $hidccid);
						foreach ($cusIdCC as $keyCC => $valueCC) {
							$inchargeCC = mailsend::fnGetmail($valueCC);
							$inchargeCC = rtrim($inchargeCC,",");
							$inchargeCC = explode(",", $inchargeCC);
							// $message->cc($inchargeCC);
							$sendmail1 = SendingMail::sendIntimationMail($mailformat1,$agentMail[0]->agent_email_id,$subject1,$inchargeCC,'','',$pdf_array);
						}
					} else {
						$sendmail1 = SendingMail::sendIntimationMail($mailformat1,$agentMail[0]->agent_email_id,$subject1,'','','',$pdf_array);
					}
				// });
				// $sendmail1 = SendingMail::sendIntimationMail($mailformat1,$agentMail[0]->agent_email_id,$subject1,$ccemail,'','',$pdf_array);
			} 
		}

		if($request->hidincharge != "" && $customerId != "") {
			foreach ($selectedEmp as $key => $value) {
				if($sendmail) {
					$getAgentMail = mailsend::getAgentMail($customerId);
					if (isset($getAgentMail[0])) {
						$allmailId = $getmailId.$getAgentMail[0]->agent_email_id;
					} else {
						$allmailId = substr($getmailId,0,-1);
					}
					$subject = $request->subject;
					if(!in_array($customerId,$email_array)){
						$mailSendList = mailsend::mailPostSendList($allmailId,$subject,$value,$custID,$BranchId,$selectedEmployeeResume[$key],$currentDateTime);
					}
				}
			}
		}
		$othermail = array();
		if (isset($request->hidmailSelectedid) && $request->hidmailSelectedid!="") {
			$otherselectid = explode(";", $request->hidmailSelectedid);
			$getOthermailDt = mailsend::getOtherNameEmail($otherselectid);
			foreach ($getOthermailDt as $key1 => $value1) {
				$email = $value1->other_mailid;
				$other_name = $value1->other_name;
				$getmailId .= $email.',';
				$name = "Testing";
				$mailId = $email;
				$customerIdCom = "OtherMail";
				$ProjectFolder = $ProjectLink.'User/verifyLogin?customerId='.$customerIdCom.'&mailId='.$mailId.'&dateTime='.$currentDateTime;
				$data[0]->content = str_replace('EMPURL', 'URL:'.$ProjectFolder, $data[0]->content);
				$body = $data[0]->content;
				$replace_contents = ['Admin','CustomerName','InchargeName','<password>'];
				$real_contents = [$email,$other_name,$other_name,$pdfpassword];
				$bodyrep = str_replace($replace_contents, $real_contents, $body);
				$subject = str_replace('XXXX', 'Post Mail Successfully', $request->subject);
				$mailformat = [$bodyrep];
				/*$mailId = $email;
				$customerIdCom = "OtherMail";
				$sendmail = Mail::send('commontemplate/mail',compact('mailformat','mailId','customerIdCom','currentDateTime'), 
				function($message) use ($request,$subject,$email,$pdf_array,$hidccid) {	
					$message->from('staff@microbit.co.jp','MICROBIT');
					$message->to($email)
							->subject($subject);
					if ($pdf_array != array()) {
						$message->attach($pdf_array);
					}*/
					if ($hidccid != "") {
						$cusIdCC = explode(",", $hidccid);
						foreach ($cusIdCC as $keyCC => $valueCC) {
							$inchargeCC = mailsend::fnGetmail($valueCC);
							$inchargeCC = rtrim($inchargeCC,",");
							$inchargeCC = explode(",", $inchargeCC);
							// $message->cc($inchargeCC);
							$sendmail = SendingMail::sendIntimationMail($mailformat,$email,$subject,$inchargeCC,'','',$pdf_array);
						}
					} else {
						$sendmail = SendingMail::sendIntimationMail($mailformat,$email,$subject,'','','',$pdf_array);
					}
				// });
			   	// $sendmail = SendingMail::sendIntimationMail($mailformat,$email,$subject,$ccemail,'','',$pdf_array);
			}
		}
		if(isset($request->tomailDetails) && $request->tomailDetails != ""){
			$othermail1 = explode(";", $request->tomailDetails);
			$otherName =  explode(";", $request->tomailName);
			$i = 0;
			$j = 0;
			foreach ($othermail1 as $key => $value) {
				$othermail[$i]['others_mail'] = $value;
				$i++;
			}
			foreach ($otherName as $key => $value1) {
				$othermail[$j]['others_name']= $value1;
				$j++;
			}
			$k = 0;
			for ($k = 0; $k < count($othermail); $k++){
				$email = $othermail[$k]['others_mail'];
				$other_name = $othermail[$k]['others_name'];
				$insert = mailsend::regOtherMail($email,$other_name);
				$getmailId .= $email.',';
				$name = "Testing";
				$mailId = $email;
				$customerIdCom = "OtherMail";
				$ProjectFolder = $ProjectLink.'User/verifyLogin?customerId='.$customerIdCom.'&mailId='.$mailId.'&dateTime='.$currentDateTime;
				$data[0]->content = str_replace('EMPURL', 'URL:'.$ProjectFolder, $data[0]->content);
				$body = $data[0]->content;
				$replace_contents = ['Admin','CustomerName','InchargeName','<password>'];
				$real_contents = [$email,$other_name,$other_name,$pdfpassword];
				$bodyrep = str_replace($replace_contents, $real_contents, $body);
				$subject = str_replace('XXXX', 'Post Mail Successfully', $request->subject);
				$mailformat = [$bodyrep];
				if(!in_array($customerId,$email_array)){
					/*$mailId = $email;
					$customerIdCom = "OtherMail";
					$sendmail = Mail::send('commontemplate/mail',compact('mailformat','mailId','customerIdCom','currentDateTime'), 
					function($message) use ($request,$subject,$email,$pdf_array,$hidccid) {	
						$message->from('staff@microbit.co.jp','MICROBIT');
						$message->to($email)
								->subject($subject);
						if ($pdf_array != array()) {
							$message->attach($pdf_array);
						}*/
						if ($hidccid != "") {
							$cusIdCC = explode(",", $hidccid);
							foreach ($cusIdCC as $keyCC => $valueCC) {
								$inchargeCC = mailsend::fnGetmail($valueCC);
								$inchargeCC = rtrim($inchargeCC,",");
								$inchargeCC = explode(",", $inchargeCC);
								// $message->cc($inchargeCC);
								$sendmail = SendingMail::sendIntimationMail($mailformat,$email,$subject,$inchargeCC,'','',$pdf_array);
							}
						} else {
							$sendmail = SendingMail::sendIntimationMail($mailformat,$email,$subject,'','','',$pdf_array);
						}
					// });
					// $sendmail = SendingMail::sendIntimationMail($mailformat,$email,$subject,$ccemail,'','',$pdf_array);
				}
			}
		}
		Session::flash('success','Post Mail Send sucessfully!'); 
		Session::flash('type','alert-success'); 

		return Redirect::to('MailSend/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}

	public static function pdfEncrypts ($origFile, $password, $destFile, $request){
		//include the FPDI protection http://www.setasign.de/products/pdf-php-solutions/fpdi-protection-128/
		require_once('vendor/setasign/fpdiprotect/FPDI_Protection.php');
		$pdf = new FPDI_Protection();
		// set the format of the destinaton file, in our case 6×9 inch
		$pdf->FPDF('P', 'in');
		//calculate the number of pages from the original document
		$pagecount = $pdf->setSourceFile($origFile);
		// copy all pages from the old unprotected pdf in the new one
		for ($loop = 1; $loop <= $pagecount; $loop++) {
		    $tplidx = $pdf->importPage($loop);
		    $pdf->addPage();
		    $pdf->useTemplate($tplidx);
		}
		// protect the new pdf file, and allow no printing, copy etc and leave only reading allowed
		if ($request->nopassword != 1) {
			$pdf->SetProtection(array('print'),$password);
		}
		$pdf->Output($destFile, 'F');
	}

	public function inchargenamepopup (Request $request){
		$getdetails= Mailsend::getpopupincharge($request->branchid);
		$othermail = MailSend::getOthermailDt();
		return view('mailsend.inchargeSelPopup',['request' => $request,
												'getdetails' => $getdetails,'othermail'=>$othermail]);
	}


	/**
	*
	* Group Select Process
	* @author Rajesh
	* @return object to particular Popup view page
	* Created At 2020/10/05
	*
	*/
	public function groupadd(Request $request) {
		$getallGroup = Mailsend::getallGroup();
		return view('mailsend.groupselectpopup',['request' => $request,'getallGroup' => $getallGroup]);
	}

	/**
	*
	* PDF View Process
	* @author Sastha
	* @return object to Send Mail view page
	* Created At 2020/10/15
	*
	*/
	public static function pdfViewProcess(Request $request) {

		if (!isset($request->filename)) {
			return Redirect::to('MailSend/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
		}
		$path = '../ResumeUpload/employeResume';
		$filename = $path."/".$request->filename;
		header('Content-type: application/pdf'); 
		header('Content-Disposition: inline; filename="' . $filename . '"'); 
		header('Content-Transfer-Encoding: binary'); 
		header('Accept-Ranges: bytes');
		@readfile($filename); 

	}

	public static function skillAdd(Request $request){

		$empSkill = MailSend::getSkillDetail($request->empId);
		$pgDetails =array();
		$headinglbl ="";
		$field1lbl ="";
		$selectfiled =array();
		$skilTblNn ="";
		$getJapaneseLevel = array("N1レベル"=>"N1レベル",
							"N2レベル"=>"N2レベル",
							"N3レベル"=>"N3レベル", 
							"N4レベル"=>"N4レベル", 
							"N5レベル"=>"N5レベル" 
		);

		$getSkills = array("emp_sysostypes"=>"Operating System",
							"emp_sysprogramlangtypes"=>"Programming Language",
							"emp_sysdbtypes"=>"DataBsae", 
							"emp_systooltypes"=>"Software Tools",
							"jplanguage_skill" => "Japanese Skill"
		);
		$getTableFields = settingscommon::getDbFieldsforProcess();
		if ($request->skillSel != "" ) {

			$pgDetails = MailSend::selectOnefieldDatas($getTableFields[$request->skillSel]['selectfields'],$getTableFields[$request->skillSel]['commitfields'][0],$request);

			$headinglbl = $getTableFields[$request->skillSel]['labels']['heading'];
			$field1lbl = $getTableFields[$request->skillSel]['labels']['field1lbl'];
			$selectfiled  = $getTableFields[$request->skillSel]['selectfields'];

			if ($request->skillSel == 'emp_sysostypes') {
				$skilTblNn = 'os';
			} elseif ($request->skillSel == 'emp_sysprogramlangtypes') {
				$skilTblNn = 'programming_lang';
			} elseif ($request->skillSel == 'emp_sysdbtypes') {
				$skilTblNn = 'data_base';
			} elseif ($request->skillSel == 'emp_systooltypes') {
				$skilTblNn = 'tool';
			}elseif ($request->skillSel == 'jplanguage_skill') {
				$skilTblNn = 'japanese_skill';
			}
		}

		if(!empty($empSkill)){
			$editFlg = 1;
		}else{
			$editFlg = 0;
		}
// print_r($pgDetails);

		return view('mailsend.skillSelPopup',['request' => $request,
												'pgDetails' => $pgDetails,
												'empSkill' => $empSkill,
												'editFlg' => $editFlg,
												'getSkills' => $getSkills,
												'headinglbl'=>$headinglbl,
												'field1lbl' => $field1lbl,
												'selectfiled' => $selectfiled,
												'skilTblNn' => $skilTblNn,
												'getJapaneseLevel' => $getJapaneseLevel]);
	}

	public static function skillAddEditProcess(Request $request){
		if($request->editFlg == 1){
			$updateDetail = MailSend::updateSkillDetail($request);
			if($updateDetail) {
				Session::flash('success', 'Skill Updated Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('type', 'Updated Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		}else{
			$regDetail = MailSend::regSkillDetail($request);
			if($regDetail){
				Session::flash('success', 'Sill Registered Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			}else {
				Session::flash('type', 'Registered Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		}
		return Redirect::to('MailSend/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}

	public static function uploadVideoPopup(Request $request){
		return view('mailsend.videoUploadPopup',['request'=> $request]);
	}

	public static function uploadVideoProcess(Request $request){
		$empSkill = MailSend::getSkillDetail($request->empId);
		if(!empty($empSkill)){
			$updateDetail = MailSend::updateVideo($request);
			if($updateDetail) {
				Session::flash('success', 'Video Updated Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			} else {
				Session::flash('type', 'Video Updated Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		}else{
			$regDetail = MailSend::insertVideo($request);
			if($regDetail){
				Session::flash('success', 'Video Registered Sucessfully!'); 
				Session::flash('type', 'alert-success'); 
			}else {
				Session::flash('type', 'Video Registered Unsucessfully!'); 
				Session::flash('type', 'alert-danger'); 
			}
		}
		return Redirect::to('MailSend/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'));
	}
	public static function videoPlayPopup(Request $request){
		$url = str_replace("$","&lt;",$_REQUEST['embedlink']);
		return view('mailsend.videoPlayPopup',['request' => $request,
											'url'=>$url ]);
	}

	public static function getMailExistsCheck(Request $request)
	{
		$check = MailSend::fnExistsCheck($request);
		print_r($check);exit();
	}
	public static function updateOtherMailProcess(Request $request){
		$check = MailSend::fnupdateOtherMailDetail($request);
		print_r($check);exit();
	}

	public function customerCCSelectPopup(Request $request) {
		$custDtl = Employee::selectcustomer();
		return view('mailsend.customerCCSelPopup',['custDtl' => $custDtl,'request' => $request]);
	}
}