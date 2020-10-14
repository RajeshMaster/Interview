@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/agent.js')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::script(asset('public/js/yubinbango.js')) }}
{{ HTML::script(asset('public/js/lib/bootstrap-datepicker.min.js')) }}
{{ HTML::style(asset('public/css/lib/bootstrap-datetimepicker.min.css')) }}
<style type="text/css">
	/*Start Mobile layout*/
	@media all and (max-width: 1200px) {
		.regdes{
			width:100%!important;
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
		.col-xs-3 {
			width:50%;
			font-size:100%;
			margin-left:-10%;
		}
		.col-xs-9 {
			width:50%;
		}
	}
</style>
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
	$(document).ready(function() {
    	setDatePicker("txt_agentContract");
  	});
</script>
<div class="" id="main_contents">
	<article id="customer" class="DEC_flex_wrapper" data-category="customer cus_sub_2">
		@if(!empty($getSingleAgent))
			{{ Form::model($getSingleAgent,
				array('name'=>'frmagentaddedit','method' => 'POST', 'id'=>'frmagentaddedit', 
						'class'=>'form-horizontal h-adr',
						'url' => 'Agent/AgentAddeditProcess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis')))
			}}
			{{ Form::hidden('id', $request->id , array('id' => 'id')) }}
			{{ Form::hidden('agentId',$request->agentId,array('id' => 'agentId')) }}
		@else
			{{ Form::open(array('name'=>'frmagentaddedit', 'id'=>'frmagentaddedit', 
					'class' => 'form-horizontal h-adr',
					'method' => 'POST','files'=>true,
					'url' => 'Agent/AgentAddeditProcess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'))) 
			}}
		{{ Form::hidden('id', '' , array('id' => 'id')) }}
		{{ Form::hidden('agentId','',array('id' => 'agentId')) }}
		@endif     
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('editflg', $request->editflg, array('id' => 'editflg')) }}
		{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
		<fieldset class="mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/Client.png')  }}">
				<h2 class="pull-left h2cnt">{{trans('messages.lbl_agent')}}</h2>
				<h2 class="pull-left h2cnt">&#9642;</h2>
				@if ($request->editflg!="edit")
					<h2 class="pull-left mt10 green">{{ trans('messages.lbl_register') }}</h2>
				@else
					<h2 class="pull-left mt10 red">{{ trans('messages.lbl_edit') }}</h2>
				@endif
			</div>
		</fieldset>
		<fieldset class="mt10 pull-left dispMainMobile">
			@if(!empty($getSingleAgent))
				<div class="col-xs-12 mt20">
					<div class="col-xs-3 lb text-right pm0">
						<label class="clr_black">{{ trans('messages.lbl_agentId') }}</label>
						<span class="fr ml2 fs7" style="visibility: hidden;"> * </span>
					</div>
					<div class="col-xs-9 mw">
		               	{{$request->agentId}} 
					</div>
				</div>
			@endif
			<div class="col-xs-12 mt20">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black">{{ trans('messages.lbl_agentname(JP&Eng)') }}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-7 mw">
	               	{{ Form::text('txt_agentName',(isset($getSingleAgent[0])) ? $getSingleAgent[0]->txt_agentName : '',array(
						'id'=>'txt_agentName',
						'name' => 'txt_agentName',
						'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
						'style'=> 'width:240px;',
						'data-label' => trans('messages.lbl_agentname(JP&Eng)'))) }}
				</div>
			</div>
			<div class="col-xs-12 mt20">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black">{{ trans('messages.lbl_agentname(kana)') }}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-7 mw">
	               	{{ Form::text('txt_agentNameJp',(isset($getSingleAgent[0])) ? $getSingleAgent[0]->txt_agentNameJp : '',array(
						'id'=>'txt_agentNameJp',
						'name' => 'txt_agentNameJp',
						'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
						'style'=> 'width:240px;',
						'data-label' => trans('messages.lbl_agentname(kana)'))) }}
				</div>
			</div>
			<div class="col-xs-12 mt20">
				<span class="p-country-name" style="display:none;">Japan</span>
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black">{{ trans('messages.lbl_postalCode') }}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-7 mw">
	               	{{ Form::text('txt_postal',(isset($getSingleAgent[0]->postalNumber)) ? $getSingleAgent[0]->postalNumber : '',array(
						'id'=>'txt_postal',
						'name' => 'txt_postal',
						'class'=>'ime_mode_disable txt dispinline form-control firstname regdes p-postal-code',
						'style'=> 'width:240px;',
						'maxlength' => '8',
						'onkeypress' => 'return isNumberKeywithminus(event)',
						'onkeyup' => 'addHyphen(this)',
						'data-label' => trans('messages.lbl_postalCode') )) }}
				</div>
			</div>
			<div class="col-xs-12 mt20">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black">{{ trans('messages.lbl_kenmei') }}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-7 mw">
	               	{{ Form::select('kenmei',[null=>'Please select'] + $getKenname,(isset($getSingleAgent[0]->kenmei)) ? $getSingleAgent[0]->kenmei : '',array('class'=>'ime_mode_disable txt dispinline form-control firstname regdes p-region-id',
						'style'=> 'width:240px;',
					'id' =>'kenmei','data-label' => trans('messages.lbl_kenmei'),'name' => 'kenmei')) }}
				</div>
			</div>
			<div class="col-xs-12 mt20">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black">{{ trans('messages.lbl_shimei') }}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-7 mw">
	               	{{ Form::text('txt_shimei',(isset($getSingleAgent[0]->shimei)) ? $getSingleAgent[0]->shimei : '',array(
						'id'=>'txt_shimei',
						'name' => 'txt_shimei',
						'class'=>'ime_mode_disable txt dispinline form-control firstname regdes p-locality',
						'style'=> 'width:240px;',
						'data-label' => trans('messages.lbl_shimei'))) }}
				</div>
			</div>
			<div class="col-xs-12 mt20">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black">{{ trans('messages.lbl_streetaddress') }}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-7 mw">
	               	{{ Form::text('txt_streetaddress',(isset($getSingleAgent[0]->street_address)) ? $getSingleAgent[0]->street_address : '',array(
						'id'=>'txt_streetaddress',
						'name' => 'txt_streetaddress',
						'class'=>'ime_mode_disable txt dispinline form-control firstname regdes p-street-address',
						'style'=> 'width:240px;',
						'data-label' => trans('messages.lbl_streetaddress'))) }}
				</div>
			</div>
			<div class="col-xs-12 mt20">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black">{{ trans('messages.lbl_buildingname') }}</label>
					<span class="fr ml2 fs7" style="visibility: hidden;"> * </span>
				</div>
				<div class="col-xs-7 mw">
	               	{{ Form::text('txt_buildingname',(isset($getSingleAgent[0]->buildingname)) ? $getSingleAgent[0]->buildingname : '',array(
						'id'=>'txt_buildingname',
						'name' => 'txt_buildingname',
						'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
						'style'=> 'width:240px;',
						'data-label' => trans('messages.lbl_txt_buildingname'))) }}
				</div>
			</div>
			<div class="col-xs-12 mt20 mb10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black">{{ trans('messages.lbl_remarks') }}</label>
					<span class="fr ml2 fs7" style="visibility: hidden;"> * </span>
				</div>
				<div class="col-xs-7 mw">
	               	{{ Form::textarea('txt_address',(isset($getSingleAgent[0])) ? $getSingleAgent[0]->txt_address : '',array(
					'id'=>'txt_address',
					'name' => 'txt_address',
				 	'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
	                'style' =>'width:240px;height:70px;',
					'data-label' => trans('messages.lbl_address'))) }}
				</div>
			</div>
		</fieldset>
		<fieldset class="mt10 pull-right dispSubMobile">
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label>{{ trans('messages.lbl_agentagreement') }}<span class="fr ml2 red"> * </span></label>
				</div>
				<div class="col-xs-7 mw">
					{{ Form::text('txt_agentContract',(isset($getSingleAgent[0])) ? $getSingleAgent[0]->txt_agentContract : '',array(
							'id'=>'txt_agentContract',
							'name' => 'txt_agentContract',
							'class'=>'ime_mode_disable txt dispinline form-control firstname regdes txt_agentContract',
							'style'=> 'width:110px;',
							'data-label' => trans('messages.lbl_agentagreement'),
							'onkeypress'=>'return event.charCode >=6 && event.charCode <=58',
							'autocomplete' =>'off',
							'maxlength' => '10')) }}
							<label class="mt10 ml2 fa fa-calendar fa-lg" for="txt_agentContract" aria-hidden="true"></label>
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label>{{ trans('messages.lbl_email') }}<span class="fr ml2 red"> * </span></label>
				</div>
				<div class="col-xs-7 mw">
					{{ Form::text('txt_emailId',(isset($getSingleAgent[0])) ? $getSingleAgent[0]->txt_emailId : '',array(
						'id'=>'txt_emailId',
						'name' => 'txt_emailId',
						'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
						'style'=> 'width:240px;',
						'data-label' => trans('messages.lbl_email'))) }}
						<div id="errorSectiondisplay" align="center"></div>
				</div>

			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label>{{ trans('messages.lbl_mobilenumber') }}<span class="fr ml2 red"> * </span></label>
				</div>
				<div class="col-xs-7 mw">
					{{ Form::text('txt_mobilenumber',(isset($getSingleAgent[0])) ? $getSingleAgent[0]->txt_mobilenumber : '',array(
						'id'=>'txt_mobilenumber',
						'name' => 'txt_mobilenumber',
						'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
						'style'=> 'width:240px;',
						'maxlength' => 13,
						'data-label' => trans('messages.lbl_mobilenumber'),
						'onkeypress' => 'return isNumberKeywithminus(event)')) }}
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label>{{ trans('messages.lbl_fax') }}<span class="fr ml2 red" style="visibility: hidden;"> * </span></label>
				</div>
				<div class="col-xs-7 mw">
					{{ Form::text('txt_fax',(isset($getSingleAgent[0])) ? $getSingleAgent[0]->txt_fax : '',array(
						'id'=>'txt_fax',
						'name' => 'txt_fax',
						'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
						'style'=> 'width:240px;',
						'maxlength' => 13,
						'data-label' => trans('messages.lbl_fax'),
						'onkeypress' => 'return isNumberKeywithminus(event)')) }}
				</div>
			</div>
			<div class="col-xs-12 mt10 mb10">
				<div class="col-xs-3 lb text-right pm0">
					<label>{{ trans('messages.lbl_url') }}<span class="fr ml2 red" style="visibility: hidden;"> * </span></label>
				</div>
				<div class="col-xs-7 mw">
					{{ Form::text('txt_url',(isset($getSingleAgent[0])) ? $getSingleAgent[0]->txt_url : '',array(
					'id'=>'txt_url',
					'name' => 'txt_url',
					'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
					'style'=> 'width:240px;',
					'data-label' => trans('messages.lbl_url'))) }}
				</div>
			</div>
		</fieldset>
		<div style="margin-top: -5px;">
            <fieldset class="mt10 footerbg pull-left box100per">
                <div class="form-group">
                    <div align="center" class="mt5">
                       @if($request->editflg == "edit")
                        <button type="button" class="btn edit btn-warning box100 addeditprocess" >
							<i class="fa fa-edit" aria-hidden="true"></i> {{ trans('messages.lbl_update') }}
						</button>
						<a onclick="javascript:gotoindexpage('1');" 
							class="btn btn-danger box120 white">
							<i class="fa fa-times" aria-hidden="true"></i> 
							{{ trans('messages.lbl_cancel') }} 
						</a>
                        @else
                           <button type="button" class="btn btn-success add box100 addeditprocess ml5">
								<i class="fa fa-plus" aria-hidden="true"></i> 
								{{ trans('messages.lbl_register') }}
							</button>
							<a onclick="javascript:gotoindexpage('2');" 
								class="btn btn-danger box120 white">
								<i class="fa fa-times" aria-hidden="true"></i> 
								{{ trans('messages.lbl_cancel') }} 
							</a>
                        @endif  
                    </div>
                </div>
            </fieldset>
        </div>
	</article>
</div>
{{ Form::close() }}
{{ Form::open(array('name'=>'frmagentaddeditcancel', 'id'=>'frmagentaddeditcancel', 
		'url' => '','files'=>true,'method' => 'POST')) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
		{{ Form::hidden('agentId',(isset($request->agentId)?$request->agentId:""),array('id' => 'agentId')) }}
{{ Form::close() }}
@endsection