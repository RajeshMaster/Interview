@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/oldcustomer.js')) }}
{{ HTML::script(asset('public/js/yubinbango.js')) }}
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
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
		.lengthset {
			width:85%;
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
		.lengthset {
			width:55%;
		}
	}
</style>
	<div class="" id="main_contents">
		<article id="customer" class="DEC_flex_wrapper" data-category="customer cus_sub_1">
			{{ Form::open(array('name'=>'frmbranchaddcopy', 'id'=>'frmbranchaddcopy', 
								'class' => 'form-horizontal h-adr',
								'files'=>true,
								'url' => 'OldCustomer/copyBranchProcess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
								'method' => 'POST')) }}

				{{ Form::hidden('custid',$request->custid, array('id' => 'custid')) }}
				{{ Form::hidden('id',$request->id, array('id' => 'id')) }} 
				{{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }} 
				{{ Form::hidden('editid', '', array('id' => 'editid')) }} 

				{{ Form::hidden('selctedIncharge','' , array('id' => 'selctedIncharge')) }}
				{{ Form::hidden('selctedInchargeNumber','' , array('id' => 'selctedInchargeNumber')) }}

			<fieldset class="mt20">
				<div class="header">
					<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/Client.png')  }}">
					<h2 class="pull-left h2cnt">{{trans('messages.lbl_branch')}}</h2>
					<h2 class="pull-left h2cnt">&#9642;</h2>
					<h2 class="pull-left mt10 green">{{ trans('messages.lbl_register') }}</h2>
				</div>
			</fieldset>
			@if($request->flg!=1)
				{{--*/ $style = '' /*--}}
			@else
				{{--*/ $style = '100%' /*--}}
			@endif

			<div id="errorSectiondisplay"style="color: #9C0000;"  align="center" class="box100per"></div>

			<fieldset class="mt10 pull-left dispMainMobile" style="width: {{$style}} ">
				
				<div class="col-xs-12 mt10">
					<div class="col-xs-3 lb text-right pm0">
						<label class="clr_black"> {{ trans('messages.lbl_branchName') }}</label>
						<span class="fr ml2 fs7"> * </span>
					</div>
					<div class="col-xs-9 mw">
						{{ Form::text('txt_branch_name',(isset($getbranchDetails[0]->branch_name)) ? $getbranchDetails[0]->branch_name : '',array(
										'id'=>'txt_branch_name',
										'name' => 'txt_branch_name',
										'class'=>'box85per form-control',
										'data-label' => trans('messages.lbl_branch_name'))) }} 
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 lb text-right pm0">
						<label class="clr_black"> {{ trans('messages.lbl_mobilenumber') }}</label>
						<span class="fr ml2 fs7"> * </span>
					</div>
					<div class="col-xs-9 mw">
						{{ Form::text('txt_mobilenumber',(isset($getbranchDetails[0]->branch_contact_no)) ? $getbranchDetails[0]->branch_contact_no : '',array(
									'id'=>'txt_mobilenumber',
									'name' => 'txt_mobilenumber',
									'class'=>'box85per form-control',
									'style'=>'ime-mode: disabled;',
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
						{{ Form::text('txt_fax',(isset($getbranchDetails[0]->branch_fax_no)) ? $getbranchDetails[0]->branch_fax_no : '',array(
										'id'=>'txt_fax',
										'name' => 'txt_fax',
										'class'=>'box85per form-control',
										'maxlength' => 13,
										'style'=>'ime-mode: disabled;',
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
						 {{ Form::text('txt_postal',(isset($getbranchDetails[0]->postalNumber)) ? $getbranchDetails[0]->postalNumber : '',array(
										'id'=>'txt_postal',
										'name' => 'txt_postal',
										'class'=>'box38per form-control p-postal-code',
										'maxlength' => '8',
										'style'=>'ime-mode: disabled;',
										'data-label' => trans('messages.lbl_fax'),
										'onkeyup' => 'addHyphen(this)',
										'onkeypress' => 'return isNumberKeywithminus(event)')) }}
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 lb text-right pm0">
						<label> {{ trans('messages.lbl_kenmei') }}<span class="fr ml2 red"> * </span></label>
					</div>
					<div class="col-xs-9 mw">
						{{ Form::select('kenmei',[null=>'Please select'] + $getKenname,(isset($getbranchDetails[0]->kenmei)) ? $getbranchDetails[0]->kenmei : '',array('class' => 'box60per form-control p-region-id','id' =>'kenmei','data-label' => trans('messages.lbl_kenmei'),'name' => 'kenmei')) }}
					</div>
				</div>
				
				<div class="col-xs-12 mt10">
					<div class="col-xs-3 lb text-right pm0">
						<label>{{ trans('messages.lbl_shimei') }}<span class="fr ml2 red"> * </span></label>
					</div>
					<div class="col-xs-9 mw">
						{{ Form::text('txt_shimei',(isset($getbranchDetails[0]->shimei)) ? $getbranchDetails[0]->shimei : '',array(
										'id'=>'txt_shimei',
										'name' => 'txt_shimei',
										'class'=>'box85per form-control p-locality',
										'maxlength' => 13,
										'style'=>'ime-mode: disabled;',
										'data-label' => trans('messages.lbl_shimei'))) }}
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 lb text-right pm0">
						<label>{{ trans('messages.lbl_streetaddress') }}<span class="fr ml2 red"> * </span></label>
					</div>
					<div class="col-xs-9 mw">
						{{ Form::text('txt_streetaddress',(isset($getbranchDetails[0]->street_address)) ? $getbranchDetails[0]->street_address : '',array(
										'id'=>'txt_streetaddress',
										'name' => 'txt_streetaddress',
										'class'=>'box85per form-control p-street-address p-street-address',
										'maxlength' => 13,
										'style'=>'ime-mode: disabled;',
										'data-label' => trans('messages.lbl_streetaddress'))) }}
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 lb text-right pm0">
						<label>{{ trans('messages.lbl_buildingname') }}<span class="fr ml2 red" style="visibility: hidden;"> * </span></label>
					</div>
					<div class="col-xs-9 mw">
						{{ Form::text('txt_buildingname',(isset($getbranchDetails[0]->buildingname)) ? $getbranchDetails[0]->buildingname : '',array(
										'id'=>'txt_buildingname',
										'name' => 'txt_buildingname',
										'class'=>'box85per form-control',
										'maxlength' => 13,
										'style'=>'ime-mode: disabled;',
										'data-label' => trans('messages.lbl_buildingname'))) }}
					</div>
				</div>
				<div class="col-xs-12 mt10 mb20">
					<div class="col-xs-3 lb text-right pm0">
						<label>{{ trans('messages.lbl_remarks') }}<span class="fr ml2 red" style="visibility: hidden"> * </span></label>
					</div>
					<div class="col-xs-9 mw">
						{{ Form::textarea('txt_address',(isset($getbranchDetails[0]->branch_address)) ? $getbranchDetails[0]->branch_address : '',array(
										'id'=>'txt_address',
										'name' => 'txt_address',
										'class'=>'box85per',
										'style' => 'height :70px;',
										'name' => 'txt_address',
										'data-label' => trans('messages.lbl_address'))) }}
					</div>
				</div>
			</fieldset>

			<fieldset class="mt10 pull-right dispSubMobile">

			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0 inb">
					<label>{{ trans('messages.lbl_inchargename') }}<span class="fr ml2 red"> * </span></label>
				</div>
				<div class="col-xs-9 mw inb">
					<input type="hidden" id="inchargeValue" name="inchargeValue" value="" />
					{{ Form::text('txt_incharge_name','',array(
											'id'=>'txt_incharge_name',
											'name' => 'txt_incharge_name',
											'class'=>'lengthset form-control inb',
											'data-label' => trans('messages.lbl_inchargename'))) }}
					<button data-toggle="modal" type="button" class="btn btn-success add mt3" 
							style="height:27px;width: 50px;font-size: 12px;" onclick="return oldInchargeSelect();">
							<span class="mr10">{{ trans('messages.lbl_select') }}</span> 
					</button>
					<a onclick="javascript:cleartxt();" style="height:27px;width: 45px;font-size: 12px;" 
						class="btn btn-danger box47 white mt3">
							<span>Clear</span>  
					</a>
				</div>
			</div>

				<div class="col-xs-12 mt10 mb20">
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

				<div class="col-xs-12 " id="CountError" style="color: #9C0000;display: none" >
					<div class="col-xs-3 lb text-right pm0">
					</div>
					<div class="col-xs-9 mw">
						Please Input Same Count of Incharge Name and Email Id.
					</div>
				</div>

				<div class="col-xs-12 " id="emailError" style="color: #9C0000;display: none" >
					<div class="col-xs-3 lb text-right pm0">
					</div>
					<div class="col-xs-9 mw">
						You have entered an invalid email address!
					</div>
				</div>

			</fieldset>

			<div style="margin-top: -5px;">
				<fieldset class="mt10 footerbg pull-left box100per">
					<div class="form-group">
						<div align="center" class="mt5">
							
							<button type="button" class="btn btn-success add box100 Branchaddedcopy ml5">
								<i class="fa fa-plus" aria-hidden="true"></i> {{ trans('messages.lbl_register') }}
							</button>

							<a onclick="javascript:gotoinpagecancel('{{ $request->mainmenu }}',{{ date('YmdHis') }});" class="btn btn-danger box120 white"><i class="fa fa-times" aria-hidden="true"></i> {{ trans('messages.lbl_cancel') }} 
								</a>  
						</div>
					</div>
				</fieldset>
			</div>
		</article>
	</div>
{{ Form::close() }}

{{ Form::open(array('name'=>'frmbranchaddcopycancel', 'id'=>'frmbranchaddcopycancel', 'url' => 'Customer/Branchaddeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,'method' => 'POST')) }}

	{{ Form::hidden('custid',Session::get('customerIdSel'), array('id' => 'custid')) }}
	{{ Form::hidden('id', Session::get('customerMax'), array('id' => 'id')) }} 

{{ Form::close() }}

	<div id="inchargeSelect" class="modal fade">
	  <div id="login-overlay">
		<div class="modal-content">
		<!-- Popup will be loaded here -->
		</div>
	  </div>
	</div>
@endsection