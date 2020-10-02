function pageClick(pageval) {
	$('#page').val(pageval);
	$("#mailsignaturefrm").submit();
}
function pageLimitClick(pagelimitval) {
	$('#page').val('');
	$('#plimit').val(pagelimitval);
	$("#mailsignaturefrm").submit();
}
function fnfilter(filterval){
	pageload();
	$('#filvalhdn').val(filterval);
	$('#mailsignaturefrm').attr('action', '../MailSignature/index'+'?mainmenu=menu_mailsignature&time='+datetime);
	$("#mailsignaturefrm").submit();
}
var data = {};
$(document).ready(function(){
	$('.mailSignatureRegister').on('click', function() {
		resetErrors();
		var url ='mailSignatureRegValidation';
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
					if($('#editflg').val() == 1) {
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
								$('#mailSignatureReg').attr('action', 'mailSignatureAddEditProcess'+'?menuid=menu_mail&time='+datetime);
								$("#mailSignatureReg").submit();
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
								$('#mailSignatureReg').attr('action', 'mailSignatureAddEditProcess'+'?menuid=menu_mail&time='+datetime);
								$("#mailSignatureReg").submit();
							} else {
								$("#addedit").attr("disabled", false);
							}
						});
					}
				}else{
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
function resetErrors() {
	$('form input, form select, form radio, form textarea').css("border-color", "");
	$('form input').removeClass('inputTxtError');
	$('label.error').remove();
}
// Change Use or Not Use Flag in Mail Content
function fndelflg(flg,id) {
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
			$('#signatureId').val(id);
			$('#mailsignaturefrm').attr('action', '../MailSignature/mailSignatureFlg'+'?mainmenu=menu_mailsignature&time='+datetime);
			$("#mailsignaturefrm").submit();
		} else {
			return false;
		}
	});
}
function gotosignview(id){
	pageload();
	$('#signatureId').val(id);
	$('#mailsignaturefrm').attr('action', '../MailSignature/mailSignatureView'+'?mainmenu=menu_mailsignature&time='+datetime);
	$("#mailsignaturefrm").submit();
}

// To Mail Content Index Back
function fnback() {
	pageload();
	$('#mailSignatureView').attr('action', '../MailSignature/index'+'?mainmenu=menu_mail&time='+datetime);
	$("#mailSignatureView").submit();
}
function gotoeditpage(sigId){
	$('#editflg').val(1);
	$('#signatureId').val(sigId);
	$('#mailSignatureView').attr('action', '../MailSignature/mailSignatureAddEdit'+'?mainmenu=menu_mail&time='+datetime);
	$("#mailSignatureView").submit();
}
function fngotoregister(){
	pageload();
	$('#editflg').val(2);
	$('#mailsignaturefrm').attr('action','mailSignatureAddEdit'+'?mainmenu='+mainmenu+'&time='+datetime); 
    $("#mailsignaturefrm").submit();
}
function popupenable(mainmenu) {
	$('#mailsignaturepopup').load('../MailSignature/mailSignaturePopup?mainmenu='+mainmenu+'&time='+datetime);
	$("#mailsignaturepopup").modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#mailsignaturepopup').modal('show');
}
function fndbclick(userid,uname,givennm,nicknm) {
	var name = uname.concat(" ").concat(givennm).concat(" ").concat(nicknm);
	$('#txtuserid').val(name);
	$('#userid').val(userid);
	$.ajax({
		type: 'GET',
		url: 'getDataExist',
		dataType: "json",
		data: {"userid": userid},
		success: function(resp) {
			if (resp!="") {
				$('#content').val(resp.content);
				$('#edithead').show();
				$('#updatebtn').show();
				$('#updatecancel').show();
				$('#updateprocess').val(2);
				$('#editflg').val(1);
				$('#reghead').hide();
				$('#regbtn').hide();
			} else {
				$('#content').val('');
				$('#updateprocess').val('');
				$('#editflg').val(2);
				$('#edithead').hide();
				$('#updatebtn').hide();
				$('#updatecancel').hide();
				$('#reghead').show();
				$('#regbtn').show();
			}
		},
		error: function(data) {
			alert(data);
		}
	});
	$('#mailsignaturepopup').modal('toggle');
}
function fngetData(userid,uname,givennm,nicknm) {
	var name = uname.concat(" ").concat(givennm).concat(" ").concat(nicknm);
	$("#"+userid).prop("checked", true);
	$('#txtuserid').val(name);
	$('#userid').val(userid);
}
function fnselect() {
	var txtuserid=$('#txtuserid').val();
	var userid=$('#userid').val();
	$('#txtuserid').val(txtuserid);
	$('#userid').val(userid);
	$.ajax({
		type: 'GET',
		url: 'getDataExist',
		dataType: "json",
		data: {"userid": userid},
		success: function(resp) {
			if (resp!="") {
				$('#content').val(resp.content);
				$('#edithead').show();
				$('#updatebtn').show();
				$('#updateprocess').val(2);
				$('#editflg').val(1);
				$('#reghead').hide();
				$('#regbtn').hide();
			} else {
				$('#content').val('');
				$('#updateprocess').val('');
				$('#editflg').val(2);
				$('#edithead').hide();
				$('#updatebtn').hide();
				$('#reghead').show();
				$('#regbtn').show();
			}
		},
		error: function(data) {
			alert(data);
		}
	});
	$('#mailsignaturepopup').modal('toggle');
}
