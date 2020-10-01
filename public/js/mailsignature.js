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
function gotoeditpage(){
	alert('Under Construction');
}
function fngotoregister(){
	alert('Under Construction');
}