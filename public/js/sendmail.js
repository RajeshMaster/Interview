
var data = {};
$(document).ready(function() {
	$('.sendmailRegister').on('click', function() {
		resetErrors();
		var url ='sendMialvalidation';
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
						title: msg_smail,
						type: "warning",
						showCancelButton: true,
						confirmButtonClass: "btn-danger",
						closeOnConfirm: true,
						closeOnCancel: true
					},
					function(isConfirm) {
						if (isConfirm) {
						   pageload();
							$('#senmailfrm').attr('action', 'sendMailpostProcess'+'?menuid=menu_mail&time='+datetime);
							$("#senmailfrm").submit();
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

// To reset Error
function resetErrors() {
	$('form input, form select, form radio, form textarea').css("border-color", "");
	$('form input').removeClass('inputTxtError');
	$('label.error').remove();
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
				if (getbranchId != "") {
					$(".incadd").css("display", "inline-block");
					$(".btnclr").css("display", "inline-block");
				} else {
					$(".incadd").css("display", "none");
					$(".btnclr").css("display", "none");
				}
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
	if (getbranchId != "") {
		$(".incadd").css("display", "inline-block");
		$(".btnclr").css("display", "inline-block");
	} else {
		$(".incadd").css("display", "none");
		$(".btnclr").css("display", "none");
	}
	$.ajax({
		type: 'GET',
		dataType: "JSON",
		url: 'incharge_ajax',
		data: {"getcusId": getcusId,"getbranchId": getbranchId},
		success: function(resp) {
			/*for (i = 0; i < resp.length; i++) {
				$('#inchargeDetails').append( '<option value="'+resp[i]["id"]+'">'+resp[i]["incharge_name"]+'</option>' );
				// $('select[name="inchargeDetails"]').val(value);
			}
			var incCount = $('#inchargeDetails > option').length;
			if (incCount == 2) {
				alert(incCount);
				$('#inchargeDetails').val(resp[0]["id"]);
			} */
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
		var confirmcustomer = confirm("Do You Want To Select Customer?");
		if(confirmcustomer) {
			document.getElementById("inchargeDetails").value = "";
			var cusId = $('#hcusId').val();
			$('#customerId').val(cusId);
			$('#customerName').val($('#hName').val());
			fnGetbranchDetail();
			$('#customerSelect').modal('toggle');
		} else {
			return false;
		}
	}
}

// Incharge Name get popup
function inchargename(){
	var branchid = document.getElementById("branchId").value;
	var check = 1;
	popupopenclose(1);
	$('#customerSelect').load('inchargenamepopup?mainmenu='+mainmenu+'&time='+datetime+'&branchid='+branchid+'&check='+check);
	$("#customerSelect").modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#customerSelect').modal('show');
}

// to clear incgarge name
function fninchclear(){
	document.getElementById("inchargeDetails").value = "";
	document.getElementById("hidincharge").value = "";
}

// to clear customer details
function fncusclear(){
	document.getElementById("customerName").value = "";
	document.getElementById("inchargeDetails").value = "";
	document.getElementById("branchId").value = "";
	$('#branchId').find('option').not(':first').remove();
	$(".incadd").css("display", "none");
	$(".btnclr").css("display", "none");
}

// Resume Upload Screen View
function uploadResume(empid,lastname){
	$('#empid').val(empid);
	$('#empname').val(lastname);
	popupopenclose(1);
	$('#uploadRes').load('uploadResume?mainmenu='+mainmenu+'&time='+datetime+'&empId='+empid+'&lastname=1');
	$("#uploadRes").modal({
			backdrop: 'static',
			keyboard: false
		});
	$('#uploadRes').modal('show');
}

// upoload process same as employewe index
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

// back to send mail index
function fnbackmailindex(){
	pageload();
	$('#frmaddeditcancel').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
	$("#frmaddeditcancel").submit();
}
