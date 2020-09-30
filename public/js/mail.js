function pageClick(pageval) {
	$('#page').val(pageval);
	$("#mailstatus").submit();
}
function pageLimitClick(pagelimitval) {
	$('#page').val('');
	$('#plimit').val(pagelimitval);
	$("#mailstatus").submit();
}
var data = {};
$(document).ready(function() {
	$('.mailRegister').on('click', function() {
		resetErrors();
		var url ='mailregvalidation';
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
					if($('#whichprocess').val() == 1) {
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
								$('#mail_reg').attr('action', 'mailcontentregprocess'+'?menuid=menu_mail&time='+datetime);
								$("#mail_reg").submit();
							} else {
								 $("#addedit").attr("disabled", false);
							}
						});
					}else{ 
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
								$('#mail_reg').attr('action', 'mailcontentregprocess'+'?menuid=menu_mail&time='+datetime);
								$("#mail_reg").submit();
							} else {
								$("#addedit").attr("disabled", false);
							}
						});
					}
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
				// alert(data.status);
				// alert('there was a problem checking the fields');
			}
		});

	});
});
function resetErrors() {
	$('form input, form select, form radio, form textarea').css("border-color", "");
	$('form input').removeClass('inputTxtError');
	$('label.error').remove();
}
function fnunder() {
	alert('Under Construction');
}
// Redirect to Mail Status View Page
function mailview(mailid){
	pageload();
	$('#mailid').val(mailid);
	$('#mailstatus').attr('action', '../Mail/mailview'+'?mainmenu=menu_mail&time='+datetime);
	$("#mailstatus").submit();
}
// Mail Status Fliter
function fnmailfilter(filval){
	pageload();
	$('#plimit').val('');
	$('#page').val('');
	$('#filval').val(filval);
	$('#mailstatus').attr('action', '../Mail/index'+'?mainmenu=menu_mail&time='+datetime);
	$("#mailstatus").submit();
}
// To Mail Status Index Back
function fnredirectmailstatus() {
	pageload();
	$('#mailView').attr('action', '../Mail/index'+'?mainmenu=menu_mail&time='+datetime); 
	$("#mailView").submit();
}
// Mail Content Fliter
function fnfilter(filterval) {
	pageload();
	$('#filvalhdn').val(filterval);
	$('#singlesearch').val('');
	$('#searchmethod').val('');
	$('#mailcontentindx').attr('action', '../Mail/mailcontent'+'?mainmenu=menu_mail&time='+datetime);
	$("#mailcontentindx").submit();
}
// Redirect to Mail Content View Page
function fncontentview(mailId) {
	pageload();
	$('#mailid').val(mailId);
	$('#mailcontentindx').attr('action', '../Mail/mailcontentview'+'?mainmenu=menu_mail&time='+datetime);
	$("#mailcontentindx").submit();
}
// Mail Content Sorting
$(function () {
	var cc = 0;
	$('#mailcontentsort').click(function () {
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
	var sortselect = $('#mailcontentsort').val();
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
	$("#mailcontentindx").submit();
}
// Mail Content Single Search
function fnSingleSearch() {
	var singlesearchtxt = $("#singlesearch").val();
	var singlesearchtxt = document.getElementById('singlesearch').value;
	if (singlesearchtxt == "") {
		alert("Please Enter The User Search.");
		$("#singlesearch").focus(); 
		return false;
	} else {
		pageload();
		$('#plimit').val(50);
		$('#page').val('');
		$('#filvalhdn').val('');
		$('#searchmethod').val('1');
		$("#mailcontentindx").submit();
	}
}
// Enter ker Search process in Mail Content Index page
function checkSubmitsingle(e) {
	if(e && e.keyCode == 13) {
		fnSingleSearch();
	}
}
// Mail Content Clear Search
function clearsearch() {
	$('#plimit').val(50);
	$('#page').val('');
	$("#filvalhdn").val('');
	$('#mailcontentsort').val('');
	$('#sortOrder').val('desc'); 
	$('#singlesearch').val('');
	$("#mailcontentindx").submit();
}
// Change Use or Not Use Flag in Mail Content
function fndelflg(flg,mailid) {
	swal({
		title: msg_flagchange,
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		closeOnConfirm: true,
		closeOnCancel: true
	},
	function(isConfirm) {
		if (isConfirm) {
			pageload();
			$('#delflg').val(flg);
			$('#mailid').val(mailid);
			$('#mailcontentindx').attr('action', '../Mail/mailcontentflg'+'?mainmenu=menu_mail&time='+datetime);
			$("#mailcontentindx").submit();
		} else {
			return false;
		}
	});
}
// Go To Mail Content Register page
function fnContentRegister(regsisterval) {
	pageload();
	$('#mailid').val('');
	$('#mailcontentreg').val(regsisterval);
	$('#mailcontentindx').attr('action', '../Mail/mailContentreg'+'?mainmenu=menu_mail&time='+datetime);
	$("#mailcontentindx").submit();
}
// To Mail Content Index Back
function fnback() {
	pageload();
	$('#mailcontentView').attr('action', '../Mail/mailcontent'+'?mainmenu=menu_mail&time='+datetime);
	$("#mailcontentView").submit();
}
// Go To Mail Content Edit Page
function gotoeditpage(mailid){
	pageload();
	$('#mailid').val(mailid);
	$('#mailcontentView').attr('action', '../Mail/mailContentreg'+'?mainmenu=menu_mail&time='+datetime);
	$("#mailcontentView").submit();
}
//  Mail Content Add Edit Cancel
function fngotoback() {
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
				if ($('#mailid').val() != "") {
					$('#mail_reg').attr('action', '../Mail/mailcontentview'+'?mainmenu=menu_mail&time='+datetime); 
					$("#mail_reg").submit();
				} else {
					$('#mail_reg').attr('action', '../Mail/mailcontent'+'?mainmenu=menu_mail&time='+datetime); 
					$("#mail_reg").submit();
				}
			} else {
				return false;
			}
		});
	} else {
		pageload();
		if ($('#mailid').val() != "") {
			$('#mail_reg').attr('action', '../Mail/mailcontentview'+'?mainmenu=menu_mail&time='+datetime); 
			$("#mail_reg").submit();
		} else {
			$('#mail_reg').attr('action', '../Mail/mailcontent'+'?mainmenu=menu_mail&time='+datetime); 
			$("#mail_reg").submit();
		}
	}
}