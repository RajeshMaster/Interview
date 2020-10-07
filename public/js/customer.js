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
$(document).ready(function() {
	$('.addeditprocess').on('click', function() {
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
				/*alert(JSON.stringify(resp));*/
				if(resp == true){
					var mailId = $('#txt_mailid').val();
					$.ajax({
						type: 'GET',
                    	url: 'getEmailExists',
                    	data: {"mailId": mailId},
                    	success: function(resp){
                    		if(resp > 0){
                    			document.getElementById('errorSectiondisplay').innerHTML = "";
	                            err_invalidcer = "Email Id Already Exists";
	                            var error='<div align="center"><label class="error pl5 mt5 tal" style="color:#9C0000;" for="txt_mailid">'+err_invalidcer+'</label></div>';
	                            document.getElementById('errorSectiondisplay').style.display = 'inline-block';
	                            document.getElementById('errorSectiondisplay').innerHTML = error;
	                            return false;
                    		}
                    		else{
                    			if($('#frmcustaddedit #editid').val() == "") {
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
                                			$("#frmcustaddedit").submit();
										} else {
											
										}
									});
                    			}else{
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
                                			$("#frmcustaddedit").submit();
										} else {
											
										}
									});
                    			}

                    			
                    		}
                    	},
                    	error: function(data){

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
						}
					});
				}
			},
			error: function(data) {
			}
		}); 
	});
});
function resetErrors() {
	$('form input, form select, form radio, form textarea').css("border-color", "");
	$('form input').removeClass('inputTxtError');
	$('label.error').remove();
}

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
function fngotoregister() {
	pageload();
	var mainmenu=$('#customerindexform #mainmenu').val();
	$('#customerindexform').attr('action', 'CustomerAddedit?mainmenu='+mainmenu+'&time='+datetime);
	$("#customerindexform").submit();
}
function isNumberKey(evt) { 
  	var charCode = (evt.which) ? evt.which : event.keyCode
  	if (charCode > 31 && (charCode < 48 || charCode > 57))
  		return false;
  	return true;
}
function isNumberKeywithminus(evt) { 
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode == 45) {
      return true;
    }
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
    return true;
}
function addHyphen (element) {
    var ele = document.getElementById(element.id);
    ele = ele.value.split('-').join('');    // Remove dash (-) if mistakenly entered.
    var finalVal = ele.match(/\d{3}(?=\d{2,3})|\d+/g).join('-');
    document.getElementById(element.id).value = finalVal;
}
function goempindexpage(mainmenu,datetime) {
    pageload();
    $('#customerviewform').attr('action', '../Customer/index?mainmenu='+mainmenu+'&time='+datetime);
    $("#customerviewform").submit();
}
function goindexpage(mainmenu,datetime) {
    pageload();
    $('#customerviewform').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
    $("#customerviewform").submit();
}
function edit(datetime,id,custid) {
    $('#id').val(id);
    $('#editid').val(id);
    $('#flg').val("1");
    $('#custid').val(custid);
    var mainmenu="menu_customer";
    $('#customerviewform').attr('action', 'CustomerAddedit?mainmenu='+mainmenu+'&time='+datetime);
    $("#customerviewform").submit();
}
function branchadd(datetime) {
    $('#flg').val("");
    pageload();
    var mainmenu="menu_customer";
    $('#customerviewform').attr('action', 'Branchaddedit?mainmenu='+mainmenu+'&time='+datetime);
    $("#customerviewform").submit();
}