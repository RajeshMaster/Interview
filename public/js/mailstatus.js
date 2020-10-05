function filtermail(sendfilter) {
	pageload();
	$('#sendfilter').val(sendfilter);
	$('#page').val('');
	$('#plimit').val('');
	$('#mailstatusindx').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
	$("#mailstatusindx").submit();
}
function fnstatusView(id) {
	pageload();
	$('#statusid').val(id);
	$('#mailstatusindx').attr('action', 'mailStatusView?mainmenu='+mainmenu+'&time='+datetime);
	$("#mailstatusindx").submit();
}
// To Mail Content Index Back
function fnback() {
	pageload();
	$('#mailStatusView').attr('action', '../MailStatus/index'+'?mainmenu=menu_mail&time='+datetime);
	$("#mailStatusView").submit();
}