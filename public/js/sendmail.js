
var data = {};
$(document).ready(function() {
	$('.sendmailRegister').on('click', function() {
		resetErrors();
		$("#rdoreq").css("display", "none");

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
					if (!($("#type1").prop("checked")) && !($("#type2").prop("checked")))  {
						$("#rdoreq").css("display", "inline-block");
						return false;
					}

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

					if (!($("#type1").prop("checked")) && !($("#type2").prop("checked")))  {
						$("#rdoreq").css("display", "inline-block");
					}

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

	$('.selectgroup').click(function () {
		if ($("[name='group[]']:checked").length <= 0) {
			alert("Please select atleast one Group");
			return false;
		} else {
			$("[name='group[]']:checked").each(function() {
				var res = $(this).val().split("$");
				$('#groupvalue').val($('#groupvalue').val() + ";" + res[0]);
				$('#groupname').val($('#groupname').val() + ";" + res[1]);
			});
			if(groupname.text !="") {
				$("#customernamerequired").css("visibility", "hidden");
				$("#branchnamerequired").css("visibility", "hidden");
			}
			var v = document.getElementById("groupvalue").value;
			document.getElementById("groupvalue").value = v.substring(1) + ";";
			var s = document.getElementById("groupname").value;
			document.getElementById("groupname").value = s.substring(1) + ";";
			$("body div").removeClass("modalOverlay");
			$('#customerSelect').empty();
			$('#customerSelect').modal('toggle');
		}
	});
});

/*
フリタ処理
*/
function filterNotMb(val,title) {
	$('#plimit').val(50);
	$('#page').val('');
	$('#resignid').val(val);
	$('#title').val(title);
	$('#mailSendfrm').attr('action', '../Employee/index?mainmenu=menu_employee&time='+datetime);
	$("#mailSendfrm").submit();
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

						if (resp.length < 2) {
							$("<span id='junk'>"+ resp[0]["incharge_email_id"] +"</span><br>").appendTo(".mailidLabel");
							$('#inchargeDetails').val(resp[0]["incharge_name"] + ";");
							$('#hidincharge').val(resp[0]["id"] + ";");
							$('#inchargemailDetails').val(resp[0]["incharge_email_id"] + ";");
							// $('#inchargeDetails').val(resp[0]["id"]);
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
	document.getElementById("hidincharge").value = "";
	document.getElementById("inchargemailDetails").value = "";
	$('span[id^="junk"]').remove();
	$('.mailidLabel').find('br').remove();

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
function customerCCSelectPopup(){
	var customerId = $('#customerId').val();
	var grpId = $('#groupvalue').val();
	popupopenclose(1);
	$('#customerSelect').load('customerCCSelectPopup?mainmenu='+mainmenu+'&time='+datetime+'&customerId='+customerId+'&grpId='+grpId);
	$("#customerSelect").modal({
			backdrop: 'static',
			keyboard: false
		});
	$('#customerSelect').modal('show');
}
// Double Click on popup Select tr
function fndbclick(cusid,cusname,name) {
	document.getElementById("inchargeDetails").value = "";
	document.getElementById("hidincharge").value = "";
	document.getElementById("inchargemailDetails").value = "";
 	fninchclear();
	$('span[id^="junk"]').remove();
	$('.mailidLabel').find('br').remove();
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
function fnSclkTrgrp(grpid,grpname) {
	if ($('.' + grpid).is(':checked')) {
		$("."+grpid).prop("checked", false);
    } else {
		$("."+grpid).prop("checked", true);
    }
}

// Single Click in tr for group
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
		document.getElementById("inchargeDetails").value = "";
		document.getElementById("hidincharge").value = "";
		document.getElementById("inchargemailDetails").value = "";
		$('span[id^="junk"]').remove();
		$('.mailidLabel').find('br').remove();
		var cusId = $('#hcusId').val();
		$('#customerId').val(cusId);
		$('#customerName').val($('#hName').val());
		fnGetbranchDetail();
		$('#customerSelect').modal('toggle');
	}
}
function fnCCselect() {
	if ($('input[name="cusId[]"]:checked').length == 0) {
		document.getElementById("ccemail").value = "";
		document.getElementById("hidccid").value = "";
		alert("Please select atleast one Customer");
		return false;
	}else{ 
		document.getElementById("ccemail").value = "";
		document.getElementById("hidccid").value = "";
		$("[name='cusId[]']:checked").each(function(){
			var res = $(this).val().split("$");
			var cchid = $("#hidccid").val();
			if (cchid.length > 0) {
				$('#hidccid').val(cchid + ";" + res[0]);
				$('#ccemail').val($("#ccemail").val() + ";" + res[1]);
			}else{
				$('#hidccid').val(cchid + res[0]);
				$('#ccemail').val($("#ccemail").val() + res[1]);
			}
		});
		$("body div").removeClass("modalOverlay");
		$('#customerSelect').empty();
		$('#customerSelect').modal('toggle');
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
	document.getElementById("inchargemailDetails").value = "";
	document.getElementById("tomailDetails").value = "";
	document.getElementById("tomailName").value = "";
	document.getElementById("tomailSelected").value = "";
	document.getElementById("hidmailSelectedid").value = "";
	$('span[id^="junk"]').remove();
	$('.mailidLabel').find('br').remove();
	$('span[id^="tomail"]').remove();
	$('.othermailidLabel').find('br').remove();
	$('span[id^="toselmail"]').remove();
	$('.otherlabel').find('br').remove();
}

// to clear customer details
function fncusclear(){
	document.getElementById("customerName").value = "";
	$('#branchId').find('option').not(':first').remove();
	document.getElementById("branchId").value = "";
	document.getElementById("inchargeDetails").value = "";
	document.getElementById("hidincharge").value = "";
	document.getElementById("inchargemailDetails").value = "";
	document.getElementById("customerId").value = "";
	$('span[id^="junk"]').remove();
	$('.mailidLabel').find('br').remove();
	$(".incadd").css("display", "none");
	$(".btnclr").css("display", "none");
	fninchclear();
}
function fncusCCclear(){
	document.getElementById("hidccid").value = "";
	document.getElementById("ccemail").value = "";
}

// Resume Upload Screen View
function uploadResume(empid,lastname){
	$('#empId').val(empid);
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
	var pdf = $('#pdffile').val();
	var xlfile = $('#xlfile').val();
	var pdfsize = document.getElementById("pdffile").files[0];
	var excelsize = document.getElementById("xlfile").files[0];
	if (pdf != "") {
		pdf = pdf.split(".");
		xlfile = xlfile.split(".");
		if (pdf[pdf.length -1] != "pdf") {
			alert(msg_fileformat);
			return;
		} else if(pdfsize.size > 2097152) {
			alert("Pdf size must less than 2mb!");
			return;
		} else {
			if($("[name='addexcel']:checked").length > 0) {
				if($("[name='addexcel']:checked").length > 0 && xlfile == "") {
					alert("please select Excel File");
					return;
				} else if(xlfile[xlfile.length -1] != "xls" && xlfile[xlfile.length -1] != "xlsx"){
					alert("Please select the correct format");
					return;
				} else if(excelsize.size > 2097152) {
					alert("Excel size must less than 2mb!");
					return;
				}
			}
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

// Function To select Group
function groupSelect() {
	document.getElementById("groupvalue").value = "";
	document.getElementById("groupname").value = "";
	if(groupname.text == null) {
		$("#customernamerequired").css("visibility", "visible");
		$("#branchnamerequired").css("visibility", "visible");
	}
	popupopenclose(1);
	$('#customerSelect').load('groupadd?mainmenu='+mainmenu+'&time='+datetime);
	$("#customerSelect").modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#customerSelect').modal('show');
}

function slectType(type) {
	$('#selectedType').val(type);
	if(type ==  1){
		$(".grpdiv").css("display", "inline-block");
		$(".cstdiv").css("display", "none");
		document.getElementById("customerId").value = "";
		document.getElementById("customerName").value = "";
		$(".bradiv").css("display", "none");
		document.getElementById("branchId").value = "";
		$(".incdiv").css("display", "none");
		$(".incmaildiv").css("display", "none");
		document.getElementById("inchargeDetails").value = "";
		document.getElementById("hidincharge").value = "";
		document.getElementById("inchargemailDetails").value = "";
		$('span[id^="junk"]').remove();
		$('.mailidLabel').find('br').remove();
		$('#branchId').find('option').not(':first').remove();
		fninchclear();
		fncusCCclear();
	}  else {
		$(".grpdiv").css("display", "none");
		document.getElementById("groupvalue").value = "";
		document.getElementById("groupname").value = "";
		$(".cstdiv").css("display", "inline-block");
		$(".bradiv").css("display", "inline-block");
		$(".incdiv").css("display", "inline-block");
		$(".incmaildiv").css("display", "inline-block");
	}
}

function pdfview(filename) {
	$('#filename').val(filename);
	$('#frmurlview').attr('action', 'pdfViewProcess?mainmenu='+mainmenu+'&time='+datetime);
	$("#frmurlview").submit();
}

// Skill Add Screen View
function skillAdd(empid,lastname ,skillSel){
	$('#empId').val(empid);
	$('#empname').val(lastname);
	popupopenclose(1);
	$('#uploadSkill').load('skillAdd?mainmenu='+mainmenu+'&time='+datetime+'&empId='+empid+'&lastname=1&skillSel='+skillSel);
	$("#uploadSkill").modal({
			backdrop: 'static',
			keyboard: false
		});
	$('#uploadSkill').modal('show');
}

function EmployeInd() {
	$('#mailSendfrm').attr('action', '../Employee/index?mainmenu=menu_employee&time='+datetime);
	$("#mailSendfrm").submit();
}
// Resume History
function resumeHistory(id) {
	pageload();
	$('#empId').val(id);
	$('#hidHistory').val(1);
	$('#mailSendfrm').attr('action', '../Employee/resumeHistory?mainmenu='+mainmenu+'&time='+datetime);
	$("#mailSendfrm").submit();
}

// Resume History
function downloadResume(resumename) {
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
			$('#mailSendfrm #filenamePdf').val(resumename);
			$('#mailSendfrm').attr('action', '../Employee/downloadprocess?mainmenu='+mainmenu+'&time='+datetime);
			$("#mailSendfrm").submit();
		}
	});
}

function uploadvideo(empid,lastname,kananame){
	$('#empId').val(empid);
	popupopenclose(1);
	$('#uploadRes').load('uploadVideoPopup?mainmenu='+mainmenu+'&time='+datetime+'&empId='+empid+'&Lastname='+lastname+'&Kananame='+kananame);
	$("#uploadRes").modal({
			backdrop: 'static',
			keyboard: false
		});
	$('#uploadRes').modal('show');
}

function fnUploadVideo(){
	var url = $('#urlLink').val();
    if (url != undefined || url != '') {        
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
        var match = url.match(regExp);
        if (match && match[2].length == 11) {
        	$('#embedLink').val(match[2]);
            swal({
				title: msg_upload,
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				closeOnConfirm: true,
				closeOnCancel: true
			},
			function(isConfirm) {
				if(isConfirm) {
					$("#uploadpopup").submit();
				}
			});
        } else {
            alert('Enter The YouTube URL Format');
            // Do anything for not being valid
        }
    }
}
function videoPlay(url){
	var url = url;
	var id = url.split("?v=")[1];
	var embedlink = "https://www.youtube.com/embed/" + id;
	popupopenclose(1);
	$('#videoplayPopup').load('videoPlayPopup?mainmenu='+mainmenu+'&time='+datetime+'&embedlink='+embedlink);
	$("#videoplayPopup").modal({
			backdrop: 'static',
			keyboard: false
		});
	$('#videoplayPopup').modal('show');
}
function videostop(){
	$('#iframevideo').attr('src', '');
}

function fnAddExlfile() {
	if($("[name='addexcel']:checked").length > 0) {
		$('.excellbl').show();
	} else {
		$('.excellbl').hide();
		$('#xlfile').val('');
	}
}

function fnGetskillsDetails() {
	var empId = $('#empId').val();
	var lastname = $('#empname').val();
	var skillSel =  $('#skills').val();
	$('#selectedskill').val(skillSel);
	skillAdd(empId,lastname,skillSel);

}
