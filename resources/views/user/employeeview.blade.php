@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/user.js')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
<style type="text/css">
	.textDecNone:hover {
		text-decoration: none !important;
		color: white !important;
	}
</style>
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
</script>
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="userlist" class="DEC_flex_wrapper" data-category="userlist userlist_sub_1">
	<fieldset class="headerbg mt20">
		{{ Form::open(array('name'=>'employeeview',
								'id'=>'employeeview',
								'url' => '', 
								'method' => 'POST',
								'files'=>true)) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/list.png')  }}">
			<h2 class="h2cnt">
				{{ trans('messages.lbl_userlistview')}}
			</h2>
		</div>
	</fieldset>
	<fieldset class="bordernone">
		<div class="col-xs-12 mt5 mb5 mwhead" style="padding: 0px !important;">
			<div class="col-xs-12 pull-left mt10 mb10" style="padding: 0px !important;">
				<a href="javascript:fnredirectback();" class="button button-blue textDecNone">
					<span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}
				</a>
			</div>
			<div class="col-xs-9 pull-left pm0" style="padding: 0px !important;">
				@if (session('danger'))
					<div class="alert1" align="center">
						<div>
							<span class="alert-danger ml250">{{ session('danger') }}</span>
						</div>
					</div>
				@endif
				@if (session('message'))
					<div class="alert1" align="center">
						<div >
							<span class="alert-success ml250">{{ session('message') }}</span>
						</div>
					</div>
				@endif
			</div>
		</div>
	</fieldset>
	@php $i = 0; @endphp
	@foreach($mailView as $mailkey => $mailvalue)
	<fieldset class="mb5">
		<div class="col-xs-9 mt10">
			<div class="col-xs-4 lb text-right">
				<label class="clr_blue">
					{{ trans('messages.lbl_userid')}}
				</label>
			</div>
			<div class="col-xs-8 mw clr_black">
				@if(isset($empDtls[$i][$mailvalue->empId]['Emp_ID']))
					{{ $empDtls[$i][$mailvalue->empId]['Emp_ID'] }}
				@else
					{{ trans('messages.lbl_nil') }}
				@endif
			</div>
		</div>
		<div class="col-xs-9 mt10">
			<div class="col-xs-4 lb text-right pm0">
				<label class="clr_blue">{{ trans('messages.lbl_surname')}}</label>
			</div>
			<div class="col-xs-8 mw clr_black">
				@if(isset($empDtls[$i][$mailvalue->empId]['FirstName']))
					{{ empnamelength($empDtls[$i][$mailvalue->empId]['FirstName'],30) }}
				@else
					{{ trans('messages.lbl_nil') }}
				@endif
			</div>
		</div>
		<div class="col-xs-9 mt10">
			<div class="col-xs-4 lb text-right pm0">
				<label class="clr_blue">{{ trans('messages.lbl_givenname')}}</label>
			</div>
			<div class="col-xs-8 mw pm0 clr_black">
				@if(isset($empDtls[$i][$mailvalue->empId]['LastName']))
					{{ empnamelength($empDtls[$i][$mailvalue->empId]['LastName'],30) }}
				@else
					{{ trans('messages.lbl_nil') }}
				@endif
			</div>
		</div>
	</fieldset>
	@php $i++; @endphp
	@endforeach
</article>
</div>
@endsection