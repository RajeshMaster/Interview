<form class="form-horizontal" role="form" name="frmjaplist" id="frmjaplist" method="patch" 
				action="Japanese/index?time=<?php echo date('YmdHis'); ?>">
	<input type="hidden" name="time" id="time" value="<?php echo date('YmdHis'); ?>">
</form>
<script type="text/javascript">
	document.frmjaplist.submit();
</script>