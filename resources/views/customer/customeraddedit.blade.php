@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/lib/bootstrap-datepicker.min.js')) }}
{{ HTML::style(asset('public/css/lib/bootstrap-datetimepicker.min.css')) }}
{{ HTML::script(asset('public/js/customer.js')) }}
{{ HTML::script(asset('public/js/oldcustomer.js')) }}
{{ HTML::script(asset('public/js/yubinbango.js')) }}
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
	$(document).ready(function() {
    	setDatePicker("txt_custagreement");
    	check();
  	});
  	function check(){
		if ($('#hidgrp').val() != "") {
			var grid = $('#hidgrp').val();
	       	var strarray = grid.split(';');
			for (var i = 0; i < strarray.length; i++) {
				jQuery("."+strarray[i]).prop("checked", true);
			}
		}
	}
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
	input[type=text]:disabled {
  		background: white;
  		cursor: default;
	}
</style>
<div class="" id="main_contents">
	<article id="customer" class="DEC_flex_wrapper" data-category="customer cus_sub_1">
		@if(!empty($getdetails))
        {{ Form::model($getdetails,array('name'=>'frmcustaddedit','method' => 'POST',
                                         'class'=>'form-horizontal h-adr',
                                         'id'=>'frmcustaddedit', 
                                         'url' => 'Customer/CustomerAddeditProcess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'))) }}
            {{ Form::hidden('editid', $request->editid, array('id' => 'editid')) }}
            {{ Form::hidden('viewid', $request->editid, array('id' => 'viewid')) }}
            {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
            {{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }}
            {{ Form::hidden('id', $request->id , array('id' => 'id')) }}
            {{ Form::hidden('custid',$request->custid,array('id' => 'custid')) }}
            {{ Form::hidden('hid_branch_id','', array('id' => 'hid_branch_id')) }}
            {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
    	@else
        {{ Form::open(array('name'=>'frmcustaddedit', 'id'=>'frmcustaddedit', 
                            'class' => 'form-horizontal h-adr',
                            'files'=>true,
                            'url' => 'Customer/CustomerAddeditProcess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
                            'method' => 'POST')) }}
        {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
        {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
        {{ Form::hidden('editid','', array('id' => 'editid')) }}
        {{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }}
        {{ Form::hidden('id', $request->id , array('id' => 'id')) }}
        {{ Form::hidden('custid',$request->custid,array('id' => 'custid')) }}
        {{ Form::hidden('hid_branch_id','', array('id' => 'hid_branch_id')) }}
    	@endif     
    	<fieldset class="mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/Client.png')  }}">
				<h2 class="pull-left h2cnt">{{trans('messages.lbl_customer')}}</h2>
				<h2 class="pull-left h2cnt">&#9642;</h2>
				@if ($request->flg!="")
					<h2 class="pull-left mt10 red">{{ trans('messages.lbl_edit') }}</h2>
				@else
					<h2 class="pull-left mt10 green">{{ trans('messages.lbl_register') }}</h2>
				@endif
			</div>
		</fieldset>

		<fieldset class="mt10 pull-left dispMainMobile">
		@if(!empty($getdetails))
			<div class="col-xs-12 mt20">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black">{{ trans('messages.lbl_CustId') }}</label>
					<span class="fr ml2 fs7"> </span>
				</div>
				<div class="col-xs-9 mw">
	               	{{$request->custid}} 
				</div>
			</div>
		@endif
		<div class="col-xs-12 mt20">
			<div class="col-xs-3 lb text-right pm0">
				<label class="clr_black">{{ trans('messages.lbl_custname(JP & Eng)') }}</label>
				<span class="fr ml2 fs7"> * </span>
			</div>
			<div class="col-xs-9 mw">
               	{{ Form::text('txt_custnamejp',(isset($getdetails)) ? $getdetails[0]->txt_custnamejp : '',array('id'=>'txt_custnamejp',
                            'name' => 'txt_custnamejp',
                            'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
							'style'=> 'width:240px;',
                            'data-label' => trans('messages.lbl_custname(JP & Eng)'))) }}
			</div>
		</div>
		<div class="col-xs-12 mt20">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_custname(kana)') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
                {{ Form::text('txt_kananame',(isset($getdetails)) ? $getdetails[0]->txt_kananame : '',array('id'=>'txt_kananame',
                        'name' => 'txt_kananame',
                        'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
						'style'=> 'width:240px;',
                        'data-label' => trans('messages.lbl_kananame'))) }}                    
			</div>
		</div>
		<div class="col-xs-12 mt20">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_repname') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
                {{ Form::text('txt_repname',(isset($getdetails)) ? $getdetails[0]->txt_repname : '',array('id'=>'txt_repname',
                        'name' => 'txt_repname',
                        'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
						'style'=> 'width:240px;',
                        'name' => 'txt_repname',
                        'data-label' => trans('messages.lbl_repname'))) }}                   
			</div>
		</div>
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_custagreement') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_custagreement',(isset($getdetails)) ? $getdetails[0]->txt_custagreement : '',array('id'=>'txt_custagreement',
                                        'name' => 'txt_custagreement',
                                        'style'=> 'width:110px;',
										'class'=>'ime_mode_disable form-control inb txt_custagreement',
                                        'data-label' => trans('messages.lbl_custagreement'),
                                         'onkeypress'=>'return event.charCode >=6 && event.charCode <=58',
                                        'maxlength' => '10')) }}
				<label class="mt10 ml2 fa fa-calendar fa-lg" for="txt_custagreement" aria-hidden="true"></label>
			</div>
		</div>
		<div class="col-xs-12 mt20">
			<div class="col-xs-3 lb text-right pm0">
				<span class="p-country-name" style="display:none;">Japan</span>
				<label>{{ trans('messages.lbl_postalCode') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
                {{ Form::text('txt_postal',(isset($getdetails[0]->postalNumber)) ? $getdetails[0]->postalNumber : '',array('id'=>'txt_postal',
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
				{{ Form::select('kenmei1',[null=>'Please select'] + $getKenname,(isset($getdetails[0]->kenmei)) ? $getdetails[0]->kenmei : '',array('class'=>'ime_mode_disable txt dispinline form-control firstname regdes p-region-id',
								'style'=> 'width:240px; background: white; cursor: default;', 'disabled' =>'disabled','id' =>'kenmei1','data-label' => trans('messages.lbl_kenmei'),'name' => 'kenmei1')) }}
				<input type="hidden" name="kenmei" id="kenmei" class="p-region-id" value="{{ (isset($getdetails[0]->kenmei)) ? $getdetails[0]->kenmei : '' }}">	
			</div>
		</div>
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_shimei') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_shimei1',(isset($getdetails[0]->shimei)) ? $getdetails[0]->shimei : '',array(
                                        'id'=>'txt_shimei1',
                                        'name' => 'txt_shimei1',
                                        'class'=>'ime_mode_disable txt dispinline form-control firstname regdes p-locality',
										'style'=> 'width:240px;', 'disabled' =>'disabled',
                                        'data-label' => trans('messages.lbl_shimei'))) }}
                <input type="hidden" name="txt_shimei" id="txt_shimei" class="p-locality" value="{{ (isset($getdetails[0]->shimei)) ? $getdetails[0]->shimei : '' }}" >                       
			</div>
		</div>
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_streetaddress') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_streetaddress',(isset($getdetails[0]->street_address)) ? $getdetails[0]->street_address : '',array(
                                        'id'=>'txt_streetaddress',
                                        'name' => 'txt_streetaddress',
                                        'class'=>'ime_mode_disable txt dispinline form-control firstname regdes p-street-address',
										'style'=> 'width:240px;',
                                        'data-label' => trans('messages.lbl_streetaddress'))) }}
			</div>
		</div>
		<div class="col-xs-12 mt10 mb20">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_buildingname') }}<span class="fr ml2 red" style="visibility: hidden;"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_buildingname',(isset($getdetails[0]->buildingname)) ? $getdetails[0]->buildingname : '',array(
                                        'id'=>'txt_buildingname',
                                        'name' => 'txt_buildingname',
                                        'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
										'style'=> 'width:240px;',
                                        'data-label' => trans('messages.lbl_txt_buildingname'))) }}
			</div>
		</div>
		<!-- <div class="col-xs-12 mt10 mb20">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_remarks') }}<span class="fr ml2 red" style="visibility: hidden"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::textarea('txt_address',(isset($getdetails)) ? $getdetails[0]->txt_address : '',array(
                                        'id'=>'txt_address',
                                        'name' => 'txt_address',
                                        'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
                                        'style' =>'width:240px;height:70px;',
                                        'data-label' => trans('messages.lbl_address'))) }}
			</div>
		</div> -->
	</fieldset>
	<fieldset class="mt10 pull-right dispSubMobile">
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_branchName') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_branch_name',(isset($getbranchdetails[0]->branch_name)) ? $getbranchdetails[0]->branch_name : '',array(
                                        'id'=>'txt_branch_name',
                                        'name' => 'txt_branch_name',
                                       	'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
										'style'=> 'width:240px;',
                                        'data-label' => trans('messages.lbl_branchName'))) }}
			</div>
		</div>
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_mobilenumber') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_mobilenumber',(isset($getdetails)) ? $getdetails[0]->txt_mobilenumber : '',array(
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
				<label>{{ trans('messages.lbl_fax') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_fax',(isset($getdetails)) ? $getdetails[0]->txt_fax : '',array(
                                        'id'=>'txt_fax',
                                        'name' => 'txt_fax',
                                        'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
										'style'=> 'width:240px;',
                                        'maxlength' => 13,
                                        'data-label' => trans('messages.lbl_fax'),
                                        'onkeypress' => 'return isNumberKeywithminus(event)')) }}
			</div>
		</div>
		
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb text-right pm0">
				<label>URL<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_url',(isset($getdetails)) ? $getdetails[0]->txt_url : '',array(
                                        'id'=>'txt_url',
                                        'name' => 'txt_url',
                                        'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
										'style'=> 'width:240px;',
                                        'data-label' => 'URL')) }}
			</div>
		</div>
		@if($request->flg!=1)
		<div class="col-xs-12 mt15">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_inchargename') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_incharge_name',(isset($getinchargedetails[0]->txt_incharge_name)) ? $getinchargedetails[0]->txt_incharge_name : '',array(
                                        'id'=>'txt_incharge_name',
                                        'name' => 'txt_incharge_name',
                                        'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
										'style'=> 'width:240px;',
                                        'data-label' => trans('messages.lbl_inchargename'))) }}
			</div>
		</div>
		@endif
		@if($request->flg!=1)
		<div class="col-xs-12 mt15">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_incharge_mail') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_mailid',(isset($getinchargedetails[0]->txt_mailid)) ? $getinchargedetails[0]->txt_mailid : '',array(
                            'id'=>'txt_mailid',
                            'name' => 'txt_mailid',
                            'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
							'style'=> 'width:240px;',
                            'data-label' => trans('messages.lbl_incharge_mail'))) }}
                <div id="errorSectiondisplay" align="center"></div>            
			</div>
		</div>
		@endif
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_remarks') }}<span class="fr ml2 red" style="visibility: hidden"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::textarea('txt_address',(isset($getdetails[0]->txt_address)) ? $getdetails[0]->txt_address : '',array(
                                        'id'=>'txt_address',
                                        'name' => 'txt_address',
                                        'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
                                        'style' =>'width:240px;height:70px;',
                                        'data-label' => trans('messages.lbl_address'))) }}
			</div>
		</div>
		@if(count($group))
		<div class="col-xs-12 mt10 mb20">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_group') }}<span class="fr ml2 red" style="visibility: hidden"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				<?php 
					if (count($group) != 0) {
						foreach ($group as $key => $value) {
							?><label><input type="checkbox" name="groupingID[]" id="groupingID[]" 
							value="<?php echo $value->groupId; ?> " class="<?php echo $value->groupId; ?> "> <?php echo $value->groupName; ?></label> <?php
						}
					}
				?>
				<input type="hidden" name="hidgrp" id="hidgrp" value="<?php echo (isset($getdetails[0]->groupId)) ? $getdetails[0]->groupId : '' ?>  ">
		
			</div>
		</div>
		@endif
		<!-- @if(count($group) != 0)
			@foreach($group as $key => $value)
				{{ $value->groupName }}
			@endforeach
		@endif -->
		
	</fieldset>
		<div style="margin-top: -5px;">
            <fieldset class="mt10 footerbg pull-left box100per">
                <div class="form-group">
                    <div align="center" class="mt5">
                        @if(isset($request->flg))
                        <button type="button" class="btn edit btn-warning box100 addeditprocess" >
                            <i class="fa fa-edit" aria-hidden="true"></i> {{ trans('messages.lbl_update') }}
                        </button>
                        <a onclick="javascript:gotoindexpage('1','{{ $request->mainmenu }}',{{ date('YmdHis') }});" class="btn btn-danger box120 white"><i class="fa fa-times" aria-hidden="true"></i> {{ trans('messages.lbl_cancel') }} 
                            </a>
                        @else
                            <button type="button" class="btn btn-success add box100 addeditprocess ml5">
                                <i class="fa fa-plus" aria-hidden="true"></i> {{ trans('messages.lbl_register') }}
                            </button>
                            <a onclick="javascript:gotoindexpage('2','{{ $request->mainmenu }}',{{ date('YmdHis') }});" class="btn btn-danger box120 white"><i class="fa fa-times" aria-hidden="true"></i> {{ trans('messages.lbl_cancel') }} 
                            </a>
                        @endif  
                    </div>
                </div>
            </fieldset>
        </div>
        {{ Form::close() }}
{{ Form::open(array('name'=>'frmcustaddeditcancel', 'id'=>'frmcustaddeditcancel', 'url' => 'Customer/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,'method' => 'POST')) }}
        {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
        {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
        {{ Form::hidden('editid','', array('id' => 'editid')) }}
        {{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }}
        {{ Form::hidden('id', $request->id , array('id' => 'id')) }}
        {{ Form::hidden('custid',$request->custid,array('id' => 'custid')) }}
     	{{ Form::hidden('hid_branch_id','', array('id' => 'hid_branch_id')) }}
    {{ Form::close() }}

	</article>
</div>
@endsection