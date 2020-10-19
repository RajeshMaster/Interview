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
			<button type="button" class="close" data-dismiss="modal" style="color: red;" aria-hidden="true">&#10006;</button>
			<h3 class="modal-title custom_align"><B>{{ trans('messages.lbl_upVideo') }}</B></h3>
		</div>

		<div class="mt10" >
			<fieldset style="width: 96%;" class="ml14">
				<div class="box25per pull-left text-right clr_blue fwb mt10 mb10 ml10 h50">
					{{ trans('messages.lbl_url') }}
					<span style="color:red;"> * </span>
				</div>
				<div class="ml15 pull-left box70per mb10 mt10">
					<!-- {{ Form::file('pdffile',array('id'=>'pdffile','name' => 'pdffile',
						'data-label' => trans('messages.lbl_uploadfile'),
						'accept' => 'application/pdf',
						'height' =>'30px',
						'class'=>'box70per')) }}
					(Upload .pdf Format only) -->

					{{ Form::text('urlLink',"",array('id'=>'urlLink', 'name' => 'urlLink',
						'data-label' => trans('messages.lbl_url'),
						'class'=>'box50per form-control pl5')) }} 
						<span>(Upload YouTube Link Format only)</span>
				</div>
			</fieldset>
		</div>
		<div class="modal-footer bg-info mt10">
			<center>
				<a class="btn btn-success CMN_display_block box100" style="text-decoration:none;" href="javascript:fnUploadVideo()"><i class="fa fa-plus" aria-hidden="true"></i>
					{{ trans('messages.lbl_upload') }}</a>
				<button data-dismiss="modal" onclick="divUploadvideopopupclose();;" class="btn btn-danger CMN_display_block box100">
				<i class="fa fa-times" aria-hidden="true"></i>
					{{ trans('messages.lbl_cancel') }}
				</button>
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