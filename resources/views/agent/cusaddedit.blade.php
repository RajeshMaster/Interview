@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::style(asset('public/css/footable.core.css')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::script(asset('public/js/footable.js')) }}
{{ HTML::script(asset('public/js/agent.js')) }}
{{ HTML::script(asset('public/js/lib/bootstrap-datepicker.min.js')) }}
{{ HTML::style(asset('public/css/lib/bootstrap-datetimepicker.min.css')) }}
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
	$(document).ready(function() {
    	setDatePicker("txt_custagreement");
  	});
</script>
<style type="text/css">
	.selectboxprop{
		height: 280px !important ;width: 180px;
	}
	@media all and (max-width: 1200px) {
		.selectboxprop{
		height: 280px;width: 180px;
		}
	}
	@media all and (max-width: 500px) {
		.selectboxprop{
		height: 280px;width: 90px;
		}
	}

</style>
<div class="" id="main_contents">
	<article id="customer" class="DEC_flex_wrapper" data-category="customer cus_sub_2">
		@if($request->cuseditflg == 'edit')
			{{ Form::model($SingleAgent, array(
								'name'=>'frmcusreg', 'id'=>'frmcusreg', 
								'files'=>true,'type'=>'file',
								'method' => 'POST','class'=>'form-horizontal',
								'url' => 'Agent/cusaddeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis') 
							))}}
		@else
			{{ Form::open(array(
							'name'=>'frmcusreg','id'=>'frmcusreg',
							'files'=>true,'method' => 'POST',
							'url' => 'Agent/cusaddeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis')
							))}}
			{{ Form::hidden('groupId', '' , array('id' => 'groupId')) }}
		@endif
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('agentId', $request->agentId , array('id' => 'agentId')) }}
		{{ Form::hidden('cuseditflg', $request->cuseditflg , array('id' => 'cuseditflg')) }}

		<fieldset class="mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/Client.png')  }}">
				<h2 class="pull-left h2cnt">{{trans('messages.lbl_customer')}}</h2>
				<h2 class="pull-left h2cnt">&#9642;</h2>
				@if($request->editflg == 'edit')
					<h2 class="pull-left mt10 green">{{ trans('messages.lbl_edit') }}</h2>
				@else
					<h2 class="pull-left mt10 red">{{ trans('messages.lbl_edit') }}</h2>
				@endif
			</div>
		</fieldset> 
		<fieldset class="mt10 mb10">
			<!-- Session msg -->
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black">
						{{ trans('messages.lbl_agentname(kana)')}}
					</label><span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-9 dispinline pmo pl10" style="color: brown;">
					@if(isset($SingleAgent[0]))
						{{ $SingleAgent[0]->txt_agentName }}
					@endif
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black">
						{{ trans('messages.lbl_custname')}}
					</label><span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-9 pm0 dispinline pl10">
					<table class="main mr10 pm0 dispinline">
						<tr>
							<td valign="top" style="border: none;">
								<div class="pm0">
									<select multiple size="15" id="from" name="removed[]" class="to border selectboxprop">
										@if($customerName != "")
											@foreach($customerName as $key =>$data)
												<option value="{{ $data->customer_id }}">
													{{ $data->customer_name }}
												</option>
											@endforeach
										@endif
									</select>
								</div>
							</td>
							<td style="border: none;">
								<div class="controls CMN_display_block ml10 mt10"> 
									<a style="text-decoration:none!important;" onclick="listbox_moveacross('from', 'to','to','selected')">&gt;</a><br>
									<a style="text-decoration:none!important;" onclick="listbox_moveacross('to','from','to','selected')">&lt;</a> 
								</div>
							</td>
							<td style="border: none;">
								<div class="ml5 dispinline">
									<select multiple size="15" id="to" name="selected[]" class="dispinline to border selectboxprop">
										@if($customerSelectedMembers != "")
											@foreach($customerSelectedMembers as $key =>$data)
												<option value="{{ $data->customer_id }}">
													{{ $data->customer_name }}
												</option>
											@endforeach
										@endif
									</select>
									<div id="errorSectiondisplay" align="center" class="box100per"></div>
								</div>
							</td>
							{{ Form::hidden('selected', $customerValue , array('id' => 'selected')) }}
						</tr>
					</table>
				</div>
			</div>
	</fieldset>
		<fieldset class="bg_footer_clr">
		<div class="form-group mt15">
			<div align="center" class="mt5">
				@if($request->cuseditflg == 'edit')
					<button type="button" class="btn btn-warning add box100 cusaddeditprocess">
						<i class="fa fa-edit ml7"></i>
						{{ trans('messages.lbl_update') }}
					</button>
				@else
					<button type="button" class="btn btn-success add box100 cusaddeditprocess">
						<i class="fa fa-plus ml7"></i>
						{{ trans('messages.lbl_register') }}
					</button>
				@endif
				<a onclick="javascript:gotoindexpage('1');" class="btn btn-danger box100 white">
					<i class="fa fa-times" aria-hidden="true"></i> {{trans('messages.lbl_cancel')}}
				</a>
			</div>
		</div>
	</fieldset>
		{{ Form::close() }}
		{{ Form::open(array('name'=>'frmagentaddeditcancel', 'id'=>'frmagentaddeditcancel', 
		'url' => '','files'=>true,'method' => 'POST')) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
		{{ Form::hidden('agentId',(isset($request->agentId)?$request->agentId:""),array('id' => 'agentId')) }}
{{ Form::close() }}
	</article>
</div>
@endsection