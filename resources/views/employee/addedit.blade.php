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
		setDatePicker18yearbefore("dob");
		setDatePicker("opd");
	});
</script>

<?php use App\Http\Helpers; ?>
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="mail" class="DEC_flex_wrapper" data-category="employee emp_sub_1">
	<fieldset class="mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/employee.png')  }}">
			<h2 class="pull-left h2cnt">{{trans('messages.lbl_employee')}}</h2>
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

		{{ Form::open(array('name'=>'employee_reg',
							'id'=>'employee_reg',
							'class'=>'focusFields',
							'method' => 'POST',
							'files'=>true)) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('empid', $request->empid , array('id' => 'empid')) }}
		{{ Form::hidden('editid', $request->editid, array('id' => 'editid')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('DOB', $dob_year, array('id' => 'DOB')) }}

	<fieldset id="hdnfield" class="mt10">
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label>{{ trans('messages.lbl_empid') }}<span class="fr ml10 red">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw">
				{{ $request->empid }}
				<div class="mailname_err dispinline"></div>
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_doj')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw">
				{{ Form::text('OpenDate',(isset($empview[0]->DOJ)) ? $empview[0]->DOJ : '',array('id'=>'OpenDate', 
												'name' => 'OpenDate','maxlength' => 10,
												'autocomplete' => 'off',
												'onKeyPress'=>'return event.charCode >= 48 && event.charCode <= 57',
												'class'=>'ime_mode_disable form-control box50per dispinline opd mlength',
												'data-label' => trans('messages.lbl_doj'))) }}
				<label class="mt10 ml2 fa fa-calendar fa-lg" for="OpenDate" aria-hidden="true"></label>
				<div class="doj_err dispinline"></div>
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_staffusersurname')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>

			<div class="col-xs-7 mw">
				{{ Form::text('Surname',(isset($empview[0]->FirstName)) ? $empview[0]->FirstName : '',array('id'=>'Surname', 
													'name' => 'Surname',
													'data-label' => trans('Sur Name'),
													'class'=>'form-control box50per dispinline mlength Surname')) }}
				<div class="Surname_err dispinline"></div>
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_staffusername')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
				{{ Form::text('Name',(isset($empview[0]->FirstName)) ? $empview[0]->FirstName : '',array('id'=>'Name', 
												'name' => 'Name',
												'data-label' => trans('messages.lbl_name'),
												'class'=>'form-control dispinline mlength Name')) }}
				<div class="Name_err dispinline"></div>
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_nickname')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
				{{ Form::text('nickName',(isset($empview[0]->nickname)) ? $empview[0]->nickname : '',array('id'=>'nickName', 
												'name' => 'nickName',
												'data-label' => trans('messages.lbl_name'),
												'class'=>'mlength dispinline form-control nickName')) }}
				<div class="nickName_err dispinline"></div>
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_gender')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
				@if(isset($empview[0]->Gender) == 1)
            		{{--*/ $checkM = "true";
            			   $checkF = ""; /*--}}
            	@else(isset($empview[0]->Gender) == 2)
            		{{--*/ $checkF = "true";
            			   $checkM = ""; /*--}}
            	@endif
            	<label style="font-weight: normal;">
					{{ Form::radio('Gender', '1',(isset($empview[0]->Gender) && ($empview[0]->Gender)=="1") ? $empview[0]->Gender : '', 
								array('id' =>'Gender1',
									  'name' => 'Gender',
									  'class' => 'comp',
									  'style' => 'margin:-2px 0 0 !important',
									  'data-label' => trans('messages.lbl_Gender'))) }}
					<span class="vam">&nbsp;{{ trans('messages.lbl_male') }}&nbsp;</span>
				</label>
				<label style="font-weight: normal;">
					{{ Form::radio('Gender', '2',(isset($empview[0]->Gender) && ($empview[0]->Gender)=="2") ? $empview[0]->Gender : '', 
								array('id' =>'Gender2',
									  'name' => 'Gender',
									  'class' => 'ntcomp',
									  'style' => 'margin:-2px 0 0 !important',
									  'data-label' => trans('messages.lbl_Gender'))) }}
				<span class="vam">&nbsp;{{ trans('messages.lbl_female') }}&nbsp;</span>
				</label>
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_dob')}}<span class="fr">&nbsp;&#42;</span></label>
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
				<label for="name">{{ trans('messages.lbl_mobileno')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
				{{ Form::text('MobileNo',(isset($empview[0]->Mobile1)) ? $empview[0]->Mobile1 : '',array('id'=>'MobileNo', 
													'name' => 'MobileNo',
													'maxlength' => '13',
													'data-label' => trans('messages.lbl_mobilenumber'),
													'class'=>' ntcomp form-control dispinline ime_mode_disable mlength MobileNo',
													'data-label' => trans('messages.lbl_mobilenumber'),
													'onkeypress' => 'return isNumberKeywithminus(event)')) }}
				<div class="MobileNo_err dispinline"></div>
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_email')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
				{{ Form::text('Email',(isset($empview[0]->Emailpersonal)) ? $empview[0]->Emailpersonal : '',array('id'=>'Email', 
												'name' => 'Email',
												'email' => 'email',
												'data-label' => trans('messages.lbl_email'),
												'class'=>'mlength ntcomp dispinline form-control ime_mode_disable email')) }}
				<div class="Email_err dispinline"></div>
			</div>
		</div>

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_streetaddress')}}<span class="fr">&nbsp;&nbsp;&nbsp;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
				@if(isset($empview[0]->Address1))
					<?php
						$address = "";
						if (!empty($empview[0]->Address1)) {
							if (is_numeric($empview[0]->Address1)) {
								if(isset($empview[0]->pincode) || isset($empview[0]->jpstate) || isset($empview[0]->jpaddress)) {
									$address = '〒'.$empview[0]->pincode.$empview[0]->jpstate.$empview[0]->jpaddress.$empview[0]->roomno.'号';
								} else {
									$address = $empview[0]->Address1;
								}
							} else {
								$address = $empview[0]->Address1;
							}
						}
					?>
				@else
					<?php $address = ""; ?>
				@endif
				{{ Form::textarea('StreetAddress',$address,array('id'=>'StreetAddress', 
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
@endsection