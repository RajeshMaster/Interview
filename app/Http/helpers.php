<?php
namespace App\Http;
use stdClass;
use Session;
use DB;
use Config;
use Input;
use File;
use DateTime;
class Helpers {
    
    /**  
	*  YearMonth Bar
	*  @author Madasamy 
	*  @param $prev_yrs,$cur_year,$cur_month,$total_yrs,$curtime
	*  Created At 2020/08/28
	**/
	public static function displayYear_Month($prev_yrs,$cur_year,$cur_month,$total_yrs,$curtime){
		//SYSTEM CURRENT YEAR
		$months[] = "";
		$sys_cur_month=date('m');
		$sys_cur_year=date('Y');
		$count_yrs=count($total_yrs);
		//YEAR ROW
		echo "<div class=\"yrBorder\" align=\"center\" style=\"margin-top:-18px;\"><div style=\"background-color: white;margin-top:0px;\">&nbsp;&nbsp;";
		if($count_yrs==0) {
			echo "<b>1&nbsp;年間</b>&nbsp;&nbsp;";
		} else {
			echo "<b>".$count_yrs."&nbsp;年間</b>&nbsp;&nbsp;";
		}
		if($count_yrs==0){
			echo "＜＜&nbsp;<span class=\"currentheader\">&nbsp;".$sys_cur_year."年&nbsp;</span>&nbsp;＞＞";
		} else if($count_yrs==1){
			echo "＜＜&nbsp;<span class=\"currentheader\">&nbsp;".$total_yrs[0]."年&nbsp;</span>&nbsp;＞＞";
		} else if($count_yrs<=2){
		$cnt=$count_yrs-1;
		echo "<span>＜＜</span>";
		for($year=0;$year<$count_yrs;$year++){
			if($cur_year==$total_yrs[$year]){
				echo "<span class=\"currentheader\">&nbsp;".$cur_year."年&nbsp;</span>&nbsp;";
			} else {
				$yr=$total_yrs[$year];
				echo "<span class=\"spnOver\"><a href=\"javascript:getDataMonth('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">&nbsp;".$yr."年&nbsp;</a></span>&nbsp;";
			}
		}
		echo "<span>＞＞</span>";
		} else if($count_yrs>2){
			//FIND THE INDEX OF THE SELECTED YEAR
			$inx=0;
			$cnt=$count_yrs;
			for($year=0;$year<$count_yrs;$year++){
				if($cur_year==$total_yrs[$year]){
					$inx=$year;
				}
			}
			if($inx==0){  //FIRST YEAR
				echo "<span>＜＜</span>";
				echo "<span class=\"currentheader \">&nbsp;".$total_yrs[$inx]."年&nbsp;</span>&nbsp;";
				$yr=$total_yrs[$inx+1];
				echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getDataMonth('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">".$yr."年</a></span>";
				$yr=$total_yrs[$inx+2];
				echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getDataMonth('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">＞＞</a></span>";
			}else if($inx==$cnt-1){       //LAST YEAR
				$yr=$total_yrs[$inx-2];
				echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getDataMonth('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">＜＜</a></span>";
				$yr=$total_yrs[$inx-1];
				echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getDataMonth('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">".$yr."年</a></span>&nbsp;";
				echo "<span class=\"currentheader\">&nbsp;".$total_yrs[$inx]."年&nbsp;</span>";
				echo "<span>＞＞</span>";
			}else{    //OTHERWISE
				// else if for no previous year identification(updated on 2019-12-26).
				if($inx-2 >= 0) {
					$yr=$total_yrs[$inx-2]; 
				} else if($inx-1 == 0) {
					$yr = ""; 
				} else  {
					$yr=$total_yrs[$inx]; 
				}
				if($yr==''){
					echo "<span>＜＜</span>";
				}else{
					echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getDataMonth('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">＜＜</a></span>";
				}
				$yr=$total_yrs[$inx-1];
				echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getDataMonth('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">".$yr."年</a></span>&nbsp;";
				echo "<span class=\"currentheader\">&nbsp;".$total_yrs[$inx]."年&nbsp;</span>";
				$yr=$total_yrs[$inx+1];
				// $yr=$total_yrs[$inx+2];
				if($yr==''){
					echo "<span>＞＞</span>";
				}else{
					echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getDataMonth('$cur_month','$yr','$curtime');\" class=\"bordera pageload\">＞＞</a></span>";
				}
			}
		}
		echo "&nbsp;&nbsp;";
		//FIND THE MONTHS WHICH HAS DATA FOR SELECTED YEAR
		for($i=0;$i<count($prev_yrs);$i++){
			if($cur_year==$prev_yrs[$i][0]){
				$months=$prev_yrs[$i];
			}
		}
		//MONTH ROW
		for($month=1;$month<=12;$month++){
			if($month==$cur_month){
				echo "&nbsp;<span class=\"currentheader\">&nbsp;".$month."月&nbsp;</span>&nbsp;";
			} else if(count($months)<1 || array_search($month, $months)==NULL){
				echo "&nbsp;&nbsp;".$month."月&nbsp;";
			} else if(($month<$cur_month)&&($month<=$sys_cur_month)){
				$mon=str_pad($month,2,"0",STR_PAD_LEFT);
				echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getDataMonth('$mon','$cur_year','$curtime');\" class=\"bordera pageload\">&nbsp;".$month."月&nbsp;</a></span>";
			} else if($month<=$sys_cur_month){
				$mon=str_pad($month,2,"0",STR_PAD_LEFT);
				echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getDataMonth('$mon','$cur_year','$curtime');\" class=\"bordera pageload\">&nbsp;".$month."月&nbsp;</a></span>";
			} else if($cur_year<$sys_cur_year){
				$mon=str_pad($month,2,"0",STR_PAD_LEFT);
				echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getDataMonth('$mon','$cur_year','$curtime');\" class=\"bordera pageload\">&nbsp;".$month."月&nbsp;</a></span>";
			} else if($month > $sys_cur_month){
				$mon=str_pad($month,2,"0",STR_PAD_LEFT);
				echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getDataMonth('$mon','$cur_year','$curtime');\" class=\"bordera pageload\">&nbsp;".$month."月&nbsp;</a></span>";
			} else{
				echo $month."月&nbsp;";
			}
		}
		echo "</div></div>";
	}

	public static function displayYear($prev_yrs,$cur_year,$total_yrs,$curtime){
		// print_r("expression");exit();
		//SYSTEM CURRENT YEAR
		$months[] = "";
		$sys_cur_month = date('m');
		$sys_cur_year = date('Y');
		$count_yrs = count($total_yrs);
		//YEAR ROW
		echo "<div class=\"yrBorder\" align=\"center\" style=\"margin-top:-18px;\"><div style=\"background-color: white;margin-top:0px;\">&nbsp;&nbsp;";
		if($count_yrs == 0) {
			echo "<b>1&nbsp;年間</b>&nbsp;&nbsp;";
		} else {
			echo "<b>".$count_yrs."&nbsp;年間</b>&nbsp;&nbsp;";
		}
		if($count_yrs == 0){
			echo "＜＜&nbsp;<span class=\"currentheader\">&nbsp;".$sys_cur_year."年&nbsp;</span>&nbsp;＞＞";
		} else if($count_yrs == 1){
			echo "＜＜&nbsp;<span class=\"currentheader\">&nbsp;".$total_yrs[0]."年&nbsp;</span>&nbsp;＞＞";
		} else if($count_yrs <= 2){
			$cnt = $count_yrs-1;
			echo "<span>＜＜</span>";
			for($year = 0; $year < $count_yrs; $year++){
				if($cur_year==$total_yrs[$year]){
					echo "<span class=\"currentheader\">&nbsp;".$cur_year."年&nbsp;</span>&nbsp;";
				} else {
					$yr=$total_yrs[$year];
					echo "<span class=\"spnOver\"><a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">&nbsp;".$yr."年&nbsp;</a></span>&nbsp;";
				}
			}
			echo "<span>＞＞</span>";
		} else if($count_yrs > 2){
			//FIND THE INDEX OF THE SELECTED YEAR
			$inx = 0;
			$cnt = $count_yrs;
			for($year = 0;$year < $count_yrs;$year++){
				if($cur_year == $total_yrs[$year]){
					$inx = $year;
				}
			}
			if($inx == 0) {						//FIRST YEAR
				echo "<span>＜＜</span>";
				echo "<span class=\"currentheader \">&nbsp;".$total_yrs[$inx]."年&nbsp;</span>&nbsp;";
				$yr=$total_yrs[$inx+1];
				echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">".$yr."年</a></span>";
				/*echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera\">".$yr."年</a></span>";
				$yr=$total_yrs[$inx+3];*/
				echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">＞＞</a></span>";
			} else if($inx == $cnt-1) { 				//LAST YEAR
				$yr=$total_yrs[$inx-1];
				echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">＜＜</a></span>";
				/*$yr=$total_yrs[$inx-2];
				echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera\">".$yr."年</a></span>";*/
				$yr = $total_yrs[$inx-1];
				echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">".$yr."年</a></span>&nbsp;";
				echo "<span class=\"currentheader\">&nbsp;".$total_yrs[$inx]."年&nbsp;</span>";
				echo "<span>＞＞</span>";
			} else {                				//OTHERWISE
				if($inx-2 > 0) {
					$yr = $total_yrs[$inx-1]; 
				} else {
					$yr = $total_yrs[$inx-1]; 
				}
				if($yr == ''){
					echo "<span>＜＜</span>";
				} else {
					echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">＜＜</a></span>";
				}
				$yr = $total_yrs[$inx-1];
				echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">".$yr."年</a></span>&nbsp;";
				echo "<span class=\"currentheader\">&nbsp;".$total_yrs[$inx]."年&nbsp;</span>";
				$yr = $total_yrs[$inx+1];
				/*echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera\">".$yr."年</a></span>";
				$yr=$total_yrs[$inx+2];*/
				if($yr == '') {
					echo "<span>＞＞</span>";
				} else {
					echo "<span class=\"spnOver\">&nbsp;<a href=\"javascript:getData('$yr','$curtime');\" class=\"bordera pageload\">＞＞</a></span>";
				}
			}
		}
		echo "&nbsp;&nbsp;";
		echo "</div></div>";
	}

    public static function checkTELFAX($str) {
		$rval = "";
		if (!empty($str)) {
			if (strlen($str) == 10) {
				$rval = substr($str, 0, 2) . '-' . substr($str, 2, 4) . '-' . substr($str, 6);
				return $rval;
			} else if (strlen($str) == 11) {
				$rval = substr($str, 0, 3) . '-' . substr($str, 3, 4) . '-' . substr($str, 7);
				return $rval;
			} else {
				return $str;
			}
		} else {
			return $str;
		}
	}
}