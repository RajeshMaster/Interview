/*
フリタ処理
*/
function selectActive(val,title) {
	$('#plimit').val(50);
    $('#page').val('');
	$('#resignid').val(val);
	$('#title').val(title);
	$("#employeefrm").submit();
}


// Content Sorting
$(function () {
	var cc = 0;
	$('#staffsort').click(function () {
		cc++;
		if (cc == 2) {
			$(this).change();
			cc = 0;
		}
	}).change (function () {
		sortingfun();
		cc = -1;
	}); 
});

function sortingfun() {
	pageload();
	$('#plimit').val(50);
	$('#page').val('');
	var sortselect = $('#staffsort').val();
	$('#sortOptn').val(sortselect);
	$('#singlesearch').val('');
	var alreadySelectedOptn = $('#sortOptn').val();
	var alreadySelectedOptnOrder = $('#sortOrder').val();
	if (sortselect == alreadySelectedOptn) {
		if (alreadySelectedOptnOrder == "asc") {
			$('#sortOrder').val('desc');
		} else {
			$('#sortOrder').val('asc');
		}
	}
	$("#employeefrm").submit();
}

// Clear search process in employee index page
function clearsearch() {
	$('#plimit').val(50);
	$('#page').val('');
	$("#filterval").val('');
	$('#sortOptn').val('');
	$('#sortOrder').val('asc'); 
	$('#singlesearch').val('');
	$("#employeefrm").submit();
}

// Search process in EmployeeIndex page
function fnSingleSearch() {
	var singlesearchtxt = $("#singlesearch").val();
	var singlesearchtxt = document.getElementById('singlesearch').value;
	if (singlesearchtxt == "") {
		alert("Please Enter The User Search.");
		$("#singlesearch").focus(); 
		return false;
	} else {
		$('#plimit').val('');
		$('#page').val('');
		$('#searchmethod').val(1);
		$('#employeefrm').attr('action', '../Employee/index?mainmenu='+mainmenu+'&time='+datetime);
		$("#employeefrm").submit();
	}
}

// Multi Search process in EmployeeIndex page
function fnMultiSearch() {
	var employeeno = $("#employeeno").val();
	var employeename = $("#employeename").val();
	if (employeeno == "" && employeename == "") {
		alert("Please Enter The Employee Search.");
		$("#employeeno").focus(); 
		return false;
	} else {
       	$("#searchmethod").val(2);
		$('#plimit').val('');
		$('#page').val('');
		$('#employeefrm').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
		$("#employeefrm").submit();
	}
}

function employeeview(){
	alert("Under Construction");
}

function cushistory(){
	alert("Under Construction");
}

function workend(){
	alert("Under Construction");
}

function gotoResume(){
	alert("Under Construction");
}