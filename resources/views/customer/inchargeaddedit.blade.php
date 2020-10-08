@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/lib/bootstrap-datepicker.min.js')) }}
{{ HTML::style(asset('public/css/lib/bootstrap-datetimepicker.min.css')) }}
{{ HTML::script(asset('public/js/customer.js')) }}
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
	<article id="customer" class="DEC_flex_wrapper" data-category="customer cus_sub_1">
		@if(!empty($indetails))
			{{ Form::model($indetails,array('name'=>'frminchargeaddedit','method' => 'POST',
                                         'class'=>'form-horizontal',
                                         'id'=>'frminchargeaddedit', 
                                         'url' => 'Customer/Inchargeaddeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'))) }}
            {{ Form::hidden('editid', $request->editid, array('id' => 'editid')) }}                             
		@else
		 	{{ Form::open(array('name'=>'frminchargeaddedit', 'id'=>'frminchargeaddedit', 
                            'class' => 'form-horizontal',
                            'files'=>true,
                            'url' => 'Customer/Inchargeaddeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
                            'method' => 'POST')) }}
            {{ Form::hidden('editid', '', array('id' => 'editid')) }}
		@endif
			{{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }}
	        {{ Form::hidden('id', $request->id , array('id' => 'id')) }}
	        {{ Form::hidden('custid',$request->custid,array('id' => 'custid')) }}
	        {{ Form::hidden('inchargeid', '', array('id' => 'inchargeid')) }} 
	        {{ Form::hidden('branchNmForMAil', '', array('id' => 'branchNmForMAil')) }} 
	        {{ Form::hidden('customerNmForMail', $request->CustNameFormail, array('id' => 'customerNmForMail')) }}
	   	<fieldset class="mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/Client.png')  }}">
				<h2 class="pull-left h2cnt">{{trans('messages.lbl_incharge')}}</h2>
				<h2 class="pull-left h2cnt">&#9642;</h2>
				@if ($request->flg!=1)
					<h2 class="pull-left mt10 green">{{ trans('messages.lbl_register') }}</h2>
				@else
					<h2 class="pull-left mt10 red">{{ trans('messages.lbl_edit') }}</h2>
				@endif
			</div>
		</fieldset> 
		<fieldset id="hdnfield" class="mt10 mb50">
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_inchargename') }}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-9 mw">
		            {{ Form::text('txt_incharge_name',(isset($indetails[0]->txt_incharge_name)) ? $indetails[0]->txt_incharge_name : '',array(
		            'id'=>'txt_incharge_name',
		            'name' => 'txt_incharge_name',
		            'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
	                'style' =>'width:240px;',
		            'data-label' => trans('messages.lbl_inchargename'))) }} 
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_inchargenamekana') }}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-9 mw">
		            {{ Form::text('txt_incharge_namekana',(isset($indetails[0]->txt_incharge_namekana)) ? $indetails[0]->txt_incharge_namekana : '',array(
                                    'id'=>'txt_incharge_namekana',
                                    'name' => 'txt_incharge_namekana',
                                    'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
	                                'style' =>'width:240px;',
                                    'data-label' => trans('messages.lbl_inchargenamekana'))) }}
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_designation') }}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-9 mw">
		            @if($request->flg!=1)
						{{ Form::select('designation',[null=>'Please select'] + $getdesname,'',array('class'=>'ime_mode_disable txt dispinline form-control firstname regdes','style' =>'width:240px;','id' =>'designation','data-label' => trans('messages.lbl_designation'),'name' => 'designation')) }}
					@else
						{{ Form::select('designation',$getdesname,(isset($indetails[0]->designation)) ? $indetails[0]->designation : '',array('class'=>'ime_mode_disable txt dispinline form-control firstname regdes','style' =>'width:240px;','id' =>'designation','data-label' => trans('messages.lbl_designation'),'name' => 'designation')) }}
					@endif
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_mobilenumber') }}</label>
					<span class="fr ml2 fs7" style="visibility: hidden;"> * </span>
				</div>
				<div class="col-xs-9 mw">
		            {{ Form::text('txt_mobilenumber',(isset($indetails[0]->txt_mobilenumber)) ? $indetails[0]->txt_mobilenumber : '',array(
	                                    'id'=>'txt_mobilenumber',
	                                    'name' => 'txt_mobilenumber',
	                                    'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
	                                	'style' =>'width:240px;',
	                                    'maxlength' => 11,
	                                    'data-label' => trans('messages.lbl_mobilenumber'),
	                                    'onkeypress' => 'return isNumberKey(event)')) }}
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_branchName') }}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-9 mw">
		            @if($request->flg != 1)
						{{ Form::select('bname',[null=>'Please select'] + $getbname ,'本社', 
                            ['class'=>'ime_mode_disable txt dispinline form-control firstname regdes','style' =>'width:240px;','id' =>'bname','data-label' => trans('messages.lbl_branch_name'),'name' => 'bname']) }}
					@else
						{{ Form::select('bname',[null=>'Please select'] + $getbname,(isset($indetails[0]->bname)) ? $indetails[0]->bname : '本社',array('class'=>'ime_mode_disable txt dispinline form-control firstname regdes','style' =>'width:240px;','id' =>'bname','data-label' => trans('messages.lbl_branch_name'),'name' => 'bname')) }}
					@endif
				</div>
			</div>
			<div class="col-xs-12 mt10 mb50">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_mailid') }}</label>
					<span class="fr ml2 fs7"> * </span>
				</div>
				<div class="col-xs-9 mw">
		            {{ Form::text('txt_mailid',(isset($indetails[0]->txt_mailid)) ? $indetails[0]->txt_mailid : '',array(
	                                    'id'=>'txt_mailid',
	                                    'name' => 'txt_mailid',
	                                    'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
	                                	'style' =>'width:240px;',
	                                    'data-label' => trans('messages.lbl_mailid'))) }}
	                                    <div id="errorSectiondisplay" align="center"></div>
				</div>

			</div>
		</fieldset>
		<fieldset style="background-color: #DDF1FA;">
			<div align="center" class="mt5 mb5">
                   @if($request->flg ==1)
                    <button type="button" class="btn edit btn-warning box100 Inchargeaddeditprocess" >
                        <i class="fa fa-edit" aria-hidden="true"></i> {{ trans('messages.lbl_update') }}
                    </button>
                    @else
                        <button type="button" class="btn btn-success add box100 Inchargeaddeditprocess ml5">
                            <i class="fa fa-plus" aria-hidden="true"></i> {{ trans('messages.lbl_register') }}
                        </button>
                    @endif
                    <a onclick="javascript:gotoviewpage('{{ $request->mainmenu }}','{{ date('YmdHis') }}');" class="btn btn-danger box120 white"><i class="fa fa-times" aria-hidden="true"></i> {{ trans('messages.lbl_cancel') }} 
                    </a>  
            </div>
		</fieldset>
		{{ Form::close() }}
	</article>
</div>
{{ Form::open(array('name'=>'frminchargeaddeditcancel', 'id'=>'frminchargeaddeditcancel', 
                            'class' => 'form-horizontal',
                            'files'=>true,
                            'url' => 'Customer/CustomerView?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
                            'method' => 'POST')) }}
    {{ Form::hidden('custid',$request->custid, array('id' => 'custid')) }}
    {{ Form::hidden('id',$request->id, array('id' => 'id')) }} 
    {{ Form::hidden('editid', $request->editid, array('id' => 'editid')) }}
	{{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }}
    {{ Form::hidden('inchargeid', '', array('id' => 'inchargeid')) }}
{{ Form::close() }}                
@endsection