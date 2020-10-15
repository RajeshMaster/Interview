
var data = {};
$(document).ready(function() {
	$('.empRegister').on('click', function() {
		resetErrors();
		var url ='AddEditregvalidation';
		$.each($('form input, form select, form textarea'), function(i, v) {  
			if (v.type !== "submit") {
				data[v.name] = v.value;
			}
		}); 
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: url,
			data: data,
			async: false, //blocks window close
			success: function(resp) {
				if(resp == true){
					swal({
						title: msg_update,
						type: "warning",
						showCancelButton: true,
						confirmButtonClass: "btn-danger",
						closeOnConfirm: true,
						closeOnCancel: true
					},
					function(isConfirm) {
						if (isConfirm) {
						   pageload();
							$('#employee_reg').attr('action', 'employeeEditProcess'+'?menuid=menu_mail&time='+datetime);
							$("#employee_reg").submit();
						} 
					});
				} else {
				  $.each(resp, function(i, v) {
						// alert(i + " => " + v); // view in console for error messages
						var msg = '<label class="error pl5 mt5 tal" style="color:#9C0000;" for="'+i+'">'+v+'</label>';
						// If for different Messages
						// Else for Directy Message by Name
						if ($('input[name="' + i + '"]').hasClass('opd')) {
							$('input[name="' + i + '"]').addClass('inputTxtError');
							$('.doj_err').append(msg)
						} else if ($('input[name="' + i + '"]').hasClass('Surname')) {
							$('input[name="' + i + '"]').addClass('inputTxtError');
							$('.Surname_err').append(msg)
						} else {
							$('input[name="' + i + '"], select[name="' + i + '"],textarea[name="' + i + '"]').addClass('inputTxtError').after(msg);
						}
					});
				}
			},
			error: function(data) {
				// alert(data.status);
				// alert('there was a problem checking the fields');
			}
		});
	});

	$('.wrkEndRegister').on('click', function() {
		resetErrors();
		var url ='wrkEndValidation';
		$.each($('form input, form select, form textarea'), function(i, v) {  
			if (v.type !== "submit") {
				data[v.name] = v.value;
			}
		}); 
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: url,
			data: data,
			async: false, //blocks window close
			success: function(resp) {
				if(resp == true){
					swal({
						title: msg_add,
						type: "warning",
						showCancelButton: true,
						confirmButtonClass: "btn-danger",
						closeOnConfirm: true,
						closeOnCancel: true
					},
					function(isConfirm) {
						if (isConfirm) {
						   pageload();
							$('#workEndReg').attr('action', 'wrkEndProcess'+'?menuid=menu_employee&time='+datetime);
							$("#workEndReg").submit();
						} 
					});
				} else {
				  $.each(resp, function(i, v) {
						// alert(i + " => " + v); // view in console for error messages
						var msg = '<label class="error pl5 mt5 tal" style="color:#9C0000;" for="'+i+'">'+v+'</label>';
						$('input[name="' + i + '"], select[name="' + i + '"],textarea[name="' + i + '"]').addClass('inputTxtError').after(msg);
					});
				}
			},
			error: function(data) {
				alert(data.status);
				// alert('there was a problem checking the fields');
			}
		});
	});


	$('.wrkEndEdit').on('click', function() {
		resetErrors();
		$(".dategreatErr").css("display", "none");
		var url ='wrkEndEditValidation';
		$.each($('form input, form select, form textarea'), function(i, v) {  
			if (v.type !== "submit") {
				data[v.name] = v.value;
			}
		}); 
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: url,
			data: data,
			async: false, //blocks window close
			success: function(resp) {
				if(resp == true){
					var startDate = new Date($('#startDate').val());
					var endDate = new Date($('#endDate').val());
					if(startDate >= endDate) {
						$(".dategreatErr").css("display", "inline-block");
						return true;
					}
					swal({
						title: msg_update,
						type: "warning",
						showCancelButton: true,
						confirmButtonClass: "btn-danger",
						closeOnConfirm: true,
						closeOnCancel: true
					},
					function(isConfirm) {
						if (isConfirm) {
						   pageload();
							$('#workEndReg').attr('action', 'wrkEndeditProcess'+'?menuid=menu_employee&time='+datetime);
							$("#workEndReg").submit();
						} 
					});
				} else {
				  $.each(resp, function(i, v) {
						// alert(i + " => " + v); // view in console for error messages
						var msg = '<label class="error pl5 mt5 tal" style="color:#9C0000;" for="'+i+'">'+v+'</label>';
						$('input[name="' + i + '"], select[name="' + i + '"],textarea[name="' + i + '"]').addClass('inputTxtError').after(msg);
					});
				}
			},
			error: function(data) {
				// alert(data.status);
				// alert('there was a problem checking the fields');
			}
		});
	});

});

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

// Employee Single View
function employeeview(id){
	$('#empid').val(id);
	// $('#title').val('2');
	$('#employeefrm').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
	$("#employeefrm").submit();
}

// View Customer History
function cushistory(empid,lastname){
	pageload();
	$('#empid').val(empid);
	$('#hdnempid').val(empid);
	$('#hdnempname').val(lastname);
	$('#employeefrm').attr('action', '../Employee/Onsitehistory?mainmenu='+mainmenu+'&time='+datetime);
	$("#employeefrm").submit();
}

// To register the work end date
function workend(empid,lastname){
	$('#empid').val(empid);
	$('#empname').val(lastname);
	$('#employeefrm').attr('action', 'workend?mainmenu='+mainmenu+'&time='+datetime);
	$("#employeefrm").submit();
}

// Resume Upload Screen View
function uploadResume(empid,lastname){

	$('#empid').val(empid);
	$('#empname').val(lastname);
	popupopenclose(1);
	$('#uploadRes').load('uploadResume?mainmenu='+mainmenu+'&time='+datetime+'&empId='+empid+'&lastname='+lastname);
	$("#uploadRes").modal({
			backdrop: 'static',
			keyboard: false
		});
	$('#uploadRes').modal('show');
}

function fnUpload(){
	var pdf = $('#pdffile').val()
	if (pdf != "") {
		pdf = pdf.split(".");
		if (pdf[pdf.length -1] != "pdf") {
			alert(msg_fileformat);
		} else {
			swal({
				title: msg_upload,
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				closeOnConfirm: true,
				closeOnCancel: true
			},
			function(isConfirm) {
				if (isConfirm) {
				   pageload();
					$("#uploadpopup").submit();
				}
			});
		}
	} else {
		alert(msg_fileEmpty);
	}
}
// Bakc to Employee Index
function fnredirectemployee(){
	$('#employeeView').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
	$("#employeeView").submit();
}

// Edit Screen Show
function employeEdit(type,id){
	pageload();
	$('#editflg').val(type);
	$('#empid').val(id);
	$('#editid').val(id);
	$('#employeeView').attr('action', 'empAddEdit?mainmenu='+mainmenu+'&time='+datetime);
	$("#employeeView").submit();
}

// Bakc to Employee View
function fnbackEmpView(){
	pageload();
	$('#senmailfrm').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
	$("#senmailfrm").submit();
}

// Bakc to Employee View
function fnbackEmpindex(){
	pageload();
	$('#workEndReg').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
	$("#workEndReg").submit();
}

// Bakc to Employee Index
function fnredirectindex(){
	pageload();
	$('#resHistfrm').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
	$("#resHistfrm").submit();
}

// Bakc to Employee Index
function fnindex(){
	pageload();
	$('#onsitefrm').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
	$("#onsitefrm").submit();
}

// To reset Error
function resetErrors() {
	$('form input, form select, form radio, form textarea').css("border-color", "");
	$('form input').removeClass('inputTxtError');
	$('label.error').remove();
}

// Resume History
function resumeHistory(id) {
	pageload();
	$('#empid').val(id);
	$('#employeefrm').attr('action', 'resumeHistory?mainmenu='+mainmenu+'&time='+datetime);
	$("#employeefrm").submit();
}

// Resume History
function downloadResume(resumename,page) {
	swal({
		title: msg_download,
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		closeOnConfirm: true,
		closeOnCancel: true
	},
	function(isConfirm) {
		if(isConfirm) {
			if (page == "History") {
				$('#formpdfdwnld #filenamePdf').val(resumename);
				$('#formpdfdwnld').attr('action', 'downloadprocess?mainmenu='+mainmenu+'&time='+datetime);
				$("#formpdfdwnld").submit();
			} else {
				$('#frmpdfdwnld #filenamePdf').val(resumename);
				$('#frmpdfdwnld').attr('action', 'downloadprocess?mainmenu='+mainmenu+'&time='+datetime);
				$("#frmpdfdwnld").submit();
			}
		}
	});
}

// For to get branch Details And incharge
function fnGetbranchDetail() {
	$('#branchId').find('option').not(':first').remove();
	$('#inchargeDetails').find('option').not(':first').remove();
	var getcustId = $('#customerId').val();
	if ($('#customerId').val() != "") {
		$("#customerdiv").hide();
	} else {
		$("#customerdiv").show();
	}
	$.ajax({
		type: 'GET',
		dataType: "JSON",
		url: 'branch_ajax',
		data: {"getcustId": getcustId},
		success: function(resp) {
			for (i = 0; i < resp.length; i++) {
				$('#branchId').append( '<option value="'+resp[i]["branch_id"]+'">'+resp[i]["branch_name"]+'</option>' );
			}
			var branchCount = $('#branchId > option').length;
			if (branchCount <= 2) {
				$('#branchId').val(resp[0]["branch_id"]);
				$('#inchargeDetails').find('option').not(':first').remove();
				var getcusId = $('#customerId').val();
				var getbranchId = $('#branchId').val();
				$.ajax({
					type: 'GET',
					dataType: "JSON",
					url: 'incharge_ajax',
					data: {"getcusId": getcusId,"getbranchId": getbranchId},
					success: function(resp) {
						for (i = 0; i < resp.length; i++) {
							$('#inchargeDetails').append( '<option value="'+resp[i]["id"]+'">'+resp[i]["incharge_name"]+'</option>' );
						}
						var incCount = $('#inchargeDetails > option').length;
						if (incCount == 2) {
							$('#inchargeDetails').val(resp[0]["id"]);
						} 
					},
					error: function(data) {
						// alert(data.status);
					}
				});
			}
		},
		error: function(data) {
			// alert(data.status);
		}
	});
}

// Get incharge details
function fnGetinchargeDetails() {
	$('#inchargeDetails').find('option').not(':first').remove();
	$('#inchargeDetails').val("");
	var getcusId = $('#customerId').val();
	var getbranchId = $('#branchId').val();
	$.ajax({
		type: 'GET',
		dataType: "JSON",
		url: 'incharge_ajax',
		data: {"getcusId": getcusId,"getbranchId": getbranchId},
		success: function(resp) {
			for (i = 0; i < resp.length; i++) {
				$('#inchargeDetails').append( '<option value="'+resp[i]["id"]+'">'+resp[i]["incharge_name"]+'</option>' );
				// $('select[name="inchargeDetails"]').val(value);
			}
			var incCount = $('#inchargeDetails > option').length;
			if (incCount == 2) {
				$('#inchargeDetails').val(resp[0]["id"]);
			} 
		},
		error: function(data) {
			// alert(data.status);
		}
	});
}

// Show Popup for customer select
function customerSelectPopup() {
	var customerId = $('#customerId').val();
	popupopenclose(1);
	$('#customerSelect').load('customerSelpopup?mainmenu='+mainmenu+'&time='+datetime+'&customerId='+customerId);
	$("#customerSelect").modal({
			backdrop: 'static',
			keyboard: false
		});
	$('#customerSelect').modal('show');
}
// Double Click on popup Select tr
function fndbclick(cusid,cusname,name) {
	document.getElementById("inchargeDetails").value = "";
	$("#"+cusid).prop("checked", true);
	if($.trim(name) == "" || $.trim(name) == null) {
		name = cusname;
	}
	$('#customerId').val(cusid);
	$('#customerName').val(cusname);
	fnGetbranchDetail();
	$('#customerSelect').modal('toggle');
}

// Single Click in tr
function fnSclkTr(cusid,empname,name) {
	$("#"+cusid).prop("checked", true);
	if($.trim(name) == "" || $.trim(name) == null) {
		name = empname;
	}
	$('#hcusId').val(cusid);
	$('#hName').val(name);
}

// Select button on Customer Select popup
function fnselect() {
	if ($('input[name="cusId"]:checked').length == 0) {
		alert("Please select atleast one Customer");
		return false;
	} else {
		document.getElementById("inchargeDetails").value = "";
		var cusId = $('#hcusId').val();
		$('#customerId').val(cusId);
		$('#customerName').val($('#hName').val());
		fnGetbranchDetail();
		$('#customerSelect').modal('toggle');
		
	}
}
 function customerview(datetime,id,custid) {
	$('#id').val(id);
	$('#custid').val(custid);
	$('#empid').val(1);
	var mainmenu = "menu_customer";
	$('#emphistoryform').attr('action', '../Customer/CustomerView?mainmenu='+mainmenu+'&time='+datetime);
	$("#emphistoryform").submit();
}
function getdetails(empid,empname,datetime,id){
	$('#hdnempid').val(empid);
	$('#hdnempname').val(empname);
	$('#hdnback').val(id);
	var mainmenu="menu_customer";
	$('#emphistoryform').attr('action', '../Customer/Onsitehistory?mainmenu='+mainmenu+'&time='+datetime);
	$("#emphistoryform").submit();
}

// 
function candiateInt() {
	var mainmenu = "menu_customer";
	$('#emphistoryform').attr('action', '../Customer/CustomerView?mainmenu='+mainmenu+'&time='+datetime);
	$("#emphistoryform").submit();
}