{{ HTML::style(asset('public/css/settinglayout.css')) }}
<style>
	.highlight { background-color: #428eab !important; }
	#dwnArrow,#upArrow {
	text-decoration:none;
	font-size:22px;
	color:#bbb5b5;
	box-shadow: none;
	background-color: Transparent;
	border: none; 
	padding: 0px;
  }
  @media all and (max-width: 1200px) {
  .messagedisplay{
	font-size: 80%;
	margin-top:3%!important;
	margin-bottom:-6%!important;
	margin-left:11%!important;
  }
  .designchange{
	margin-right:4%!important;
  }
}
</style>

<script type="text/javascript">

</script>
{{ Form::open(array('name'=>'uploadpopup', 'id'=>'uploadpopup',
					  'url' => 'MailSend/uploadVideoProcess?time='.date('YmdHis'),
					  'files'=>true,
					  'method' => 'POST')) }}
{{ Form::hidden('mainmenu', $request->mainmenu, array('id' => 'mainmenu')) }}
{{ Form::hidden('empId', $request->empId, array('id' => 'empId')) }}
{{ Form::hidden('Lastname', $request->Lastname, array('id' => 'Lastname')) }}
{{ Form::hidden('Kananame', $request->Kananame, array('id' => 'Kananame')) }}
{{ Form::hidden('embedLink', null, array('id' => 'embedLink')) }}

<div class="popupstyle popupsize">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" style="color: red;" aria-hidden="true"  onclick="videostop()">&#10006;</button>
			<h3 class="modal-title custom_align"><B>{{ trans('messages.lbl_upVideo') }}</B></h3>
		</div>

		<div class="mt10">
			<center>
			<iframe width="570" height="315" src="{{$url}}" id="iframevideo"></iframe>
			</center>
		</div>
	  </div>
</div>
   <script>
	$('.footable').footable({
	  calculateWidthOverride: function() {
		return { width: $(window).width() };
	  }
	}); 
  </script>