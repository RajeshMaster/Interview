@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/setting.js')) }}
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
	function underconst() {
		alert("Under Construction");
	}
</script>
<div class="" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="settings" class="DEC_flex_wrapper" data-category="settings setting_sub_1">
	<fieldset class="mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" style="padding-left: 0px!important;" src="{{ URL::asset('public/images/setting.png')  }}">
			<h2 class="h2cnt">
				{{ trans('messages.lbl_settings')}}
			</h2>
		</div>
	</fieldset>
	{{ Form::open(array('name'=>'indexform', 'id'=>'indexform', 'url' => 'setting/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST')) }}
		<fieldset class="mt10 mb20">
			<div class="box100per pr10 pt35 pl10">
			  	<div id="divPopup" class="color popup_position"></div>
				<div class="box50per pull-left table">
					<div class="box80per pull-left">
						<div class="col-xs-12 fwb headlbl headlbl1 settingdesign">
							<div class="mt3 designtab" style="padding-left: 15px;">{{ trans('messages.lbl_userdesignation') }}</div>
						</div>
						<div class="pull-left mt10 mb10 box100per">
							<span  class="col-xs-10 ml30 lbldessetcat settingsubdesignfamily">
								@php
									$tbl_name = 'sysdesignationtypes';
								@endphp
							 	<a name="mainCategory" style="color: #33AFFF !important;" 
							 	id="mainCategory" href="javascript:settingpopupsinglefield('twotextpopup',
	        				'{{ $tbl_name}}','')">{{ trans('messages.lbl_userdesignation') }}</a>
							</span>
						</div>
					</div>
					<div class="box80per pull-left mt40">
						<div class="col-xs-12 fwb headlbl headlbl1 settingdesign">
							<div class="mt3" style="padding-left: 15px;">{{ trans('messages.lbl_Unfixed_reason') }}</div>
						</div>
						<div class="pull-left mt10 mb10 box100per">
							<span  class="col-xs-10 ml30 lbldessetcat settingsubdesignfamily">
								@php
									$tbl_name = 'sysunfixedreason';
								@endphp
								<a name="family" style="color:#33AFFF !important;" id="family" href="javascript:settingpopupsinglefield('singletextpopup','{{ $tbl_name }}','');">{{ trans('messages.lbl_Unfixed_reason') }}</a>
							</span>
						</div>
					</div>
					<div class="box80per pull-left mt40">
						<div class="col-xs-12 fwb headlbl headlbl1 settingdesign">
							<div class="mt3" style="padding-left: 15px;">{{ trans('messages.lbl_skills') }}</div>
						</div>
						<div class="pull-left mt10 mb10 box100per">
							<span  class="col-xs-10 ml30 lbldessetcat settingsubdesignfamily">
								@php
									$tbl_name = 'emp_roletypes';
								@endphp
								<a name="assets" style="color:#33AFFF !important;" id="assets" 
								href="javascript:settingpopupsinglefield('twotextpopup',
	        				'{{ $tbl_name}}','');">{{ trans('messages.lbl_roletype') }}</a>
							</span>
							<span  class="col-xs-10 ml30 mt5 lbldessetcat settingsubdesignfamily">
								@php
									$tbl_name = 'emp_sysostypes';
								@endphp
								<a name="assets" style="color:#33AFFF !important;" id="assets" 
								href="javascript:settingpopupsinglefield('singletextpopup',
	        				'{{ $tbl_name}}','');">{{ trans('messages.lbl_sysostypes') }}</a>
							</span>
							<span  class="col-xs-10 ml30 mt5 lbldessetcat settingsubdesignfamily">
								@php
									$tbl_name = 'emp_sysprogramlangtypes';
								@endphp
								<a name="assets" style="color:#33AFFF !important;" id="assets" 
								href="javascript:settingpopupsinglefield('singletextpopup',
	        				'{{ $tbl_name}}','');">{{ trans('messages.lbl_sysprogramlangtypes') }}</a>
							</span>
							<span  class="col-xs-10 ml30 mt5 lbldessetcat settingsubdesignfamily">
								@php
									$tbl_name = 'emp_sysdbtypes';
								@endphp
								<a name="assets" style="color:#33AFFF !important;" id="assets" 
								href="javascript:settingpopupsinglefield('singletextpopup',
	        				'{{ $tbl_name}}','');">{{ trans('messages.lbl_sysdbtypes') }}</a>
							</span>
							<span  class="col-xs-10 ml30 mt5 lbldessetcat settingsubdesignfamily">
								@php
									$tbl_name = 'emp_systooltypes';
								@endphp
								<a name="assets" style="color:#33AFFF !important;" id="assets" 
								href="javascript:settingpopupsinglefield('singletextpopup',
	        				'{{ $tbl_name}}','');">{{ trans('messages.lbl_systooltypes') }}</a>
							</span>
							<span  class="col-xs-10 ml30 mt5 lbldessetcat settingsubdesignfamily">
								@php
									$tbl_name = 'emp_sysguitypes';
								@endphp
								<a name="assets" style="color:#33AFFF !important;" id="assets" 
								href="javascript:settingpopupsinglefield('singletextpopup',
	        				'{{ $tbl_name}}','');">{{ trans('messages.lbl_sysguitypes') }}</a>
							</span>
							<span  class="col-xs-10 ml30 mt5 lbldessetcat settingsubdesignfamily">
								@php
									$tbl_name = 'emp_syswebservertypes';
								@endphp
								<a name="assets" style="color:#33AFFF !important;" id="assets" 
								href="javascript:settingpopupsinglefield('singletextpopup',
	        				'{{ $tbl_name}}','');">{{ trans('messages.lbl_syswebservertypes') }}</a>
							</span>
							<span  class="col-xs-10 ml30 mt5 lbldessetcat settingsubdesignfamily">
								@php
									$tbl_name = 'emp_sysmiddlewaretypes';
								@endphp
								<a name="assets" style="color:#33AFFF !important;" id="assets" 
								href="javascript:settingpopupsinglefield('singletextpopup',
	        				'{{ $tbl_name}}','');">{{ trans('messages.lbl_sysmiddlewaretypes') }}</a>
							</span>
							<span  class="col-xs-10 ml30 mt5 lbldessetcat settingsubdesignfamily">
								@php
									$tbl_name = 'emp_syswebtooltypes';
								@endphp
								<a name="assets" style="color:#33AFFF !important;" id="assets" 
								href="javascript:settingpopupsinglefield('singletextpopup',
	        				'{{ $tbl_name}}','');">{{ trans('messages.lbl_syswebtooltypes') }}</a>
							</span>
						</div>
					</div>
					<div class="box80per pull-left mt190">
					</div>
				</div>
				<div class="box50per pull-left buildingalign">
					<div class="box80per pull-left">
						<div class="col-xs-12 fwb headlbl headlbl2 settingdesignright">
							<div class="mt3" style="padding-left: 15px;">{{ trans('messages.lbl_group') }}</div>
						</div>
						<div class="pull-left mt10 mb10 box100per">
							<span  class="col-xs-10 ml30 mt5 lbldesset settingsubdesignright">
								@php
									$tbl_name = 'ams_master_buildingname';
								@endphp
							 	<a name="houseName" style="color: #33AFFF !important;" 
						 		id="houseName" href="javascript:groupselectpopup();">{{ trans('messages.lbl_group') }}</a>
							</span>
						</div>
					</div>
					<div class="box80per pull-left mt10">
						<div class="col-xs-12 fwb headlbl headlbl2 settingdesignright">
							<div class="mt3" style="padding-left: 15px;">
								{{ trans('Requirment Setting') }}
							</div>
						</div>
						<div class="pull-left mt10 mb10 box100per">
							<span  class="col-xs-10 mt5 ml30 mb10 lbldesset settingsubdesignright">
								@php
									$tbl_name = 'ams_bankname_master';
								@endphp
								<a name="bank" id="bank" style="color:#33AFFF !important;" href="javascript:underconst();">{{ trans('Requirment Setting') }}</a></span>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
		<div id="grouppop" class="modal fade" style="width: 775px;">
			<div id="login-overlay">
				<div class="modal-content">
					<!-- Popup will be loaded here -->
				</div>
			</div>
		</div>
		<div id="showpopup" class="modal fade" style="width: 775px;">
			<div id="login-overlay">
				<div class="modal-content">
					<!-- Popup will be loaded here -->
				</div>
			</div>
		</div>
	{{ Form::close() }}
	</article>
</div>
@endsection