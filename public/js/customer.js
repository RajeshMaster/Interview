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
	$('.Branchaddeditprocess').on('click', function() {
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
                    			if($('#frmbranchaddedit #editid').val() == "") {
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
                                			$("#frmbranchaddedit").submit();
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
                                			$("#frmbranchaddedit").submit();
										} else {
											
										}
									});
                    			}
                    		}
                    	},
                    	error: function(data){

                    	}
					});

				}else{
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
	$('.Inchargeaddeditprocess').on('click', function() {
		resetErrors();
		var url ='InchargeRegValidation';
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
					var inchargeName = $('#txt_incharge_name').val();
					var mailId = $('#txt_mailid').val();
                	var editId = $('#editid').val();
					$.ajax({
						type: 'GET',
                    	url: 'getEmailExists',
                    	data: {"inchargeName": inchargeName,
                            "mailId": mailId,
                            "editId": editId},
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
                    			if($('#frminchargeaddedit #editid').val() == "") {
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
                                			$("#frminchargeaddedit").submit();
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
                                			$("#frminchargeaddedit").submit();
										} else {
											
										}
									});
                    			}
                    		}
                    	},
                    	error: function(data){

                    	}
					});
				}
				else{
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
			error: function(data){

			}
		});

	});
	$('.empaddeditprocess').on('click', function(){
		resetErrors();
		var url ='EmpNamePopupRegValidation';
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
					if($('#frmempnameedit #editid').val() == 1) {
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
                    			$("#frmempnameedit").submit();
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
                    			$("#frmempnameedit").submit();
							} else {
								
							}
						});
					}
				}
				else{
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
							$('input[name="' + i + '"], select[name="' + i + '"],textarea[name="' + i + '"]').focus().addClass('inputTxtError').after(msg);
						}
					});
				}
			},
			error: function(data){

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
	$('#searchmethod').val('');
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

// Enter ker Search process 
function checkSubmitsingle(e) {
	if(e && e.keyCode == 13) {
		fnSingleSearch();
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
	$("#filterval").val('');
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
    $('#customerviewform').attr('action', '../Employee/empHistory?mainmenu='+mainmenu+'&time='+datetime);
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
function gotoinpage(mainmenu,datetime) {
    pageload();
    $('#frmbranchaddeditcancel').attr('action', 'CustomerView?mainmenu='+mainmenu+'&time='+datetime);
    $("#frmbranchaddeditcancel").submit();
}
function branchedit(datetime,branchid){
    $('#flg').val("1");
    $('#editid').val(branchid);
    $('#branchid').val(branchid);
    var mainmenu="menu_customer";
    $('#customerviewform').attr('action', 'Branchaddedit?mainmenu='+mainmenu+'&time='+datetime);
    $("#customerviewform").submit();
}
function inchargeadd(datetime) {
    $('#flg').val("");
    pageload();
    var mainmenu="menu_customer";
    $('#customerviewform').attr('action', 'Inchargeaddedit?mainmenu='+mainmenu+'&time='+datetime);
    $("#customerviewform").submit();
}
function gotoviewpage(mainmenu,datetime) {
   swal({
		title: msg_cancel,
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		closeOnConfirm: true,
		closeOnCancel: true
	},
	function(isConfirm) {
		if (isConfirm) {
		   	pageload();
			$("#frminchargeaddeditcancel").submit();
		} else {
			
		}
	});
}
function inchargeedit(datetime,inchargeid){
    $('#flg').val("1");
    $('#editid').val(inchargeid);
    $('#inchargeid').val(inchargeid);
    var mainmenu="menu_customer";
    $('#customerviewform').attr('action', 'Inchargeaddedit?mainmenu='+mainmenu+'&time='+datetime);
    $("#customerviewform").submit();
}
function empselectionpopupadd(datetime,custid,id){
	popupopenclose(1);
	var selectionid = $('#selectionid').val();
	var mainmenu="menu_customer";
	$('#empnamepopup').load('../Customer/EmpNamePopup?custid='+custid+'&id='+id+'&selectionid='+selectionid+'&mainmenu='+mainmenu+'&time='+datetime);
	$("#empnamepopup").modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#empnamepopup').modal('show');
} 
function empNamePopupOpen(datetime,custid,id){
	var employeeid=$("#emp_id").val();
	var mainmenu="menu_customer";
	$('#empnamepopup').load('../Customer/EmpNamePopup?custid='+custid+'&id='+id+'&mainmenu='+mainmenu+'&employeeid='+employeeid+'&time='+datetime);
	$("#empnamepopup").modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#empnamepopup').modal('show');
} 
function closefunction() {
	swal({
		title: msg_cancel,
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		closeOnConfirm: true,
		closeOnCancel: true
		},
		function(isConfirm) {
			if (isConfirm) {
			   	$("body div").removeClass("modalOverlay");
				$('#empnamepopup').empty();
				$('#empnamepopup').modal('toggle');
			} else {
				
			}
	});
}
function fnGetbranchDetail(value){
	$('#inchargeId').find('option').not(':first').remove();
	var getcusId = $('#custid').val();
	var getbranchId = $('#newbranches').val();
	var mainmenu = 'menu_customer';
	$.ajax({
		type: 'GET',
		dataType: "JSON",
		url: 'incharge_ajax',
		data: {"getcusId": getcusId,"getbranchId": getbranchId,"mainmenu": mainmenu},
		success: function(resp) {
			for (i = 0; i < resp.length; i++) {
				$('#inchargeId').append( '<option value="'+resp[i]["id"]+'">'+resp[i]["incharge_name"]+'</option>' );
				$('select[name="inchargeId"]').val(value);
			}
		},
		error: function(data) {
			alert(data.status);
		}
	});
}
function disablededittrue(empoid) {
    $("#emp_id").val(empoid);
    $("#select" ).css( "background-color", "orange" );
    $("#select" ).removeAttr("disabled");
}
function getchangeempdetails(datetime,empid,empname){
    $('#hdnempid').val(empid);
    $('#hdnempname').val(empname);
    var mainmenu="menu_customer";
    $('#customerviewform').attr('action', '../Customer/Onsitehistory?mainmenu='+mainmenu+'&time='+datetime);
    $("#customerviewform").submit();
}
function fngoback(){
	var back = $('#hdnback').val();

	pageload();
	if(back == 1){
		$('#emphistoryviewform').attr('action', '../Employee/empHistory?mainmenu=menu_emphistory&time='+datetime);
        $('#mainmenu').val("menu_emphistory");
        $("#emphistoryviewform").submit();
	}else{
		$('#emphistoryviewform').attr('action', '../Customer/CustomerView?mainmenu='+mainmenu+'&time='+datetime);
    	$("#emphistoryviewform").submit();
	}
}
function gotoindexpage(viewflg,mainmenu,datetime) {
	swal({
		title: msg_cancel,
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		closeOnConfirm: true,
		closeOnCancel: true
		},
		function(isConfirm) {
			if (isConfirm) {
			   if (viewflg == "1") {
     				pageload();
        			$('#frmcustaddeditcancel').attr('action', 'CustomerView?mainmenu='+mainmenu+'&time='+datetime);
        			$("#frmcustaddeditcancel").submit();
    			} else {
			        $('#frmcustaddeditcancel').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
			        $("#frmcustaddeditcancel").submit();
    			}
			} else {
				
			}
	});
}