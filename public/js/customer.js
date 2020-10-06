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
});
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
	$('#address').val('');
	$("#customerindexform").submit();
}
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
	$("#customerindexform").submit();
}
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
	$("#customerindexform").submit();
}
function fnSingleSearch() {
	var mainmenu='Customer';
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
		$('#customerindexform').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
		$("#customerindexform").submit();
	}
}

function checkSubmitmulti(e) {
	if(e && e.keyCode == 13) {
		umultiplesearch();
	}
}

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
	$('#plimit').val(50);
	$('#page').val('');
	//$('#sortOptn').val('');
	$("#filterval").val('');
	//$('#sortOrder').val('DESC');
   // $('#sortOrder').val('asc'); 
	$('#singlesearchtxt').val('');
	$('#searchmethod').val(2);
	$('#customerindexform').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
	$("#customerindexform").submit();
}
}
function custview(datetime,id,custid) {
	$('#id').val(id);
	$('#custid').val(custid);
	var mainmenu=$('#customerindexform #mainmenu').val();
	$('#customerindexform').attr('action', 'customerView?mainmenu='+mainmenu+'&time='+datetime);
	$("#customerindexform").submit();
}
function selectGroup(custId) {
	var mainmenu = "menu_customer";
	popupopenclose(1);
	$('#selectGroup').load('selectGroup?mainmenu='+mainmenu+'&time='+datetime+'&custId='+custId);
	$("#selectGroup").modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#selectGroup').modal('show');
}
function divGroupSelPopClose() {
	var confirmmsg = 'Do You Want To Cancel?';
	if (confirm(confirmmsg)) {
		$("body div").removeClass("modalOverlay");
		$('#selectGroup').empty();
		$('#selectGroup').modal('toggle');
	} else {
		return false;
	}
}
function custview(datetime,id,custid) {
	$('#id').val(id);
	$('#custid').val(custid);
	var mainmenu=$('#customerindexform #mainmenu').val();
	$('#customerindexform').attr('action', 'CustomerView?mainmenu='+mainmenu+'&time='+datetime);
	$("#customerindexform").submit();
}
function fngotoregister(datetime) {
	pageload();
	var mainmenu=$('#customerindexform #mainmenu').val();
	$('#customerindexform').attr('action', 'CustomerAddedit?mainmenu='+mainmenu+'&time='+datetime);
	$("#customerindexform").submit();
}