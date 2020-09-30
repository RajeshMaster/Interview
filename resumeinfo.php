<form class="form-horizontal" role="form" name="urlfrm" id="urlfrm" method="patch" 
				action="toshow?rkey=<?php echo $_GET['rkey']; ?>&time=<?php echo date('YmdHis'); ?>">
	<input type="hidden" name="rkey" id="rkey" value="<?php echo $_GET['rkey']; ?>">
</form>
<script type="text/javascript">
		document.urlfrm.submit();
</script>