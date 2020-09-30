var data = {};
// Validation process in Register page
$(document).ready(function() {
	$('.addeditprocess').click(function () {
		$("#frmuseraddedit").validate({
			showErrors: function(errorMap, errorList) {
			// Clean up any tooltips for valid elements
				$.each(this.validElements(), function (index, element) {
						var $element = $(element);
						$element.data("title", "") // Clear the title - there is no error associated anymore
								.removeClass("error")
								.tooltip("destroy");
				});
				// Create new tooltips for invalid elements
				$.each(errorList, function (index, error) {
						var $element = $(error.element);
						$element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
								.data("title", error.message)
								.addClass("error")
								.tooltip(); // Create a new tooltip based on the error messsage we just set in the title
				});
			},
			rules: {
				firstname: {required: true},
				lastname: {required: true},
				dob: {required: true, date: true,correctformatdate: true},
				gender: {required: true},
				emailid: {required: true ,email:true},
				password: {required: true},
				conpassword: {required: true,equalTo: "#password"},
				mobileno: {required: true,minlength: 10},
			},
			submitHandler: function(form) { // for demo
				var mailId = $('#emailid').val();
				var editId = $('#editid').val();
				$.ajax({    // To return the ajax value to parent function 
					type: 'GET',
					url: 'getEmailExists',
					data: {mailId: mailId,
							editId:editId},
					success: function(resp) {
						if (resp > 0) { 
							$("#existsChk_textbox1").show(); 
							return false;
						} else {
							$("#existsChk_textbox1").hide(); 
							if($('#editid').val() == "") {
								var err_cnfirm = msg_register;
							} else {
								var err_cnfirm = msg_update;
							}
							swal({
								title: err_cnfirm,
								type: "warning",
								showCancelButton: true,
								confirmButtonClass: "btn-danger",
								closeOnConfirm: true,
								closeOnCancel: true
							},
							function(isConfirm) {
								if(isConfirm) {    
									pageload();
									form.submit();
									return true;
								} else {
									return false;
								}
							});
						}
					},
					error: function(data) {
						// alert('f');
					}
				});
			}
		});
		$.validator.messages.required = function (param, input) {
			var article = document.getElementById(input.id);
			return article.dataset.label + ' field is required';
		}
		$.validator.messages.equalTo = function (param, input) {
			var article = document.getElementById(input.id);
			return msg_passwordmatch;
		}
		
	});
});

// Register page view process in edit
function useredit(flg,id) {
	var mainmenu = 'menu_user';
	$('#editflg').val(flg);
	$('#editid').val(id);
	$('#profileview').attr('action', '../User/edit?mainmenu='+mainmenu+'&time='+datetime);
	$("#profileview").submit();
}

// Cancel check Register page
function fnuserCancel() {
	if (cancel_check == false) {
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
					$('#frmuseraddeditcancel').attr('action', '../User/profile'+'?mainmenu='+mainmenu+'&time='+datetime); 
					$("#frmuseraddeditcancel").submit();
			} else {
				return false;
			}
		});
	} else {
		pageload();
		$('#frmuseraddeditcancel').attr('action', '../User/profile'+'?mainmenu='+mainmenu+'&time='+datetime); 
		$("#frmuseraddeditcancel").submit();
	}
}

// Userprofileview page view process
function fnRedirectToview(userId) {
	$('#userId').val(userId);
	$('#userIndex').attr('action', '../User/profile?mainmenu='+mainmenu+'&time='+datetime);
	$("#userIndex").submit();
}

// Userprofileview page  back button process
function fnredirectback() {
	pageload();
	$('#profileview').attr('action', '../User/index'+'?mainmenu='+mainmenu+'&time='+datetime); 
	$("#profileview").submit();
}

// Search process in UserIndex page
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
		$('#userIndex').attr('action', '../User/index?mainmenu='+mainmenu+'&time='+datetime);
		$("#userIndex").submit();
	}
}

// Enter ker Search process in UserIndex page
function checkSubmitsingle(e) {
	if(e && e.keyCode == 13) {
		fnSingleSearch();
	}
}

// Pagination process in UserIndex page
function pageClick(pageval) {
	$('#page').val(pageval);
	$("#userIndex").submit();
}
function pageLimitClick(pagelimitval) {
	$('#page').val('');
	$('#plimit').val(pagelimitval);
	$("#userIndex").submit();
}

// Sorting process in UserIndex page
$(function () {
	var cc = 0;
	$('#usersort').click(function () {
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
	var sortselect = $('#usersort').val();
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
	$("#userIndex").submit();
}

// Clear search process in UserIndex page
function clearsearch() {
	$('#plimit').val(50);
	$('#page').val('');
	$("#filterval").val('');
	$('#usersort').val('');
	$('#sortOrder').val('asc'); 
	$('#singlesearch').val('');
	$("#userIndex").submit();
}

// Filter process in UserIndex page
function filter(val) {
	pageload();
	$("#filterval").val(val);
	$("#usersort").val('');
	$('#plimit').val('');
	$('#page').val('');
	$('#singlesearch').val('');
	$('#userIndex').submit();
}
