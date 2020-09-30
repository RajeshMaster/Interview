@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/assets.js')) }}
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
		subothers();
	});
</script>

<div class="" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="balsheet" class="DEC_flex_wrapper" data-category="balsheet balsheet_sub_2">
		@if($detedit != "")
			{{ Form::model($detedit, array('name'=>'AssetsAddEdit','id'=>'AssetsAddEdit', 
						'files'=>true, 'method' => 'POST',
						'class'=>'form-horizontal',
						'url' => 'Assets/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis') ) ) }}
			{{ Form::hidden('editpage','editpage', array('id' => 'editpage')) }}
			{{ Form::hidden('editChk',$request->editChk, array('id' => 'editChk')) }}
			{{ Form::hidden('assetsId',$detedit[0]->id, array('id' => 'assetsId')) }}
			{{ Form::hidden('belongsTo', $detedit[0]->belongsTo , array('id' => 'belongsTo')) }}
			{{ Form::hidden('edMonth', $detedit[0]->Month , array('id' => 'edMonth')) }}
		@else
			{{ Form::open(array('name'=>'AssetsAddEdit', 'id'=>'AssetsAddEdit', 
							'class' => 'form-horizontal',
							'files'=>true,
							'url' => 'Assets/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
							'method' => 'POST')) }}
			{{ csrf_field() }}
		@endif
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('userId', $request->userId , array('id' => 'userId')) }}
	<fieldset class="pm0 mt20">
		<div class="header">
			<img class="headerimg box40 mr10 imgviewheight" src="{{ URL::asset('public/images/loan.png')  }}">
			<h2 class="h2cnt">{{ trans('messages.lbl_assets') }}</h2>
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
				<label class="clr_black">{{ trans('messages.lbl_belongsTo')}}</label>
				<span class="fr ml2 fs7"> * </span>
			</div>
			<div class="col-xs-9">
				{{ Form::select('belongsTo', [null=>''] + $familyMembersarray,(isset($detedit[0]->belongsTo)) ? $detedit[0]->belongsTo : '',
					array('class' => 'form-control box20per',
							'id' => 'belongsTo',
							'name' => 'belongsTo',
							'style' => 'display:inline-block',
							'data-label' => trans('messages.lbl_belongsTo'))) }}
			</div>
		</div>
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb text-right pm0">
				<label class="clr_black">{{ trans('messages.lbl_house')}}</label>
				<span class="fr ml2 fs7"> * </span>
			</div>
			<div class="col-xs-9">
				{{ Form::select('houseId', [null=>''] + $houseNamearray,null,
					array('class' => 'form-control box20per',
							'id' => 'houseId',
							'name' => 'houseId',
							'onchange'=>'javascript:checkmonth();',
							'data-label' => trans('messages.lbl_house'))) }}
			</div>
		</div>
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb text-right pm0">
				<label class="clr_black">
					{{ trans('messages.lbl_year')}} & {{ trans('messages.lbl_date')}}
				</label>
				<span class="fr ml2 fs7"> * </span>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::select('yearSelect', [null=>''] + $yeararray,(isset($detedit[0]->Year)) ? $detedit[0]->Year : '',
					array('class' => 'form-control box10per',
							'id' => 'yearSelect',
							'name' => 'yearSelect',
							'onchange'=>'javascript:checkmonth();',
							'style' => 'display:inline-block',
							'data-label' => trans('messages.lbl_year'))) }}
				{{ Form::select('dateSelect', [null=>''] + $datearray,(isset($detedit[0]->Date)) ? $detedit[0]->Date : '',
					array('class' => 'form-control box9per ml5',
							'id' => 'dateSelect',
							'name' => 'dateSelect',
							'style' => 'display:inline-block',
							'data-label' => trans('messages.lbl_date'))) }}
			</div>
		</div>
		<div class="col-md-12 mt10">
			@if($request->editChk == "1")
				<?php $monthSplit = array();
				$monthArray = array();
				$monthSplit = explode(",", $detedit[0]->Month);
				for ($k=0;$k<count($monthSplit);$k++) {
					if ($monthSplit[$k] == 99) {
						$monthSplit[$k] = 13;
					}
					$monthArray[$monthSplit[$k]] = $monthSplit[$k];
				} ?>
			@endif
			<label for="months" class="col-md-3 text-right  ml4 control-label">
				{{ trans('messages.lbl_months') }}
				<span class="fr ml3 fs7"> * </span>
			</label>
			<div class="col-md-8">
				@for($i=1;$i<=13;$i++)
					@if(isset($monthArray[$i]))
						@if ($i == $monthArray[$i]) 
							{{--*/ $checkedStr = "1"; /*--}}
						@else
							{{--*/ $checkedStr = ""; /*--}}
						@endif
					@else
						{{--*/ $checkedStr = ""; /*--}}
					@endif	
					@if(isset($arrayNotEditOthers[$i]))
						@if ($i==$arrayNotEditOthers[$i])
							{{--*/ $disabled = "1"; /*--}}
						@else
							{{--*/ $disabled = ""; /*--}}
						@endif
					@else
						{{--*/ $disabled = ""; /*--}}
					@endif	
					{{--*/ $id = "month".$i; /*--}}
					<input type="checkbox"  
						@if ($checkedStr=="1") checked="checked" @endif
						@if ($disabled=="1") disabled="disabled" @endif
						onchange="return AllCheck(this.value);" name="month[]" id="month<?php echo $i?>" style="vertical-align:middle;" value="<?php if ($i!=13) echo $i; else echo 99;?>">
					<label for="{{$id}}" style="vertical-align: middle;font-weight: normal;margin-top: 10px;">
						@if($i != 13)
							{{ $i."月" }}
						@else
							{{ "ALL" }}
						@endif
					</label>
					<input type="hidden" name="mnth<?php echo $i?>" id="mnth<?php echo $i?>"
							value = "<?php if ($disabled == 1) echo 1; else echo 2;?>">
				@endfor
				<div id="monthlbl" class="mt10 pull-right" style="display: none;color: red;">
					<label>{{ "The Months Field is required." }}</label>
				</div>
			</div>
		</div>
		<div class="col-xs-12 mt20">
			<div class="col-xs-3 lb text-right pm0">
				<label class="clr_black">{{ trans('messages.lbl_amount')}}</label>
				<span class="fr ml2 fs7"> * </span>
			</div>
			<div class="col-xs-9 mw">
				<span class="pull-left">
				{{ Form::text('assetsAmount',null,array('id'=>'assetsAmount',
														 'name' => 'assetsAmount',
														 'maxlength'=>'11',
														 'autocomplete' => 'off',
														 'onkeypress' => 'return isNumberKey(event)',
														 'onkeyup'=>'return fnMoneyFormat(this.id,"jp")',
														 'class'=>'tar form-control box97per',
														 'data-label' => trans('messages.lbl_amount'))) }}
				</span>
				<span>
					<label class="mt7 box10per">万</label>
				</span>
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
					<button type="submit" class="button button-orange addeditprocess">
						<i class="fa fa-edit"></i>&nbsp;{{ trans('messages.lbl_update') }}
					</button>
					&emsp;
					<a href="javascript:assetsCancel();" class="button button-red textDecNone">
						<span class="fa fa-remove"></span> {{ trans('messages.lbl_cancel') }}
					</a>
				@else
					<button type="submit" class="button button-green addeditprocess">
						<i class="fa fa-plus"></i>&nbsp;{{ trans('messages.lbl_register')}}
					</button>
					&emsp;
					<a href="javascript:assetsCancel();" class="button button-red textDecNone">
						<span class="fa fa-remove"></span> {{ trans('messages.lbl_cancel') }}
					</a>
				@endif
				
			</div>
		</div>
	</fieldset>
	{{ Form::close() }}
	{{ Form::open(array('name'=>'AssetsAddEditcancel',
					'id'=>'AssetsAddEditcancel', 
					'url' => 'Assets/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
					'files'=>true,'method' => 'POST')) }}
	{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
	{{ Form::hidden('userId', $request->userId , array('id' => 'userId')) }}
	{{ Form::close() }}
	<script type="text/javascript">
		var cancel_check = true;
		$('input, select, textarea').bind("change keyup paste", function() {
			cancel_check = false;
		});
	</script>
</article>
</div>
@endsection