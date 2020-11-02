@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/addeditlayout.css')) }}
{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::script(asset('public/js/employment.js')) }}
{{ HTML::script(asset('public/js/lib/bootstrap-datepicker.min.js')) }}
{{ HTML::style(asset('public/css/lib/bootstrap-datetimepicker.min.css')) }}
{{ HTML::style(asset('public/css/lib/jquery.ui.autocomplete.css')) }}
{{ HTML::script(asset('public/js/lib/jquery-ui.min.js')) }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	var mainmenu = '<?php echo $request->mainmenu; ?>';
	$(document).ready(function() {
		setDatePickerBeforeCurrent("stDate");
		setDatePickerBeforeCurrent("enDate");
	});
</script>

<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="employee" class="DEC_flex_wrapper" data-category="employee emp_sub_2">
	<fieldset class="mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/employee.png')  }}">
			<h2 class="pull-left h2cnt">{{trans('messages.lbl_workEdate')}}</h2>
			<h2 class="pull-left h2cnt">&#9642;</h2>
			@if($request->editflg != "edit")
				<h2 class="pull-left h2cnt ml15" style="color: green;">
					{{ trans('messages.lbl_register')}}
				</h2>
			@else
				<h2 class="pull-left h2cnt ml5" style="color: red;">
					{{ trans('messages.lbl_edit')}}
				</h2>
			@endif
		</div>
	</fieldset>

		{{ Form::open(array('name'=>'workEndReg',
							'id'=>'workEndReg',
							'class'=>'focusFields',
							'method' => 'POST',
							'files'=>true)) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('empid', $request->empid , array('id' => 'empid')) }}
		{{ Form::hidden('editid', $request->editid, array('id' => 'editid')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('checkExist', isset($clientDtl->customer_name)?$clientDtl->customer_name:"" , array('id' => 'checkExist')) }}
		{{ Form::hidden('clientempId', isset($clientDtl->id)?$clientDtl->id:"" , array('id' => 'clientempId')) }}
		
	<fieldset id="hdnfield" class="">
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label>{{ trans('messages.lbl_empid') }}<span class="fr red">&nbsp;&nbsp;</span></label>
			</div>
			<div class="col-xs-7 mw">
				{{ $request->empid }}
			</div>
		</div>

		<div class="col-xs-12 ">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_empName')}}<span class="fr">&nbsp;&nbsp;</span></label>
			</div>
			<div class="col-xs-7 mw">
				{{ $request->empname }}
			</div>
		</div>

		<div class="col-xs-12">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_cusname')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>

			<div class="col-xs-7 mw">
				@if(isset($clientDtl->customer_name))
					<span class="fwb">
						{{ $clientDtl->customer_name}}
					</span>
				@else
					{{ Form::text('customerName','',array('id'=>'customerName', 
													'name' => 'customerName',
													'data-label' => trans('Sur Name'),
													'readonly' => 'true',
													'class'=>'form-control box50per dispinline mlength customerName')) }}
					{{ Form::hidden('customerId', "" , array('id' => 'customerId')) }}

			<!-- 		{{ Form::select('customerId',[null=>'']+$customerarray,'', 
						array('name' => 'customerId',
								'id'=>'customerId',
								'onchange'=>'fnGetbranchDetail();',
								'data-label' => trans('messages.lbl_cusname'),
								'readonly' => 'true',
								'class'=>'form-control dispinline ime_mode_disable pl5 mlength'))}} -->
				<button data-toggle="modal" type="button" class="btn btn-success add" 
					style="width: 100px;height: 30px;margin-top: 5px;" 
					 onclick="return customerSelectPopup();">
					 <i class="fa fa-plus vat">{{ trans('messages.lbl_browse') }}</i>
				</button>
				<div class="customerName_err dispinline"></div>
				@endif
				
			</div>
		</div>

		<div class="col-xs-12 mt8">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_branchName')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
				@if(isset($clientDtl->branch_name))
					<span class="fwb">
					{{ $clientDtl->branch_name}}
					</span>
				@else
					{{ Form::select('branchId',[null=>''],'', 
					array('name' => 'branchId',
					'id'=>'branchId',
					'onchange'=>'fnGetinchargeDetails();',
					'data-label' => trans('messages.lbl_branchname'),
					'class'=>'form-control dispinline pl5 mlength')) }}
				@endif 
				<div class="Name_err dispinline"></div>
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_inchargename')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
				@if(isset($clientDtl->incharge_name))
					<span class="fwb">
						{{ $clientDtl->incharge_name}}
					</span>
				@else
					{{ Form::select('inchargeDetails',[null=>''],'', 
						array('name' => 'inchargeDetails',
							  'id'=>'inchargeDetails',
							  'data-label' => trans('messages.lbl_inchargename'),
							  'class'=>'form-control dispinline pl5 mlength')) }}
				@endif 
				<div class="nickName_err dispinline"></div>
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_workStdate')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
				{{ Form::text('startDate',(isset($clientDtl->start_date)?$clientDtl->start_date:""),array('id'=>'startDate', 
												'name' => 'startDate','maxlength' => 10,
												'autocomplete' => 'off',
												'onKeyPress'=>'return event.charCode >= 48 && event.charCode <= 57',
												'class'=>'ime_mode_disable form-control box40per dispinline stDate startDate mlength',
												'data-label' => trans('messages.lbl_doj'))) }}
				<div class="startDate_err dispinline"></div>
				<label class="mt10 ml2 fa fa-calendar fa-lg" for="startDate" aria-hidden="true"></label>
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_workEdate')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
				{{ Form::text('endDate','',array('id'=>'endDate', 
												'name' => 'endDate','maxlength' => 10,
												'autocomplete' => 'off',
												'onKeyPress'=>'return event.charCode >= 48 && event.charCode <= 57',
												'class'=>'ime_mode_disable form-control box40per dispinline enDate endDate mlength' ,
												'data-label' => trans('messages.lbl_doj'))) }}
				<div class="endDate_err dispinline"></div>
				<div class="dategreatErr" style="display: none;color:#9C0000;"> Start Date Is greater than End Date</div>
				<label class="mt10 ml2 fa fa-calendar fa-lg" for="endDate" aria-hidden="true"></label>
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_remarks')}}<span class="fr">&nbsp;&nbsp;&nbsp;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
			
				{{ Form::textarea('remarks',"",array('id'=>'remarks',
												'name' => 'remarks',
												'data-label' => trans('messages.lbl_remarks'),
												'class' => 'mlength ntcomp dispinline form-control ime_mode_disable remarks',
												'style' => 'height:130px; ')) }}
				<div class="remarks_err dispinline"></div>
			</div>
		</div>

	</fieldset> 
	<fieldset class="mt10 mb10">
		<div class="col-xs-12 mb10 mt10">
			<div class="col-xs-12 buttondes" style="text-align: center;">
				@if(isset($clientDtl->customer_name))
					<button type="button" class="button button-orange wrkEndEdit">
						<i class="fa fa-edit"></i>&nbsp;{{ trans('messages.lbl_update') }}
					</button>
					&emsp;
				@else
					<button type="button" class="button button-green wrkEndRegister">
						<i class="fa fa-plus"></i>&nbsp;{{ trans('messages.lbl_register')}}
					</button>
					&emsp;
				@endif
				<a href="javascript:fnbackEmpindex();" class="button button-red textDecNone">
					<span class="fa fa-remove"></span> {{ trans('messages.lbl_cancel') }}
				</a>
			</div>
		</div>
	</fieldset>
	{{ Form::close() }}

	{{ Form::open(array('name'=>'frmaddeditcancel', 'id'=>'frmaddeditcancel', 'url' => 'Employee/view?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,'method' => 'POST')) }}
		{{ Form::hidden('empid', $request->empid , array('id' => 'empid')) }}
		{{ Form::hidden('editid', $request->editid, array('id' => 'editid')) }}
	{{ Form::close() }}
	
	<script type="text/javascript">
		var cancel_check = true;
		$('input, select, textarea').bind("change keyup paste", function() {
			cancel_check = false;
		});
	</script>
</article>
</div>

<div id="customerSelect" class="modal fade" style="width: 775px;">
	<div id="login-overlay">
		<div class="modal-content">
		<!-- Popup will be loaded here -->
		</div>
	</div>
</div>
@endsection