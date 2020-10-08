var data = {};
$(function () {
	var cc = 0;
	$('#cussort').click(function () {
		cc++;
		if (cc == 2) {
			$(this).change();
			cc = 0;
		}         
	}).change (function () {
		sortingfun();
		cc = -1;
	}); 
	// MOVE SORTING
});

// Sorting Event
function sortingfun() {
	pageload();
	$('#plimit').val(50);
	$('#page').val('');
	var sortselect=$('#cussort').val();
	$('#sortOptn').val(sortselect);
	var alreadySelectedOptn=$('#sortOptn').val();
	var alreadySelectedOptnOrder=$('#sortOrder').val();
	if (sortselect == alreadySelectedOptn) {
		if (alreadySelectedOptnOrder == "asc") {
			$('#sortOrder').val('desc');
		} else {
			$('#sortOrder').val('asc');
		}
	}
	$("#Oldcustomerindexform").submit();
}

// Single Search Event
function fnSingleSearch() {
	var singlesearchtxt = $("#singlesearchtxt").val();
	var singlesearchtxt = document.getElementById('singlesearchtxt').value;
	if (singlesearchtxt == "") {
		alert("Please Enter The customer Search.");
		$("#singlesearchtxt").focus(); 
		return false;
	} else {
		$('#plimit').val('');
		$('#page').val('');
		if ($('#singlesearchtxt').val()) {
			$('#searchmethod').val(1);
		} else {
			$('#searchmethod').val('');
		}
		$('#startdate').val('');
		$('#enddate').val('');
		$('#name').val('');
		$('#address').val('');
		$('#Oldcustomerindexform').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
		$("#Oldcustomerindexform").submit();
	}
}

// Clear Search Event
function clearsearch() {
	$('#plimit').val(50);
	$('#page').val('');
	$("#filter").val('');
	$('#singlesearchtxt').val('');
	$('#sorting').val('');
	$('#cussort').val('');
	$('#startdate').val('');
	$('#enddate').val('');
	$('#name').val('');
	$('#address').val('');
	$("#Oldcustomerindexform").submit();
}

// Enter Key event
function checkSubmitmulti(e) {
	if(e && e.keyCode == 13) {
		umultiplesearch();
	}
}

// Multiple Search Process
function umultiplesearch() {
	var mainmenu='Customer';
	var name = $("#name").val();
	var name = document.getElementById('name').value;
	var address = $("#address").val();
	var address = document.getElementById('address').value;
	var startdate = $("#startdate").val();
	var startdate = document.getElementById('startdate').value;
	var enddate = $("#enddate").val();
	var enddate = document.getElementById('enddate').value;
	if (name == "" && address == "" && startdate == "" && enddate == "") {
		alert("Customer search is missing.");
		$("#name").focus(); 
		return false;
	} else if (Date.parse(startdate) > Date.parse(enddate)) {
		alert("Please enter date greater than startdate");
		 document.getElementById('enddate').focus();
		return false;
	} else {
	pageload();

		$('#plimit').val(50);
		$('#page').val('');
		//$('#sortOptn').val('');
		$("#filterval").val('');
		//$('#sortOrder').val('DESC');
		// $('#sortOrder').val('asc'); 
		$('#singlesearchtxt').val('');
		$('#searchmethod').val(2);
		$('#Oldcustomerindexform').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
		$("#Oldcustomerindexform").submit();
	}
}

// Filter Event
function filter(val) {
	$('#plimit').val(50);
	$('#page').val('');
	$("#filter").val('');
	$('#singlesearchtxt').val('');
	$('#sorting').val('');
	$('#startdate').val('');
	$('#enddate').val('');
	$('#name').val('');
	$('#filterval').val(val);
	$('#cussort').val('');
	$('#UseNotUseVal').val('');
	$("#Oldcustomerindexform").submit();
}

// customer view
function custview(id,custid) {
	$('#id').val(id);
	$('#custid').val(custid);
	
	$('#Oldcustomerindexform').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
	$("#Oldcustomerindexform").submit();
}

// Functiopn back Event
function goempindexpage (){
	pageload();
	$('#customerviewform').attr('action', '../OldCustomer/index?mainmenu='+mainmenu+'&time='+datetime);
	$("#customerviewform").submit();
}

// Functiopn back Event
function goindexpage(mainmenu,datetime) {
    pageload();
    $('#customerviewform').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
    $("#customerviewform").submit();
}

function copyCustomer(){
    var mainmenu="OldCustomer";
    $('#customerviewform').attr('action', 'copyCustomer?mainmenu='+mainmenu);
    $("#customerviewform").submit();
}