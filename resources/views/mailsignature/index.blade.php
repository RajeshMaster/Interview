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
</script>
<div class="" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="mail" class="DEC_flex_wrapper" data-category="mail mail_sub_2">
	</article>
</div>
@endsection

