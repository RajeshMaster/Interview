@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/user.js')) }}
<style type="text/css">
	.estStatusDIV_New_1 {
		color: #a1a1a1;
		text-align: center;
		-moz-border-radius: 2;
		-webkit-border-radius: 3px;
		font-size: 10px;
		margin-top: 3px;
		letter-spacing: .025em;
		font-family: verdana;
		text-transform: lowercase;
		font-weight: bold;
	}
	.colred {
		color: red;
	}
	/* Start Laptop screen Setting index page design */


	@media all and (max-width: 1200px) {
		.h2cnt {
			font-size: 150%!important;
			margin-top: 3%!important;
		}
		
		.col-xs-3 {
			 width:50%;
			 font-size:80%;
			 margin-left:-10%;
		}
		.col-xs-9 {
			width:50%;
		}
		
		.firstpre{
			width: 30%;
		}
	}
	/*End Mobile layout*/

	@media all and (min-width:1205px) {
		.firstpre{
			width: 10%;
		}
	}

	/*End Laptop screen Setting index page design */
</style>
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
</script>
	{{ Form::open(array('name'=>'frmourdetailindex', 'id'=>'frmourdetailindex', 'url' => 'Ourdetail/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,'method' => 'POST')) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('editflg', '', array('id' => 'editflg')) }}
		{{ Form::hidden('id', '', array('id' => 'id')) }}
		{{ Form::hidden('balid', '', array('id' => 'balid')) }}
		{{ Form::hidden('editid', '' , array('id' => 'editid')) }}

<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
	<article id="settings" class="DEC_flex_wrapper" data-category="settings setting_sub_3">

		<fieldset class="pm0 mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/ourdetails.png')  }}">
				<h2 class="h2cnt">{{ trans('messages.lbl_ourdetails') }}</h2>
			</div>
		</fieldset>

		@if(Session::has('success'))
			<div align="center" class="alertboxalign" role="alert">
				<p class="alert {{ Session::get('alert', Session::get('type') ) }}">
				{{ Session::get('success') }}
				</p>
			</div>
		@endif
		@php Session::forget('success'); @endphp

		<fieldset class="mt10">
			<div class="col-xs-12 mt10">
				<div class="col-xs-4 lb tar">
					<label>{{ trans('messages.lbl_companyname') }}</label>
				</div>
				<div class="col-xs-8 mw" style="word-wrap: break-word;">
					{{ $result[0]->CompanyName }}
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-4 lb tar">
					<label>{{ trans('messages.lbl_companynamekana') }}</label>
				</div>
				<div class="col-xs-8 mw" style="word-wrap: break-word;">
					{{ $result[0]->CompanyNamekana }}
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-4  tar">
					{{ trans('messages.lbl_postalservice') }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ $result[0]->pincode }}
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-4  tar">
					<label class="">{{ trans('messages.lbl_perfecturename') }}</label>
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ $result[0]->Prefecturename }}
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-4 tar">
					{{ trans('messages.lbl_address') }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ $result[0]->Streetaddress }}
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-4 tar">
					{{ trans('messages.lbl_buildingname') }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ $result[0]->BuildingName }}
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-4 tar">
					{{ trans('messages.lbl_tel') }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ $result[0]->TEL }}
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-4 tar">
					{{ trans('messages.lbl_fax') }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ $result[0]->FAX }}
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-4 tar">
					{{ trans('messages.lbl_commonmail') }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ $result[0]->Commonmail }}
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-4 tar">
					Url
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ $result[0]->URL }}
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-4 tar">
					{{ trans('messages.lbl_establisheddate') }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ $result[0]->Establisheddate }}
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-4 tar">
					{{ trans('messages.lbl_closingdate') }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ $result[0]->Closingmonth }} Mn

					{{ $result[0]->Closingdate }} Day
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-4 tar">
					{{ trans('messages.lbl_accountperiod') }}
				</div>
				<div class="col-xs-8 mw clr_black">
					@if(isset($kessan[0]->Accountperiod))
						{{ $kessan[0]->Accountperiod }} Day
					@else
						NIL
					@endif
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-4 tar">
					{{ trans('messages.lbl_period') }}
				</div>
				<div class="col-xs-8 mw clr_black">
					@if(isset($kessan[0]->Startingyear))
						{{ $kessan[0]->Startingyear }} .
						{{ $kessan[0]->Startingmonth }}&nbsp;&nbsp;~&nbsp;&nbsp;
						{{ $kessan[0]->Closingyear }} .
						{{ $kessan[0]->Closingmonth }}
					@else
						NIL
					@endif
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-4 tar">
					{{ trans('messages.lbl_systemname') }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ $result[0]->systemname }}
				</div>
			</div>

		</fieldset>
		{{ Form::close() }}
	</article>
</div>
@endsection