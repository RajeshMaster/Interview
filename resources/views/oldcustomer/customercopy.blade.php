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
	<article id="customer" class="DEC_flex_wrapper" data-category="customer cus_sub_3">
		{{ Form::open(array('name'=>'frmcustaddcopy', 'id'=>'frmcustaddcopy', 
							'class' => 'form-horizontal h-adr',
							'files'=>true,
							'url' => 'OldCustomer/addprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
							'method' => 'POST')) }}
		{{ Form::hidden('mainmenu', 'menu_oldcustomer' , array('id' => 'mainmenu')) }}
		{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
		{{ Form::hidden('editid','', array('id' => 'editid')) }}
		{{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }}
		{{ Form::hidden('id', $request->id , array('id' => 'id')) }}
		{{ Form::hidden('custid',$request->custid,array('id' => 'custid')) }}
		{{ Form::hidden('hid_branch_id','', array('id' => 'hid_branch_id')) }}

		{{ Form::hidden('txt_branch_id','', array('id' => 'txt_branch_id')) }}
		{{ Form::hidden('txt_custID','', array('id' => 'txt_custID')) }}

		{{ Form::hidden('selctedIncharge','' , array('id' => 'selctedIncharge')) }}
		{{ Form::hidden('selctedInchargeNumber','' , array('id' => 'selctedInchargeNumber')) }}   
		<fieldset class="mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/Client.png')  }}">
				<h2 class="pull-left h2cnt">{{trans('messages.lbl_customer')}}</h2>
				<h2 class="pull-left h2cnt">&#9642;</h2>
				<h2 class="pull-left mt10 green">{{ trans('messages.lbl_copy') }}</h2>
			</div>
		</fieldset>

		<fieldset class="mt10 pull-left dispMainMobile">

			<div class="col-xs-12 mt20">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black">{{ trans('messages.lbl_custname(JP & Eng)') }}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-9 mw">
					{{ Form::text('txt_custnamejp','',array(
										'id'=>'txt_custnamejp',
										'name' => 'txt_custnamejp',
										'class'=>'box85per form-control',
										'data-label' => trans('messages.lbl_custname(JP & Eng)'))) }}
				</div>
			</div>

			<div class="col-xs-12 mt20">
				<div class="col-xs-3 lb text-right pm0">
					<label>{{ trans('messages.lbl_custname(kana)') }}<span class="fr ml2 red"> * </span></label>
				</div>
				<div class="col-xs-9 mw">
					 {{ Form::text('txt_kananame','',array(
										'id'=>'txt_kananame',
										'name' => 'txt_kananame',
										'class'=>'box85per form-control',
										'data-label' => trans('messages.lbl_kananame'))) }}                  
				</div>
			</div>

			<div class="col-xs-12 mt20">
				<div class="col-xs-3 lb text-right pm0">
					<label>{{ trans('messages.lbl_repname') }}<span class="fr ml2 red"> * </span></label>
				</div>
				<div class="col-xs-9 mw">
					{{ Form::text('txt_repname','',array(
										'id'=>'txt_repname',
										'name' => 'txt_repname',
										'class'=>'box85per form-control',
										'name' => 'txt_repname',
										'data-label' => trans('messages.lbl_repname'))) }}  
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label>{{ trans('messages.lbl_custagreement') }}<span class="fr ml2 red"> * </span></label>
				</div>
				<div class="col-xs-9 mw">
					{{ Form::text('txt_custagreement','',array(
										'id'=>'txt_custagreement',
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
					{{ Form::text('txt_postal','',array(
                                    'id'=>'txt_postal',
                                    'name' => 'txt_postal',
                                    'class'=>'box38per form-control p-postal-code',
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
				{{ Form::select('kenmei',[null=>'Please select'] + $getKenname,(isset($getdetails[0]->kenmei)) ? $getdetails[0]->kenmei : '',array('class' => 'box60per form-control p-region-id','id' =>'kenmei','data-label' => trans('messages.lbl_kenmei'),'name' => 'kenmei')) }}
			</div>
		</div>
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_shimei') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_shimei','',array(
										'id'=>'txt_shimei',
										'name' => 'txt_shimei',
										'class'=>'box85per form-control p-locality',
										'data-label' => trans('messages.lbl_shimei'))) }}
			</div>
		</div>
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_streetaddress') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_streetaddress','',array(
										'id'=>'txt_streetaddress',
										'name' => 'txt_streetaddress',
										'class'=>'box85per form-control p-street-address p-street-address',
										'data-label' => trans('messages.lbl_streetaddress'))) }}
			</div>
		</div>
		<div class="col-xs-12 mt10 mb20">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_buildingname') }}<span class="fr ml2 red" style="visibility: hidden;"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_buildingname','',array(
										'id'=>'txt_buildingname',
										'name' => 'txt_buildingname',
										'class'=>'box85per form-control ',
										'data-label' => trans('messages.lbl_txt_buildingname'))) }}
			</div>
		</div>
		<div class="col-xs-12 mt10 mb20">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_remarks') }}<span class="fr ml2 red" style="visibility: hidden"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::textarea('txt_address','',array(
										'id'=>'txt_address',
										'name' => 'txt_address',
										'class'=>'box85per form-control',
										'style' =>'height:70px;',
										'data-label' => trans('messages.lbl_address'))) }}
			</div>
		</div>
	</fieldset>
	<fieldset class="mt10 pull-right dispSubMobile">
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_branchName') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_branch_name','',array(
										'id'=>'txt_branch_name',
										'name' => 'txt_branch_name',
										'class'=>'box85per form-control',
										'data-label' => trans('messages.lbl_branch_name'))) }}
			</div>
		</div>
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_mobilenumber') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_mobilenumber','',array(
										'id'=>'txt_mobilenumber',
										'name' => 'txt_mobilenumber',
										'class'=>'box85per form-control',
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
				{{ Form::text('txt_fax','',array(
										'id'=>'txt_fax',
										'name' => 'txt_fax',
										'class'=>'box85per form-control',
										'maxlength' => 13,
										'data-label' => trans('messages.lbl_fax'),
										'onkeypress' => 'return isNumberKeywithminus(event)')) }}
			</div>
		</div>
		@if($request->flg !=1)
			{{--*/ $style = '' /*--}}
		@else
			{{--*/ $style = 'mb50' /*--}}
		@endif
		<div class="col-xs-12 mt10 {{$style}} ">
			<div class="col-xs-3 lb text-right pm0">
				<label>URL<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_url','',array(
										'id'=>'txt_url',
										'name' => 'txt_url',
										'class'=>'box85per form-control',
										'data-label' => trans('messages.lbl_url'))) }}
			</div>
		</div>
		@if($request->flg!=1)
		<div class="col-xs-12 mt15">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_inchargename') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw inb" style="width: 350px;">
                <input type="hidden" id="inchargeValue" name="inchargeValue" value="" />
				{{ Form::text('txt_incharge_name','',array(
										'id'=>'txt_incharge_name',
										'name' => 'txt_incharge_name',
										'class'=>'box55per form-control inb',
										'data-label' => trans('messages.lbl_inchargename'))) }}
				<button data-toggle="modal" type="button" class="btn btn-success add inb" 
                        style="height:30px;width: 50px;font-size: 12px;" onclick="return oldInchargeSelect();">
                        <span>{{ trans('messages.lbl_select') }}</span> 
                </button>
                <a onclick="javascript:cleartxt();" style="height:30px;width: 50px;font-size: 12px;" 
                    class="btn btn-danger box47 white inb">
                      <span>Clear</span>  
                </a>
			</div>
		</div>
		@endif
		@if($request->flg!=1)
		<div class="col-xs-12 mt15 mb50">
			<div class="col-xs-3 lb text-right pm0">
				<label>{{ trans('messages.lbl_incharge_mail') }}<span class="fr ml2 red"> * </span></label>
			</div>
			<div class="col-xs-9 mw">
				{{ Form::text('txt_mailid','',array(
											'id'=>'txt_mailid',
											'name' => 'txt_mailid',
											'class'=>'box85per form-control',
											'style'=>'ime-mode: disabled;',
											'data-label' => trans('messages.lbl_incharge_mail'))) }}
				<div id="errorSectiondisplay" align="center"></div>            
			</div>
		</div>
		@endif
	</fieldset>
		<div style="margin-top: -5px;">
			<fieldset class="mt10 footerbg pull-left box100per">
				<div class="form-group">
					<div align="center" class="mt5">
						<button type="button" class="btn btn-success add box100 addeditprocesscopy ml5">
							<i class="fa fa-plus" aria-hidden="true"></i> {{ trans('messages.lbl_register') }}
						</button>
						<a onclick="javascript:gotoindexpage();" class="btn btn-danger box120 white">
							<i class="fa fa-times" aria-hidden="true"></i> {{ trans('messages.lbl_cancel') }} 
						</a>
					</div>
				</div>
			</fieldset>
		</div>
	</article>
</div>
    {{ Form::close() }}

     {{ Form::open(array('name'=>'frmcustaddcopycancel', 'id'=>'frmcustaddcopycancel', 'url' => 'OldCustomer/addprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,'method' => 'POST')) }}

        {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}

        {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}

        {{ Form::hidden('editid','', array('id' => 'editid')) }}

        {{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }}

        {{ Form::hidden('id', $request->id , array('id' => 'id')) }}

        {{ Form::hidden('custid',$request->custid,array('id' => 'custid')) }}

         {{ Form::hidden('hid_branch_id','', array('id' => 'hid_branch_id')) }}

    {{ Form::close() }}


   <div id="inchargeSelect" class="modal fade">
      <div id="login-overlay">
        <div class="modal-content">
        <!-- Popup will be loaded here -->
        </div>
      </div>
    </div>
@endsection