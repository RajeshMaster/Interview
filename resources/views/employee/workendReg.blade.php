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
/*	$(document).ready(function() {
		setDatePicker18yearbefore("dob");
		setDatePicker("opd");
	});*/
</script>

<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="mail" class="DEC_flex_wrapper" data-category="employee emp_sub_1">
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

	<fieldset id="hdnfield" class="mt10">
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label>{{ trans('messages.lbl_empid') }}<span class="fr ml10 red">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw">
				{{ $request->empid }}
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_empName')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw">
				{{ $request->empname }}
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_cusname')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>

			<div class="col-xs-7 mw">
				@if(isset($staff[0]->customer_name))
					<span class="fwb">
						{{ $staff[0]->customer_name}}
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
				@endif
				<button data-toggle="modal" type="button" class="btn btn-success add" 
					style="width: 100px;height: 30px;margin-top: 5px;" 
					 onclick="return customerSelectPopup();">
					 <i class="fa fa-plus vat">{{ trans('messages.lbl_browse') }}</i>
				</button>
				<div class="customerName_err dispinline"></div>
			</div>
		</div>

		<div class="col-xs-12 mt6">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_branchName')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
				@if(isset($staff[0]->branch_name))
					<span class="fwb">
					{{ $staff[0]->branch_name}}
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
				@if(isset($staff[0]->incharge_name))
					<span class="fwb">
						{{ $staff[0]->incharge_name}}
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
				{{ Form::text('DateofBirth',(isset($empview[0]->DOB)) ? $empview[0]->DOB : '',array('id'=>'DateofBirth', 
												'name' => 'DateofBirth','maxlength' => 10,
												'autocomplete' => 'off',
												'onKeyPress'=>'return event.charCode >= 48 && event.charCode <= 57',
												'class'=>'ime_mode_disable form-control box40per dispinline dob DateofBirth',
												'data-label' => trans('messages.lbl_doj'))) }}
				
				<label class="mt10 ml2 fa fa-calendar fa-lg" for="DateofBirth" aria-hidden="true"></label>
				<div class="DateofBirth_err dispinline"></div>
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_workEdate')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
				{{ Form::text('DateofBirth',(isset($empview[0]->DOB)) ? $empview[0]->DOB : '',array('id'=>'DateofBirth', 
												'name' => 'DateofBirth','maxlength' => 10,
												'autocomplete' => 'off',
												'onKeyPress'=>'return event.charCode >= 48 && event.charCode <= 57',
												'class'=>'ime_mode_disable form-control box40per dispinline dob DateofBirth',
												'data-label' => trans('messages.lbl_doj'))) }}
				
				<label class="mt10 ml2 fa fa-calendar fa-lg" for="DateofBirth" aria-hidden="true"></label>
				<div class="DateofBirth_err dispinline"></div>
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_streetaddress')}}<span class="fr">&nbsp;&nbsp;&nbsp;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
			
				{{ Form::textarea('StreetAddress',"",array('id'=>'StreetAddress', 
												'name' => 'StreetAddress',
												'data-label' => trans('messages.lbl_streetaddress'),
												'class' => 'mlength ntcomp dispinline form-control ime_mode_disable StreetAddress',
												'style' => 'height:130px; ')) }}
				<div class="StreetAddress_err dispinline"></div>
			</div>
		</div>

	</fieldset> 
	<fieldset class="mt10 mb10">
		<div class="col-xs-12 mb10 mt10">
			<div class="col-xs-12 buttondes" style="text-align: center;">
				@if($request->editflg != "edit")
					<button type="button" class="button button-green empRegister">
						<i class="fa fa-plus"></i>&nbsp;{{ trans('messages.lbl_register')}}
					</button>
					&emsp;
				@else
					<button type="button" class="button button-orange empRegister">
						<i class="fa fa-edit"></i>&nbsp;{{ trans('messages.lbl_update') }}
					</button>
					&emsp;
				@endif
				<a href="javascript:fnbackEmpView();" class="button button-red textDecNone">
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