<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Model\Assets;
use App\Model\Common;
use Auth;
use Redirect;
use Session;
use Input;
use Config;
use View;
use Illuminate\Support\Facades\Validator;
class AssetsController extends Controller
{
	/**
	*
	* To view Assets ListView Page
	* @author Madasamy
	* @return object to particular view page
	* Created At 2020/09/18
	*
	*/
	public function listview(Request $request) {
		$historymnthtotal = array();
		if ($request->plimit == "") {
			$request->plimit = 50;
		}
		if (isset($request->userId) && $request->userId != "") {
			$request->userId = $request->userId;
		} else {
			$request->userId = Auth::user()->userId;
		}
		if(Session::get('userId') != "" && Session::get('selYear') != ""){
			$request->userId = Session::get('userId');
			$request->selYear = Session::get('selYear');
		}
		if (!isset($request->selYear) || $request->selYear == "") {
			$request->selYear = date('Y');
		} else {
			$request->selYear = $request->selYear;
		}

		$userPayAssetsDtls = Assets::fnGetAssetsPay($request);
		$total = array();
		$assetsdtls = array();
		$assetsMnth = array();
		$grantTotal =  array();
		$i = 0;
		foreach($userPayAssetsDtls as $key => $value) {
			$assetsdtls[$i]['id'] = $value->id;
			$assetsdtls[$i]['userId'] = $value->userId;
			$assetsdtls[$i]['houseId'] = $value->houseId;
			$assetsdtls[$i]['houseName'] = $value->houseName;
			$assetsdtls[$i]['belongsTo'] = $value->belongsTo;
			$assetsdtls[$i]['familyName'] = $value->familyName;
			$assetsdtls[$i]['date_month'] = $value->date_month;
			$assetsdtls[$i]['date_year'] = $value->date_year;
			$assetsdtls[$i]['assetsAmount'] = $value->assetsAmount;
			// Sub Assets Total 
			$assetsSubTotal = Assets::assetsSubTotal($request,$value->belongsTo,$value->date_year,$value->houseId);
			foreach($assetsSubTotal as $key => $subtot) {
				$assetsdtls[$i]['subSUM'] = $subtot->subSUM;
			}
			
			// Sub Assets Month Wise
			for($l = 1; $l <= 12; $l++) { 
				$date_month = $l;
				$assetsMnthTotal = Assets::assetsSubMnthTotal($request,$value->belongsTo,$value->houseId,$value->date_year,$date_month);
				if (count($assetsMnthTotal) == 0) {
					$assetsdtls[$i][$l]['assetsId'] = "";
					$assetsdtls[$i][$l]['monthSubVal'] = $date_month;
					$assetsdtls[$i][$l]['monthSubSUM'] = "";
				} else {
					foreach($assetsMnthTotal as $key => $monthSubtot) {
						if ($monthSubtot->date_month == $date_month) {
							$assetsdtls[$i][$l]['assetsId'] = $monthSubtot->id;
							$assetsdtls[$i][$l]['monthSubVal'] = $monthSubtot->date_month;
							$assetsdtls[$i][$l]['monthSubSUM'] = $monthSubtot->monthSubSUM;
						} else {
							$assetsdtls[$i][$l]['assetsId'] = "";
							$assetsdtls[$i][$l]['monthSubVal'] = $date_month;
							$assetsdtls[$i][$l]['monthSubSUM'] = "";
						}
					}
				}
			}
			$i++;
		} 
		// Total Year
		$grantTotal = Assets::getGrantTotal($request);
		// Sub Assets Month Wise
		for($j = 1; $j <= 12; $j++) { 
			$date_month = $j;
			$assetsMnthTotal = Assets::assetsMnthTotal($request,$date_month);
			if ($assetsMnthTotal[0]->date_month == $date_month) {
				$assetsMnth[$j]['monthVal'] = $assetsMnthTotal[0]->date_month;
				$assetsMnth[$j]['monthSUM'] = $assetsMnthTotal[0]->monthSUM;
			} else {
				$assetsMnth[$j]['monthVal'] = $date_month;
				$assetsMnth[$j]['monthSUM'] = 0;
			}
		}
		// YearMonth Bar Process
		$date = Assets::fnGetCalenderBar($request);
		$total_yrs = array();
		if ($date[0] != "") {
			$prev_yrs = $date[0];
			$total_yrs1 = array_unique($date[1]);
			asort($total_yrs1);
			foreach ($total_yrs1 AS $key => $value) {
				array_push($total_yrs, $value);
			}
		} else {
			$prYrMn = explode('-', date("Y-m", strtotime("-1 months", strtotime(date('Y-m-01')))));
			$prev_yrs = $prYrMn;
			array_push($total_yrs, $prYrMn[0]);
		} 
		$cur_year = date('Y');
		$curtime = date('YmdHis');
		if (isset($request->selYear) && !empty($request->selYear)) {
			$selectedYear = $request->selYear;
			$cur_year = $selectedYear;
		} else {
			$selectedYear = $cur_year;
		}
		return view('assets.listview', ['request' => $request,
										'userPayAssetsDtls' => $userPayAssetsDtls,
										'assetsdtls' => $assetsdtls,
										'grantTotal' => $grantTotal,
										'assetsMnth' => $assetsMnth,
										'prev_yrs' => $prev_yrs,
										'cur_year' => $cur_year,
										'total_yrs' => $total_yrs,
										'curtime' => $curtime
										]);
	}

	/**
	*
	* To view Assets AddEdit Page
	* @author Madasamy
	* @return object to particular view page
	* Created At 2020/09/18
	*
	*/
	public function addedit(Request $request) {
		
		if(!isset($request->userId)){
			return Redirect::to('Assets/listview?mainmenu=menu_assets&time='.date('YmdHis'));
		}

		$mainId = "";
		$houseNamearray = array();
		$subjectarray = array();
		$arrayNotEditOthers = array();
		$yeararray = array();
		$datearray = array();

		$familyMembers =  Common::fnGetFamilyMembers();
		$familyMembersarray = array();
		foreach ($familyMembers as $key => $family) {
			$familyMembersarray[$family->id] = $family->familyName;
		}
		$houseName =  Assets::fnGetHouseName($request->userId);
		foreach ($houseName as $key => $housevalue) {
			$houseNamearray[$housevalue->houseId] = $housevalue->houseName;
		}
		$cur_year = date('Y');
		$cur_date = date('d');
		$fut_year = date('Y') + 3 ;
		for($year = $cur_year; $year < $fut_year ; $year++) {
			$yeararray[$year] = $year;
		}
		for ($date = 1; $date < 26 ; $date++) { 
			$datearray[$date] = $date;
		}
		if ($request->editChk != "") {
			$detedit = Assets::fnEditAssetsDetails($request);
			if (!empty($detedit[0])) {
				$detedit['id'] = $detedit[0]->id;
				$detedit['houseId'] = $detedit[0]->houseId;
				$detedit['belongsTo'] = $detedit[0]->belongsTo;
				$detedit['Date'] = $detedit[0]->Date;
				$detedit['Month'] = $detedit[0]->Month;
				$detedit['Year'] = $detedit[0]->Year;
				$detedit['assetsAmount'] = number_format($detedit[0]->assetsAmount); 
				$detedit['remarks'] = $detedit[0]->remarks;
				// Month Select and Disable Check
				$request->userId = $detedit[0]->userId;
				$request->houseId = $detedit[0]->houseId;
				$request->belongsTo = $detedit[0]->belongsTo;
				// $request->subjectothers = $detedit[0]->others;
				$request->yearSelect = $detedit[0]->Year;
				$fetchEditData = array();
				$fetchEditData = Assets::fncheckmonth($request);
				$arrayUnique = array_diff($fetchEditData, explode(",", $detedit[0]->Month));
				$o = 0;
				foreach ($arrayUnique as $key => $value) {
					$arrayNotEditOthers[$value] = $value;
					$o++;
				}
			}
		}
		return view('assets.addedit', ['request' => $request,
										'detedit' => (isset($detedit)) ? $detedit : "",
										'houseNamearray' => $houseNamearray,
										'arrayNotEditOthers' => $arrayNotEditOthers,
										'familyMembersarray' => $familyMembersarray,
										'yeararray' => $yeararray,
										'datearray' => $datearray]);
	}

	/**
	*
	* To view Assets AddEdit Process
	* @author Madasamy
	* @return object to particular view page
	* Created At 2020/09/18
	*
	*/
	public function addeditprocess(Request $request) {
		if (!isset($request->userId)) {
			return Redirect::to('Assets/listview?mainmenu=menu_assets&time='.date('YmdHis'));
		}

		$AssetsCode = "";
		$month = "";
		if (count($request->month) != 0) {
			foreach ($request->month as $key => $value) {
				$getAssetsData = Assets::getAssetsData($request,$value);
				if (isset($getAssetsData[0])) {
					$update = Assets::updateAssets($request,$value);
					if($update) {
						Session::flash('message', 'Updated Sucessfully!');
						Session::flash('type', 'alert-success'); 
					} else {
						Session::flash('danger', 'Updated Unsucessfully!'); 
						Session::flash('type', 'alert-danger'); 
					}
				} else {
					$insert = Assets::insertAssets($request,$value);
					if($insert) {
						Session::flash('message', 'Inserted Sucessfully!'); 
						Session::flash('type', 'alert-success'); 
					} else {
						Session::flash('danger', 'Inserted Unsucessfully!'); 
						Session::flash('type', 'alert-danger'); 
					}
				}
				
			}
		}
		Session::flash('selYear',$request->yearSelect);
		Session::flash('userId', $request->userId); 
		return Redirect::to('Assets/listview?mainmenu=menu_assets&time='.date('YmdHis'));
	}

	/**
	*
	* To view Assets Check Month Process in AddEdit Page 
	* @author Madasamy
	* @return object to particular view page
	* Created At 2020/09/18
	*
	*/
	public function checkmonth(Request $request) {
		$checkmonth = Assets::fncheckmonth($request);
		$subval = json_encode($checkmonth);
		echo $subval;
	}

}