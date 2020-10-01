@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/settinglayout.css')) }}
<style type="text/css">
	/* Start Laptop screen Setting index page design */
@media all and (min-width:1205px) {
	.settingdesign{
		margin-left: 15%!important;
	}
	.settingsubdesignfamily{
		margin-left: 21%!important;
	}
	.settingdesignright{
		margin-left: 7%!important;
	}
	.settingsubdesignright{
		margin-left: 13%!important;
	}
}
/*End Laptop screen Setting index page design */
</style>
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
	function pageClick(pageval) {
		$('#page').val(pageval);
		$("#mailsignaturefrm").submit();
	}
	function pageLimitClick(pagelimitval) {
		$('#page').val('');
		$('#plimit').val(pagelimitval);
		$("#mailsignaturefrm").submit();
	}
</script>
{{ Form::open(array('name'=>'mailsignaturefrm',
		'id'=>'mailsignaturefrm',
		'url' => 'MailSignature/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
		'method' => 'POST')) }}
<div class="" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="mail" class="DEC_flex_wrapper" data-category="mail mail_sub_2">
		<!-- Start Heading -->
		<fieldset class="pm0 mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/signature.png')  }}">
				<h2 class="pull-left pl5 mt10">{{ trans('messages.lbl_mailsignature') }}</h2>
				</h2>
			</div>
		</fieldset>
		<!-- End Heading -->
		<!-- Session msg Start-->
		@if(Session::has('success'))
			<div align="center" class="alertboxalign" role="alert">
				<p class="alert {{ Session::get('alert', Session::get('type') ) }}">
				{{ Session::get('success') }}
				</p>
			</div>
		@endif
		@if(Session::has('danger'))
			<div align="center" class="alertboxalign" role="alert">
				<p class="alert {{ Session::get('alert', Session::get('type') ) }}">
				{{ Session::get('danger') }}
				</p>
			</div>
		@endif
		@php Session::forget('success'); @endphp
		@php Session::forget('danger'); @endphp
		<!-- Session msg End-->
	</article>
</div>
@endsection

