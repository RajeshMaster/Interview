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
// Redirect to Mail Content View Page
function fncontentview(mailId) {
	pageload();
	$('#mailid').val(mailId);
	$('#mailcontentindx').attr('action', '../Mail/mailContentView'+'?mainmenu=menu_mail&time='+datetime);
	$("#mailcontentindx").submit();
}
// To Mail Content Index Back
function fnback() {
	pageload();
	$('#mailcontentView').attr('action', '../Mail/index'+'?mainmenu=menu_mail&time='+datetime);
	$("#mailcontentView").submit();
}

function fngotoregister(){
	pageload();
	$('#editflg').val('2');
	$('#mailcontentindx').attr('action','addedit'+'?mainmenu='+mainmenu+'&time='+datetime); 
    $("#mailcontentindx").submit();
}