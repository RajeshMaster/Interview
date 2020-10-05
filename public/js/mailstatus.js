function filtermail(sendfilter) {
	pageload();
	$('#sendfilter').val(sendfilter);
	$('#page').val('');
	$('#plimit').val('');
	$('#mailstatusindx').attr('action', 'index?mainmenu='+mainmenu+'&time='+datetime);
	$("#mailstatusindx").submit();
}