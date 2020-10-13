@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::style(asset('public/css/footable.core.css')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::script(asset('public/js/footable.js')) }}
{{ HTML::script(asset('public/js/customer.js')) }}
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
	/*Start Mobile layout*/
	@media all and (max-width: 1200px) {
		.regdes{
			width:128%!important;
		}
		.h2cnt {
			font-size: 150%!important;
			margin-top: 3%!important;
		}
		.buttondes {
			font-size: 80%!important;
		}
		.col-xs-3 {
			 width:50%;
			 font-size:80%;
			 margin-left:-10%;
		}
		.col-xs-9 {
			width:50%;
		}
		.dispMainMobile {
			width:100%;
		}
		.dispSubMobile {
			width:100%;
		}
	}
	/*End Mobile layout*/
	@media all and (min-width:1205px) {
		.dispMainMobile {
			width:50%;
		}
		.dispSubMobile {
			width:48%;
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
		<fieldset id="hdnfield" class="mt10 mb50">
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_agentname(JP&Eng)')}}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-9 mw">
		            @if(isset($SingleAgent[0]))
						{{ $SingleAgent[0]->txt_agentName }}
					@endif
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_custname')}}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-9 mw" style="display: flex;">
		           <select multiple size="15" id="from" name="removed[]" class="ime_mode_disable txt dispinline form-control firstname regdes" style="height: 280px; width: 100%;">
										@if($customerName != "")
											@foreach($customerName as $key =>$data)
												<option value="{{ $data->customer_id }}">
													{{ $data->customer_name }}
												</option>
											@endforeach
										@endif
					</select>
					<div class="controls CMN_display_block ml10 mt10"> 
									<a style="text-decoration:none!important;" onclick="listbox_moveacross('from', 'to','to','selected')">&gt;</a><br>
									<a style="text-decoration:none!important;" onclick="listbox_moveacross('to','from','to','selected')">&lt;</a> 
								</div>
					<select multiple size="15" id="to" name="selected[]" class="ime_mode_disable txt dispinline form-control firstname regdes" style="height: 280px; width: 100%;">
										@if($customerSelectedMembers != "")
											@foreach($customerSelectedMembers as $key =>$data)
												<option value="{{ $data->customer_id }}">
													{{ $data->customer_name }}
												</option>
											@endforeach
										@endif
									</select>
						
				</div>
			</div>
		</fieldset>
		{{ Form::close() }}
	</article>
</div>
@endsection