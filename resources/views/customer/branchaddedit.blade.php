@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/lib/bootstrap-datepicker.min.js')) }}
{{ HTML::style(asset('public/css/lib/bootstrap-datetimepicker.min.css')) }}
{{ HTML::script(asset('public/js/customer.js')) }}
{{ HTML::script(asset('public/js/yubinbango.js')) }}
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
<div class="" id="main_contents">
	<article id="customer" class="DEC_flex_wrapper" data-category="customer cus_sub_1">
		@if(!empty($bdetails))
	        {{ Form::model($bdetails,array('name'=>'frmbranchaddedit','method' => 'POST',
	                                         'class'=>'form-horizontal h-adr',
	                                         'id'=>'frmbranchaddedit', 
	                                         'url' => 'Customer/Branchaddeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'))) }}
	            {{ Form::hidden('editid', $request->editid, array('id' => 'editid')) }}
    	@else
	        {{ Form::open(array('name'=>'frmbranchaddedit', 'id'=>'frmbranchaddedit', 
	                            'class' => 'form-horizontal h-adr',
	                            'files'=>true,
	                            'url' => 'Customer/Branchaddeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
	                            'method' => 'POST')) }}
	            {{ Form::hidden('editid', '', array('id' => 'editid')) }} 
    	@endif
    			{{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }}
	            {{ Form::hidden('id', $request->id , array('id' => 'id')) }}
	            {{ Form::hidden('custid',$request->custid,array('id' => 'custid')) }}
    	<fieldset class="mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/Client.png')  }}">
				<h2 class="pull-left h2cnt">{{trans('messages.lbl_branch')}}</h2>
				<h2 class="pull-left h2cnt">&#9642;</h2>
				@if ($request->flg!=1)
					<h2 class="pull-left mt10 green">{{ trans('messages.lbl_register') }}</h2>
				@else
					<h2 class="pull-left mt10 red">{{ trans('messages.lbl_edit') }}</h2>
				@endif
			</div>
		</fieldset>
		@if($request->flg!=1)
			{{--*/ $style = '' /*--}}
		@else
			{{--*/ $style = '100%' /*--}}
		@endif
		<fieldset class="mt10 pull-left dispMainMobile" style="width: {{$style}} ">
			@if(!empty($bdetails))
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_branchid') }}</label>
					<span class="fr ml2 fs7"> </span>
				</div>
				<div class="col-xs-9 mw">
	               	{{$bdetails[0]->branch_id}}
               		{{ Form::hidden('branid',$bdetails[0]->branch_id , array('id' => 'branid')) }} 
				</div>
			</div>
			@endif
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_branchName') }}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-9 mw">
	               	{{ Form::text('txt_branch_name',(isset($bdetails[0]->branch_name)) ? $bdetails[0]->branch_name : '',array(
                                    'id'=>'txt_branch_name',
                                    'name' => 'txt_branch_name',
                                    'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
	                                'style' =>'width:240px;ime-mode: disabled;',
                                    'data-label' => trans('messages.lbl_branch_name'))) }} 
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_mobilenumber') }}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-9 mw">
	               	{{ Form::text('txt_mobilenumber',(isset($bdetails[0]->txt_mobilenumber)) ? $bdetails[0]->txt_mobilenumber : '',array(
                                'id'=>'txt_mobilenumber',
                                'name' => 'txt_mobilenumber',
                                'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
	                            'style' =>'width:240px;ime-mode: disabled;',
                                'maxlength' => 13,
                                'data-label' => trans('messages.lbl_mobilenumber'),
                                'onkeypress' => 'return isNumberKeywithminus(event)')) }}
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_fax') }}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-9 mw">
	               	{{ Form::text('txt_fax',(isset($bdetails[0]->txt_fax)) ? $bdetails[0]->txt_fax : '',array(
                                    'id'=>'txt_fax',
                                    'name' => 'txt_fax',
                                    'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
	                                'style' =>'width:240px;ime-mode: disabled;',
                                    'maxlength' => 13,
                                    'data-label' => trans('messages.lbl_fax'),
                                    'onkeypress' => 'return isNumberKeywithminus(event)')) }}
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<span class="p-country-name" style="display:none;">Japan</span>
					<label>{{ trans('messages.lbl_postalCode') }}<span class="fr ml2 red"> * </span></label>
				</div>
				<div class="col-xs-9 mw">
	                {{ Form::text('txt_postal',(isset($bdetails[0]->postalNumber)) ? $bdetails[0]->postalNumber : '',array('id'=>'txt_postal',
	                                'name' => 'txt_postal',
	                                'class'=>'ime_mode_disable txt dispinline form-control firstname regdes p-postal-code',
									'style'=> 'width:240px;',
	                                'maxlength' => '8',
	                                'onkeypress' => 'return isNumberKeywithminus(event)',
	                                'onkeyup' => 'addHyphen(this)',
	                                'data-label' => trans('messages.lbl_postalCode'))) }}                  
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label> {{ trans('messages.lbl_kenmei') }}<span class="fr ml2 red"> * </span></label>
				</div>
				<div class="col-xs-9 mw">
					{{ Form::select('kenmei',[null=>'Please select'] + $kenmeiarray,(isset($bdetails[0]->kenmei)) ? $bdetails[0]->kenmei : '',array('class'=>'ime_mode_disable txt dispinline form-control firstname regdes p-region-id',
									'style'=> 'width:240px;','id' =>'kenmei','data-label' => trans('messages.lbl_kenmei'),'name' => 'kenmei')) }}
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label>{{ trans('messages.lbl_shimei') }}<span class="fr ml2 red"> * </span></label>
				</div>
				<div class="col-xs-9 mw">
					{{ Form::text('txt_shimei',(isset($bdetails[0]->shimei)) ? $bdetails[0]->shimei : '',array('id'=>'txt_shimei',
	                            'name' => 'txt_shimei',
	                            'class'=>'ime_mode_disable txt dispinline form-control firstname regdes p-locality',
								'style'=> 'width:240px;',
	                            'data-label' => trans('messages.lbl_shimei'))) }}
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label>{{ trans('messages.lbl_streetaddress') }}<span class="fr ml2 red"> * </span></label>
				</div>
				<div class="col-xs-9 mw">
					{{ Form::text('txt_streetaddress',(isset($bdetails[0]->street_address)) ? $bdetails[0]->street_address : '',array(
	                                        'id'=>'txt_streetaddress',
	                                        'name' => 'txt_streetaddress',
	                                        'class'=>'ime_mode_disable txt dispinline form-control firstname regdes p-street-address',
											'style'=> 'width:240px;',
	                                        'data-label' => trans('messages.lbl_streetaddress'))) }}
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label>{{ trans('messages.lbl_buildingname') }}<span class="fr ml2 red" style="visibility: hidden;"> * </span></label>
				</div>
				<div class="col-xs-9 mw">
					{{ Form::text('txt_buildingname',(isset($bdetails[0]->buildingname)) ? $bdetails[0]->buildingname : '',array(
	                                        'id'=>'txt_buildingname',
	                                        'name' => 'txt_buildingname',
	                                        'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
											'style'=> 'width:240px;',
	                                        'data-label' => trans('messages.lbl_txt_buildingname'))) }}
				</div>
			</div>
			<div class="col-xs-12 mt10 mb20">
				<div class="col-xs-3 lb text-right pm0">
					<label>{{ trans('messages.lbl_remarks') }}<span class="fr ml2 red" style="visibility: hidden"> * </span></label>
				</div>
				<div class="col-xs-9 mw">
					{{ Form::textarea('txt_address',(isset($bdetails[0]->branch_address)) ? $bdetails[0]->branch_address : '',array(
	                                        'id'=>'txt_address',
	                                        'name' => 'txt_address',
	                                        'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
	                                        'style' =>'width:240px;height:70px;',
	                                        'data-label' => trans('messages.lbl_address'))) }}
				</div>
			</div>
		</fieldset>
		@if($request->flg !=1)
		<fieldset class="mt10 pull-right dispSubMobile">
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label>{{ trans('messages.lbl_inchargename') }}<span class="fr ml2 red"> * </span></label>
				</div>
				<div class="col-xs-9 mw">
					{{ Form::text('txt_incharge_name',(isset($getinchargedetails[0]->txt_incharge_name)) ? $getinchargedetails[0]->txt_incharge_name : '',array(
                                'id'=>'txt_incharge_name',
                                'name' => 'txt_incharge_name',
                                'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
	                            'style' =>'width:240px;ime-mode: disabled;',
                                'data-label' => trans('messages.lbl_inchargename'))) }}
				</div>
			</div>
			<div class="col-xs-12 mt10 mb20">
				<div class="col-xs-3 lb text-right pm0">
					<label>{{ trans('messages.lbl_incharge_mail') }}<span class="fr ml2 red"> * </span></label>
				</div>
				<div class="col-xs-9 mw">
					{{ Form::text('txt_mailid',(isset($getinchargedetails[0]->txt_mailid)) ? $getinchargedetails[0]->txt_mailid : '',array(
                                    'id'=>'txt_mailid',
                                    'name' => 'txt_mailid',
                                    'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
	                                'style' =>'width:240px;ime-mode: disabled;',
                                    'data-label' => trans('messages.lbl_incharge_mail'))) }}
                                    <div id="errorSectiondisplay" align="center"></div>
				</div>
			</div>
		</fieldset>
		@endif 
		<div style="margin-top: -5px;">
            <fieldset class="mt10 footerbg pull-left box100per">
                <div class="form-group">
                    <div align="center" class="mt5">
                        @if($request->flg ==1)
	                        <button type="button" class="btn edit btn-warning box100 Branchaddeditprocess" >
	                        	<i class="fa fa-edit" aria-hidden="true"></i> {{ trans('messages.lbl_update') }}
	                    	</button>
	                        <a onclick="javascript:gotoinpage('{{ $request->mainmenu }}',{{ date('YmdHis') }});" class="btn btn-danger box120 white"><i class="fa fa-times" aria-hidden="true"></i> {{ trans('messages.lbl_cancel') }} 
	                        </a>
                        @else
	                        <button type="button" class="btn btn-success add box100 Branchaddeditprocess ml5">
	                            <i class="fa fa-plus" aria-hidden="true"></i> {{ trans('messages.lbl_register') }}
	                        </button>
	                        <a onclick="javascript:gotoinpage('{{ $request->mainmenu }}',{{ date('YmdHis') }});" class="btn btn-danger box120 white"><i class="fa fa-times" aria-hidden="true"></i> {{ trans('messages.lbl_cancel') }} 
	                        </a>
                        @endif  
                    </div>
                </div>
            </fieldset>
        </div>
	</article>
</div>
{{ Form::close() }}
	{{ Form::open(array('name'=>'frmbranchaddeditcancel', 'id'=>'frmbranchaddeditcancel', 'url' => 'Customer/Branchaddeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,'method' => 'POST')) }}
			{{ Form::hidden('custid',$request->custid, array('id' => 'custid')) }}
			{{ Form::hidden('id',$request->id, array('id' => 'id')) }} 
			{{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }} 
			{{ Form::hidden('editid', $request->editid, array('id' => 'editid')) }}
	{{ Form::close() }}
@endsection