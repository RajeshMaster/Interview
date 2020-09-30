@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/lib/jquery.ui.autocomplete.css')) }}
{{ HTML::script(asset('public/js/lib/jquery-ui.min.js')) }}
{{ HTML::script(asset('public/js/otherassets.js')) }}
{{ HTML::script(asset('public/js/lib/bootstrap-datepicker.min.js')) }}
{{ HTML::style(asset('public/css/lib/bootstrap-datetimepicker.min.css')) }}
<style type="text/css">
	.pm0{padding: 0px;margin: 0px;}
	/* Set height of the grid so .sidenav can be 100% (adjust if needed) */
	.row.content {height: 500px}
	/* Set gray background color and 100% height */
	.sidenav {
		background-color: #fcfcfc;
		height: auto;
		min-height: 100%;
		border-radius: 3px;
		border: 1px solid #DDDDDD;
	}
	/* Set black background color, white text and some padding */
	footer {
		background-color: #555;
		color: white;
		padding: 15px;
	}
	/* On small screens, set height to 'auto' for sidenav and grid */
/*	@media screen and (max-width: 767px) {
		.sidenav {
			height: auto;
			padding: 15px;
		}
		.row.content {height: auto;} 
	}*/
	.disabled {
		cursor: none;
		pointer-events: none;
		color: black;
		text-decoration: none;
	}
	.rowdiv{
		margin-right:-45px;
		margin-left:-29px;
	}

	.textDecNone:hover {
		text-decoration: none !important;
		color: white !important;
	}
</style>
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	$(document).ready(function() {
		setDatePicker("registerDate");
	});
</script>

<div class="" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="balsheet" class="DEC_flex_wrapper" data-category="balsheet balsheet_sub_3">
		@if($detedit != "")
			{{ Form::model($detedit, array('name'=>'OtherAssetsAddEdit','id'=>'OtherAssetsAddEdit', 
						'files'=>true, 'method' => 'POST',
						'class'=>'form-horizontal',
						'url' => 'OtherAssets/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis') ) ) }}
			{{ Form::hidden('editpage','editpage', array('id' => 'editpage')) }}
			{{ Form::hidden('editChk',$request->editChk, array('id' => 'editChk')) }}
			{{ Form::hidden('otherAssetsId',$detedit[0]->id, array('id' => 'otherAssetsId')) }}
		@else
			{{ Form::open(array('name'=>'OtherAssetsAddEdit', 'id'=>'OtherAssetsAddEdit', 
							'class' => 'form-horizontal',
							'files'=>true,
							'url' => 'OtherAssets/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
							'method' => 'POST')) }}
			{{ csrf_field() }}
		@endif
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('userId', $request->userId , array('id' => 'userId')) }}
		{{ Form::hidden('filval', $request->filval , array('id' => 'filval')) }}
	<fieldset class="pm0 mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/loan.png')  }}">
			<h2 class="h2cnt">{{ trans('messages.lbl_otherassets') }}</h2>
			<h2 class="pull-left h2cnt">・</h2> 
			@if($detedit != "")
				<h2 class="pull-left h2cnt" style="color:red;">
					{{ trans('messages.lbl_edit') }}
				</h2>
			@else
				<h2 class="pull-left h2cnt" style="color:green;">
					{{ trans('messages.lbl_register') }}
				</h2>
			@endif
		</div>
	</fieldset>
	@if(Session::has('error'))
		<div class="alert-box success" style="text-align: center;color: red;">
			{{ Session::get('error') }}
		</div>
	@endif
	<fieldset class="mt10">
		<div class="col-xs-12 mt20">
			<div class="col-xs-3 lb text-right pm0">
				<label class="clr_black">{{ trans('messages.lbl_date')}}</label>
				<span class="fr ml2 fs7"> * </span>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('registerDate',null,array('id'=>'registerDate', 
												'name' => 'registerDate','maxlength' => 10,
												'autocomplete' => 'off',
												'onKeyPress'=>'return event.charCode >= 48 && event.charCode <= 57',
												'class'=>'ime_mode_disable form-control box13per dispinline registerDate'.$disableddate,
												'data-label' => trans('messages.lbl_date'))) }}
				<label class="mt10 ml2 fa fa-calendar fa-lg" for="registerDate" aria-hidden="true"></label>
				<div class="registerDate_err dispinline"></div>
			</div>
		</div>
		<div class="col-xs-12 mt20">
			<div class="col-xs-3 lb text-right pm0">
				<label class="clr_black">{{ trans('messages.lbl_assets')}}</label>
				<span class="fr ml2 fs7"> * </span>
			</div>
			<div class="col-xs-9">
				{{ Form::select('assetId', [null=>''] + $assetsTypesarray,null,
					array('class' => 'form-control box25per assetId dispinline',
							'id' => 'assetId',
							'name' => 'assetId',
							'data-label' => trans('messages.lbl_assets'))) }}
				<div class="assetId_err dispinline"></div>
			</div>
		</div>
		<div class="col-xs-12 mt20">
			<div class="col-xs-3 lb text-right pm0">
				<label class="clr_black">{{ trans('messages.lbl_belongsTo')}}</label>
				<span class="fr ml2 fs7"> * </span>
			</div>
			<div class="col-xs-9">
				{{ Form::select('belongsTo', [null=>''] + $familyMembersarray,null,
					array('class' => 'form-control box25per belongsTo dispinline',
							'id' => 'belongsTo',
							'name' => 'belongsTo',
							'data-label' => trans('messages.lbl_belongsTo'))) }}
				<div class="belongsTo_err dispinline"></div>
			</div>
		</div>
		<div class="col-xs-12 mt20">
			<div class="col-xs-3 lb text-right pm0">
				<label class="clr_black">{{ trans('messages.lbl_main')}}</label>
				<span class="fr ml2 fs7"> * </span>
			</div>
			<div class="col-xs-9">
				{{ Form::text('mainSubject',isset($detedit[0]->mainSubject)?$detedit[0]->mainSubject:"",array('id'=>'mainSubject',
								'name' => 'mainSubject',
								'maxlength' => '100',
								'class'=>'box25per form-control mainSubject dispinline',
								'data-label' => trans('messages.lbl_main'))) }}
				<div class="mainSubject_err dispinline"></div>
			</div>
		</div>
		<div class="col-xs-12 mt20">
			<div class="col-xs-3 lb text-right pm0">
				<label class="clr_black">{{ trans('messages.lbl_amount')}}</label>
				<span class="fr ml2 fs7"> * </span>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('otherAssetsAmount',null,array('id'=>'otherAssetsAmount',
														 'name' => 'otherAssetsAmount',
														 'maxlength'=>'11',
														 'autocomplete' => 'off',
														 'onkeypress' => 'return isFloatNumberKey(event)',
														 'class'=>'tar form-control box25per otherAssetsAmount dispinline',
														 'data-label' => trans('messages.lbl_amount'))) }}
				<label class="ml3 mt7">万</label>
				<div class="otherAssetsAmount_err dispinline"></div>
			</div>
		</div>
		<div class="col-xs-12 mt20 mb20">
			<div class="col-xs-3 lb text-right pm0">
				<label class="clr_black">{{ trans('messages.lbl_remarks')}}</label>
				<span class="fr ml12 fs7"></span>
			</div>
			<div class="col-xs-9">
				{{ Form::textarea('remarks',isset($detedit[0]->remarks)?$detedit[0]->remarks:"",array('id'=>'remarks',
								'name' => 'remarks',
								'maxlength' => '100',
								'class'=>'box25per form-control remarks dispinline textareaResizeNone',
								'size' => '20x4',
								'data-label' => trans('messages.lbl_remarks'))) }}
				<div class="remarks_err dispinline"></div>
			</div>
		</div>
	</fieldset>
	<fieldset class="mt10 footerbg" >
		<div class="col-xs-12 mb10 mt10">
			<div class="col-xs-12" style="text-align: center;">
				@if($request->editChk == "1")
					<button type="button" class="button button-orange otherAssetsRegister">
						<i class="fa fa-edit"></i>&nbsp;{{ trans('messages.lbl_update') }}
					</button>
					&emsp;
					<a href="javascript:otherAssetsCancel();" class="button button-red textDecNone">
						<span class="fa fa-remove"></span> {{ trans('messages.lbl_cancel') }}
					</a>
				@else
					<button type="button" class="button button-green otherAssetsRegister">
						<i class="fa fa-plus"></i>&nbsp;{{ trans('messages.lbl_register')}}
					</button>
					&emsp;
					<a href="javascript:otherAssetsCancel();" class="button button-red textDecNone">
						<span class="fa fa-remove"></span> {{ trans('messages.lbl_cancel') }}
					</a>
				@endif
				
			</div>
		</div>
	</fieldset>
	<script type="text/javascript">
		$(document).ready(function() {
			srcmain = "{{ route('autoCompletemain') }}";
			srcremarks = "{{ route('autoCompleteremarks') }}";
			$("#mainSubject").autocomplete({
				source: function(request,response) {
					$.ajax({
						url: srcmain,
						dataType: "json",
						data: {
							term : request.term
						},
						success: function(data) {
							response(data);
						}, error :  function(data) {
							// alert(data.status);
							// alert("There Was Problem in this ajax");
						}
					});
				}
			});
			$("#remarks").autocomplete({
				source: function(request,response) {
					$.ajax({
						url: srcremarks,
						dataType: "json",
						data: {
							term : request.term
						},
						success: function(data) {
							response(data);
						}, error :  function(data) {
							// alert(data.status);
							// alert("There Was Problem in this ajax");
						}
					});
				}
			});
			//Script for Cancel Check//
			var cancel_check = true;
			$('input, select, textarea').bind("change keyup paste", function() {
				cancel_check = false;
			});
		});
	</script>
	{{ Form::close() }}
</article>
</div>
@endsection