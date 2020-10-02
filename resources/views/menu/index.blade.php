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
</script>
<div class="" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="home" class="DEC_flex_wrapper" data-category="home home_sub_1">
	{{ Form::open(array('name'=>'indexform', 'id'=>'indexform', 'url' => 'Setting/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'method' => 'POST')) }}
		<fieldset class="mt15 mb20">
			<div class="box100per pr10 pt35 pl10">
			  	<div id="divPopup" class="color popup_position"></div>
				<div class="box50per pull-left table">
					<div class="box80per pull-left">
						<div class="col-xs-12 fwb headlbl headlbl1 settingdesign">
							<div class="mt3 designtab" style="padding-left: 15px;">{{ trans('messages.lbl_employee') }}</div>
						</div>
						<div class="pull-left mt10 mb10 box100per">
							<span  class="col-xs-10 ml30 lbldessetcat settingsubdesignfamily">
							 	<a name="mainCategory" style="color: #33AFFF !important;" 
							 	id="mainCategory" class="pageload" href="{{ url('Employee/index?mainmenu=menu_employee&time='.date('Ymdhis')) }}">{{ trans('messages.lbl_employee') }}</a>
							</span>
							<span  class="col-xs-10 ml30 mt5 lbldessetcat settingsubdesignfamily">
								<a name="subCategory" style="color: #33AFFF !important;" 
								id="subCategory" href="">{{ trans('messages.lbl_nonEmployee') }}</a>
							</span>
							<span  class="col-xs-10 ml30 mt5 lbldessetcat settingsubdesignfamily">
								<a name="subCategory" style="color: #33AFFF !important;" 
								id="subCategory" href="">{{ trans('messages.lbl_emphistory') }}</a>
							</span>
						</div>
					</div>
					<div class="box80per pull-left mt40">
						<div class="col-xs-12 fwb headlbl headlbl1 settingdesign">
							<div class="mt3" style="padding-left: 15px;">{{ trans('messages.lbl_mail') }}</div>
						</div>
						<div class="pull-left mt10 mb10 box100per">
							<span  class="col-xs-10 ml30 lbldessetcat settingsubdesignfamily">
								<a name="family" style="color:#33AFFF !important;" id="family" href="">{{ trans('messages.lbl_mailstatus') }}</a>
							</span>
							<span  class="col-xs-10 ml30 mt5 lbldessetcat settingsubdesignfamily">
								<a name="family" style="color:#33AFFF !important;" id="family" href="{{ url('Mail/index?mainmenu=menu_mail&time='.date('Ymdhis')) }}">{{ trans('messages.lbl_mailcontent') }}</a>
							</span>
							<span  class="col-xs-10 ml30 mt5 lbldessetcat settingsubdesignfamily">
								<a name="family" style="color:#33AFFF !important;" id="family" href="{{ url('MailSignature/index?mainmenu=menu_mailsignature&time='.date('Ymdhis')) }}">{{ trans('messages.lbl_mailsignature') }}</a>
							</span>
						</div>
					</div>
					<div class="box80per pull-left mt40">
					</div>
					<div class="box80per pull-left mt190">
					</div>
				</div>
				<div class="box50per pull-left buildingalign">
					<div class="box80per pull-left">
						<div class="col-xs-12 fwb headlbl headlbl2 settingdesignright">
							<div class="mt3" style="padding-left: 15px;">{{ trans('messages.lbl_customer') }}</div>
						</div>
						<div class="pull-left mt10 mb10 box100per">
							<span  class="col-xs-10 ml30 mt5 lbldesset settingsubdesignright">
							 	<a name="houseName" style="color: #33AFFF !important;" 
						 		id="houseName" href="">{{ trans('messages.lbl_customer') }}</a>
							</span>
							<span  class="col-xs-10 mt5 ml30 lbldesset settingsubdesignright">
								<a name="houseImg" id="houseImg" style="color:#33AFFF !important;" href="">{{ trans('messages.lbl_agent') }}</a>
							</span>
							<span  class="col-xs-10 mt5 ml30 lbldesset settingsubdesignright">
								<a name="houseImg" id="houseImg" style="color:#33AFFF !important;" href="">{{ trans('messages.lbl_old_customer') }}</a>
							</span>
						</div>
					</div>
					<div class="box80per pull-left mt35">
						<div class="col-xs-12 fwb headlbl headlbl2 settingdesignright">
							<div class="mt3" style="padding-left: 15px;">
								{{ trans('messages.lbl_settings') }}
							</div>
						</div>
						<div class="pull-left mt10 mb10 box100per">
							<span  class="col-xs-10 mt5 ml30 lbldesset settingsubdesignright">
								<a name="bank" id="bank" style="color:#33AFFF !important;" href="{{ url('setting/index?mainmenu=menu_setting&time='.date('Ymdhis')) }}">{{ trans('messages.lbl_settings') }}</a>
							</span>
							<span  class="col-xs-10 mt5 ml30 lbldesset settingsubdesignright">
								<a name="bank" id="bank" style="color:#33AFFF !important;" href="{{ url('user/index?mainmenu=menu_user&time='.date('Ymdhis')) }}">{{ trans('messages.lbl_user') }}</a>
							</span>
							<span  class="col-xs-10 mt5 ml30 lbldesset settingsubdesignright">
								<a name="bank" id="bank" style="color:#33AFFF !important;" href="">{{ trans('messages.lbl_ourdetails') }}</a>
							</span>
							<span  class="col-xs-10 mt5 ml30 mb10 lbldesset settingsubdesignright">
								<a name="bank" id="bank" style="color:#33AFFF !important;" href="">{{ trans('messages.lbl_japanese_skills') }}</a>
							</span>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
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