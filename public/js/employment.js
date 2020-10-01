
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

function cushistory(){
	alert("Under Construction");
}

function workend(){
	alert("Under Construction");
}

function gotoResume(){
	alert("Under Construction");
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
	$('#frmaddeditcancel').attr('action', 'view?mainmenu='+mainmenu+'&time='+datetime);
	$("#frmaddeditcancel").submit();
}

// To reset Error
function resetErrors() {
	$('form input, form select, form radio, form textarea').css("border-color", "");
	$('form input').removeClass('inputTxtError');
	$('label.error').remove();
}
// Resign Employee
function fnresignemployee() {
	alert("Under Construction");
}