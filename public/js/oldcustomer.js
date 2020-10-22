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

$(document).ready(function() {
	$('.addeditprocesscopy').on('click', function() {
		$("#CountError").hide();
		$("#emailError").hide();
		resetErrors();
		var url ='CustomerRegValidation';
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
					var mailId = $('#txt_mailid').val();
					var incharge_name = $('#txt_incharge_name').val();
				
					var newStr = mailId.slice(0, -1);
					var arr = newStr.split(';');
					var name = incharge_name.slice(0, -1);
					var namearr = name.split(';');
					if (arr.length != namearr.length) {
						$("#CountError").show();
						return false;
					} else {
						var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
						for(var i=0; i< arr.length; i++){
							if(arr[i].match(mailformat)){
							} else {
								$("#emailError").show();
								return false;
							}
						}
					}

					$.ajax({
						type: 'GET',
						url: 'getEmailExistsManyFields',
						data: {"mailId": mailId},
						success: function(resp) {

							if (resp > 0) {
								document.getElementById('errorSectiondisplay').innerHTML = "";
								err_invalidcer ="No"+resp +"Email Id Already Exists";
								 var error='<div align="center" style="padding: 0px;" id="inform">';
										error+='<table cellspacing="0" class="statusBg1" cellpadding="0" border="0">';
										error+='<tbody><tr><td style="padding: 4px 10px" align="center"><span class="innerBg" id="mc_msg_txt">'+err_invalidcer+'</span></td>';
										error+='<td width="20" valign="top" style="padding-top: 4px; _padding-top: 2px;"><span>';
										error+='<a href="javascript:displaymessage();" class="fa fa-times" style="color:white;"/>';
										error+='</span></td>';
										error+='</tr></tbody></table></div>';
								document.getElementById('errorSectiondisplay').style.display = 'block';
								document.getElementById('errorSectiondisplay').innerHTML = error;
								$( "#txt_mailid" ).focus();
							} else {
								swal({
								title: msg_register,
								type: "warning",
								showCancelButton: true,
								confirmButtonClass: "btn-danger",
								closeOnConfirm: true,
								closeOnCancel: true
								},
								function(isConfirm) {
									if (isConfirm) {
										pageload();
										$("#frmcustaddcopy").submit();
									} else {
										
									}
								});
							}
						},
						error: function(data) {
							alert(data);
							// $("#regbutton").attr("data-dismiss","modal");
						}
					});

				} else{
					$.each(resp, function(i, v) {
						// alert(i + " => " + v); // view in console for error messages
						var msg = '<label class="error pl5 mt5 tal" style="color:#9C0000;" for="'+i+'">'+v+'</label>';
						if ($('input[name="' + i + '"]').hasClass('mailname')) {
							$('input[name="' + i + '"]').addClass('inputTxtError');
							$('.mailname_err').append(msg)
						} else if ($('input[name="' + i + '"]').hasClass('mailSubject')) {
							$('input[name="' + i + '"]').addClass('inputTxtError');
							$('.mailSubject_err').append(msg)
						} else if ($('input[name="' + i + '"]').hasClass('mailheader')) {
							$('input[name="' + i + '"]').addClass('inputTxtError');
							$('.mailheader_err').append(msg)
						} else if ($('textarea[name="' + i + '"]').hasClass('mailContent')) {
							$('textarea[name="' + i + '"]').addClass('inputTxtError');
							$('.mailContent_err').append(msg)
						} else {
							$('input[name="' + i + '"], select[name="' + i + '"],textarea[name="' + i + '"]').addClass('inputTxtError').after(msg);
							// $('input[name="' + i + '"], select[name="' + i + '"],textarea[name="' + i + '"]').addClass('inputTxtError');
						}
					});
				}
			},
			error: function(data) {
			}
		}); 
	});

		$('.Branchaddedcopy').on('click', function() {
		resetErrors();
		var url ='BranchRegValidation';
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
				if(resp == true) {
					var mailId = $('#txt_mailid').val();
					var incharge_name = $('#txt_incharge_name').val();
					var newStr = mailId.slice(0, -1);
					var arr = newStr.split(';');
					var name = incharge_name.slice(0, -1);
					var namearr = name.split(';');
					if (arr.length != namearr.length) {
						$("#CountError").show();
						return false;
					} else {
						var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
						for(var i=0; i< arr.length; i++){
							if(arr[i].match(mailformat)){
							} else {
								$("#emailError").show();
								return false;
							}
						}
					}

					$.ajax({
						type: 'GET',
						url: 'getEmailExistsManyFields',
						data: {"mailId": mailId},
						success: function(resp) {
							if (resp > 0) {
								document.getElementById('errorSectiondisplay').innerHTML = "";
								err_invalidcer ="No"+resp +"Email Id Already Exists";
								 var error='<div align="center" style="padding: 0px;" id="inform">';
										error+='<table cellspacing="0" class="statusBg1" cellpadding="0" border="0">';
										error+='<tbody><tr><td style="padding: 4px 10px" align="center"><span class="innerBg" id="mc_msg_txt">'+err_invalidcer+'</span></td>';
										error+='<td width="20" valign="top" style="padding-top: 4px; _padding-top: 2px;"><span>';
										error+='<a href="javascript:displaymessage();" class="fa fa-times" style="color:white;"/>';
										error+='</span></td>';
										error+='</tr></tbody></table></div>';
								document.getElementById('errorSectiondisplay').style.display = 'block';
								document.getElementById('errorSectiondisplay').innerHTML = error;
								$( "#txt_mailid" ).focus();
							} else {
								swal({
									title: msg_register,
									type: "warning",
									showCancelButton: true,
									confirmButtonClass: "btn-danger",
									closeOnConfirm: true,
									closeOnCancel: true
									},
								function(isConfirm) {
										if (isConfirm) {
											pageload();
											$("#frmbranchaddcopy").submit();
										} else {
											
										}
								});
							}
						},
						error: function(data) {
							alert(data);
							// $("#regbutton").attr("data-dismiss","modal");
						}
					});






					

				} else {
					$.each(resp, function(i, v) {
						var msg = '<label class="error pl5 mt5 tal" style="color:#9C0000;" for="'+i+'">'+v+'</label>';
						if ($('input[name="' + i + '"]').hasClass('mailname')) {
							$('input[name="' + i + '"]').addClass('inputTxtError');
							$('.mailname_err').append(msg)
						} else if ($('input[name="' + i + '"]').hasClass('mailSubject')) {
							$('input[name="' + i + '"]').addClass('inputTxtError');
							$('.mailSubject_err').append(msg)
						} else if ($('input[name="' + i + '"]').hasClass('mailheader')) {
							$('input[name="' + i + '"]').addClass('inputTxtError');
							$('.mailheader_err').append(msg)
						} else if ($('textarea[name="' + i + '"]').hasClass('mailContent')) {
							$('textarea[name="' + i + '"]').addClass('inputTxtError');
							$('.mailContent_err').append(msg)
						} else {
							$('input[name="' + i + '"], select[name="' + i + '"],textarea[name="' + i + '"]').addClass('inputTxtError').after(msg);
						}
					});
				}

			},
			error: function(data) {
			}
		});
	});

	$('#selectInc').click(function () {
			// document.getElementById("inchargeValue").value = "";
			// document.getElementById("txt_incharge_name").value = "";
			if ($("[name='incharge[]']:checked").length <= 0) {
				$("#selctedIncharge").val('');
				alert("Please select atleast one Incharge");
				return false;
			} else {
				// var count = $("[type='checkbox']:checked").length;
				$("#selctedIncharge").val('1');
				$("#selctedInchargeNumber").val('1');
				var getchecked = $("#selctedIncharge").val();
				var selctedInchargeNumber = $("#selctedInchargeNumber").val();

				$("[name='incharge[]']:checked").each(function() {
					var res = $(this).val();
					var res = $(this).val().split("$");

					if (getchecked == 1 && selctedInchargeNumber ==1) {
						selctedInchargeNumber = 2;
						$('#inchargeValue').val($('#inchargeValue').val() + res[0]);
						$('#txt_incharge_name').val($('#txt_incharge_name').val()  + res[1]);

						if (res[2] != "") {
							$('#txt_mailid').val($('#txt_mailid').val()  + res[2]);
						}
					} else {
						$('#inchargeValue').val($('#inchargeValue').val() + ";" + res[0]);
						$('#txt_incharge_name').val($('#txt_incharge_name').val() + ";" + res[1]);

						if (res[2] != "") {
							$('#txt_mailid').val($('#txt_mailid').val() + ";" + res[2]);
						}
					}
				});

				var v = document.getElementById("inchargeValue").value;
				document.getElementById("inchargeValue").value = v + ";";
				var s = document.getElementById("txt_incharge_name").value;
				document.getElementById("txt_incharge_name").value = s + ";";
				var e = document.getElementById("txt_mailid").value;
				if (e != "") {
					document.getElementById("txt_mailid").value = e + ";";
				}

				$("body div").removeClass("modalOverlay");
				$('#inchargeSelect').empty();
				$('#inchargeSelect').modal('toggle');
			}
				return false;
		});
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
	var mainmenu="menu_oldcustomer";
	$('#customerviewform').attr('action', 'copyCustomer?mainmenu='+mainmenu+'&time='+datetime);
	$("#customerviewform").submit();
}

function oldInchargeSelect(mainmenu) {
	 popupopenclose(1);
	$('#inchargeSelect').load('OldInchargeSelect?mainmenu='+mainmenu+'&time='+datetime);
	$("#inchargeSelect").modal({
		   backdrop: 'static',
			keyboard: false
		});
	$('#inchargeSelect').modal('show');
}

function fncheckalreadyCheck(){
	var Incharge = $('#inchargeValue').val();
	if (Incharge != "") {
		var newStr = $('#inchargeValue').val().slice(0, -1);
		var arr = newStr.split(';');
		for(var i=0; i< arr.length; i++){
			$("."+arr[i]).prop("disabled", true);
		}
	}
	return false;
}

function trclick (id) {
	var chk = "."+id;
	var check = $(chk).is(":checked");
	if (check) {
		$(chk).prop('checked', false);
	} else {
		$(chk).prop('checked', true);
	}
}

function divGroupSelPopClosess() {
	var confirmmsg = 'Do You Want To Cancel?';
	if (confirm(confirmmsg)) {
		$("body div").removeClass("modalOverlay");
		$('#inchargeSelect').empty();
		$('#inchargeSelect').modal('toggle');
	} else {
		return false;
	}
}

function resetErrors() {
	$('form input, form select, form radio, form textarea').css("border-color", "");
	$('form input').removeClass('inputTxtError');
	$('label.error').remove();
}

function gotoinpagecancel() {
	if (confirm("Do You Want To Cancel the Page?")) {
		pageload();
		$('#frmbranchaddcopycancel').attr('action', 'addcopycancel?mainmenu='+mainmenu+'&time='+datetime);
		$("#frmbranchaddcopycancel").submit();
	} else {
		return false;
	}
}

function gotoviewpagecopy() {
	if (confirm("Do You Want To Cancel the Page?")) {
		$('#frmcustaddcopycancel').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
		$("#frmcustaddcopycancel").submit();
	} else {
		return false;
	}
}

function cleartxt(){
	$('#inchargeValue').val("");
	$('#txt_incharge_name').val("");
	$('#txt_mailid').val("");
	$('#selctedIncharge').val("");
	$('#selctedInchargeNumber').val("");
}

function importpopupenable(mainmenu) {
     popupopenclose(1);
    $('#importpopup').load('importpopup?mainmenu='+mainmenu+'&time='+datetime);
    $("#importpopup").modal({
           backdrop: 'static',
            keyboard: false
        });
    $('#importpopup').modal('show');
}
function addHyphen (element) {
    var ele = document.getElementById(element.id);
    ele = ele.value.split('-').join('');    // Remove dash (-) if mistakenly entered.
    var finalVal = ele.match(/\d{3}(?=\d{2,3})|\d+/g).join('-');
    document.getElementById(element.id).value = finalVal;
}

function deleteCustomer(){
	var mainmenu="menu_oldcustomer";
	swal({
			title: "Do You Want To Delete?",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			closeOnConfirm: true,
			closeOnCancel: true
		},
		function(isConfirm) {
			if (isConfirm) {
				pageload();
				$('#customerviewform').attr('action', 'deleteCustomer?mainmenu='+mainmenu+'&time='+datetime);
				$("#customerviewform").submit();
			}
	});
}