@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::script(asset('public/js/employment.js')) }}
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
</script>
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
	<article id="mail" class="DEC_flex_wrapper" data-category="employee emp_sub_1">
		<fieldset class="mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/employee.png')  }}">
				<h2 class="h2cnt">{{ trans('messages.lbl_employee') }}</h2>
				<h2 class="pull-left h2cnt">&#9642;</h2> 
				<h2 class="pull-left h2cnt" style="color:blue;">{{ trans('messages.lbl_view') }}
				</h2>
			</div>
		</fieldset>
		<div class="col-xs-12 pull-left mt10 mb10 ">
			<a href="javascript:fnredirectemployee();" class="button pull-left button-blue textDecNone" 
				style="text-decoration: none !important;">
				<span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}
			</a>
			<a href="javascript:fnresignemployee();" class="button pull-right button-blue textDecNone ml20" 
				style="text-decoration: none !important;">
				<span class="fa fa-close"></span> {{ trans('messages.lbl_resign') }}
			</a>
			<a href="javascript:employeEdit('edit','{{ $request->empid }}');" class="button pull-right button-orange textDecNone" 
				style="text-decoration: none !important;">
				<span class="fa fa-pencil"></span> {{ trans('messages.lbl_edit') }}
			</a>
		</div>
		
		{{ Form::open(array('name'=>'employeeView',
		'id'=>'employeeView',
		'url' => 'Employee/view?menuid='.$request->menuid.'&time='.date('YmdHis'), 
		'method' => 'POST')) }}
			{{ Form::hidden('empid', $request->empid , array('id' => 'empid')) }}	
			{{ Form::hidden('editid', $request->editid , array('id' => 'editid')) }}
			{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
			{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
			{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
			{{ Form::hidden('editflg', '', array('id' => 'editflg')) }}
			{{ Form::hidden('resignid', $request->resignid , array('id' => 'resignid')) }}

		<!-- Session msg -->
		@if(Session::has('success'))
			<div class="col-xs-12 mt10" align="center">
				<span class="alert {{ Session::get('alert', Session::get('type') ) }}">
				{{ Session::get('success') }}
				</span>
			</div>
		@elseif (session('message'))
			<div class="col-xs-12 mt10" align="center">
				<span class="alert {{ Session::get('alert', Session::get('type') ) }}">
				{{ Session::get('success') }}
				</span>
			</div>
		@endif
		@php Session::forget('success'); @endphp
		<!-- Session msg -->

		<div>
			<fieldset class="mt20 mb20">
				<div class="col-xs-9 mt10">
					<div class="col-xs-4 lb tar">
						<label>{{ trans('messages.lbl_empid')}}</label>
					</div>
					<div class="col-xs-8 mw" style="word-wrap: break-word;">
						{{ ($empDetail[0]->Emp_ID != "") ? $empDetail[0]->Emp_ID : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-9 mt10">
					<div class="col-xs-4 lb tar">
						<label>{{ trans('messages.lbl_doj')}}</label>
					</div>
					<div class="col-xs-8 mw" style="word-wrap: break-word;">
						{{ ($empDetail[0]->DOJ != "") ? $empDetail[0]->DOJ : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-9 mt10">
					<div class="col-xs-4 lb tar" >
						<label>{{ trans('messages.lbl_staffusersurname')}}</label>
					</div>
					<div class="col-xs-8 mw" style="word-wrap: break-word;">
						{{ ($empDetail[0]->FirstName != "") ? $empDetail[0]->FirstName : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-9 mt10">
					<div class="col-xs-4 lb tar">
						<label>{{ trans('messages.lbl_staffusername')}}</label>
					</div>
					<div class="col-xs-8 mw">
						{{ ($empDetail[0]->LastName != "") ? $empDetail[0]->LastName : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-9 mt10">
					<div class="col-xs-4 lb tar">
						<label>{{ trans('messages.lbl_nickname')}}</label>
					</div>
					<div class="col-xs-8 mw">
						{{ ($empDetail[0]->nickname != "") ? $empDetail[0]->nickname : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-9 mt10 mb10">
					<div class="col-xs-4 lb tar">
						<label>{{ trans('messages.lbl_gender')}}</label>
					</div>
					<div class="col-xs-8 mw">
						{{ ($empDetail[0]->Gender == "1") ? trans('messages.lbl_male') : trans('messages.lbl_female')}}
					</div>
				</div>

				<div class="col-xs-9 mt10 mb10">
					<div class="col-xs-4 lb tar">
						<label>{{ trans('messages.lbl_dob')}}</label>
					</div>
					<div class="col-xs-8 mw">
						{{ ($empDetail[0]->DOB != "") ? $empDetail[0]->DOB : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-9 mt10 mb10">
					<div class="col-xs-4 lb tar">
						<label>{{ trans('messages.lbl_mobileno')}}</label>
					</div>
					<div class="col-xs-8 mw">
						{{ ($empDetail[0]->Mobile1 != "") ? $empDetail[0]->Mobile1 : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-9 mt10 mb10">
					<div class="col-xs-4 lb tar">
						<label>{{ trans('messages.lbl_mailid')}}</label>
					</div>
					<div class="col-xs-8 mw">
						{{ ($empDetail[0]->Emailpersonal != "") ? $empDetail[0]->Emailpersonal : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-9 mt10 mb10">
					<div class="col-xs-4 lb tar">
						<label>{{ trans('messages.lbl_streetaddress')}}</label>
					</div>
					<div class="col-xs-8 mw">
						@if(!empty($empDetail[0]->Address1))
							@if(is_numeric($empDetail[0]->Address1))
								@if(isset($empDetail[0]->pincode) || isset($empDetail[0]->jpstate) || isset($empDetail[0]->jpaddress))
									〒{{ $empDetail[0]->pincode }} {{ $empDetail[0]->jpstate }}{{ $empDetail[0]->jpaddress }} {{ $empDetail[0]->roomno }}号
								@else
									{{ $empDetail[0]->Address1 }}
								@endif
							@else
							  {!! nl2br(e($empDetail[0]->Address1)) !!}
							@endif
						@else
							NIL
						@endif
					</div>
				</div>

				<div class="col-xs-9 mt10 mb10">
					<div class="col-xs-4 lb tar">
						<label>{{ trans('messages.lbl_resigneddate')}}</label>
					</div>
					<div class="col-xs-8 mw">
						{{ ($empDetail[0]->resignedDate != "") ? $empDetail[0]->resignedDate : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-9 mt10 mb10">
					<div class="col-xs-4 lb tar">
						<label>{{ trans('messages.lbl_bankName')}}</label>
					</div>
					<div class="col-xs-8 mw">
						{{ ($empDetail[0]->BankName != "") ? $empDetail[0]->BankName : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-9 mt10 mb10">
					<div class="col-xs-4 lb tar">
						<label>{{ trans('messages.lbl_branchName')}}</label>
					</div>
					<div class="col-xs-8 mw">
						{{ ($empDetail[0]->BranchName != "") ? $empDetail[0]->BranchName : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-9 mt10 mb10">
					<div class="col-xs-4 lb tar">
						<label>{{ trans('messages.lbl_accountno')}}</label>
					</div>
					<div class="col-xs-8 mw">
						{{ ($empDetail[0]->AccNo != "") ? $empDetail[0]->AccNo : 'Nill'}}
					</div>
				</div>

				<div class="col-xs-9 mt10 mb10">
					<div class="col-xs-4 lb tar">
						<label>{{ trans('messages.lbl_branchnumber')}}</label>
					</div>
					<div class="col-xs-8 mw">
						{{ ($empDetail[0]->BranchNo != "") ? $empDetail[0]->BranchNo : 'Nill'}}
					</div>
				</div>
			</fieldset>

		</div>
		{{ Form::close() }}
@endsection