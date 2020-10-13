@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::script(asset('public/js/user.js')) }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	var mainmenu = '<?php echo $request->mainmenu; ?>';
</script>
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="settings" class="DEC_flex_wrapper" data-category="settings setting_sub_2">
	<fieldset class="mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/employee.png')  }}">
			<h2 class="h2cnt">{{ trans('messages.lbl_user') }}</h2>
			<h2 class="pull-left h2cnt">&#9642;</h2> 
			<h2 class="pull-left h2cnt" style="color:blue;">{{ trans('messages.lbl_view') }}
			</h2>
		</div>
	</fieldset>

	@if (session('danger'))
		<div class="col-xs-12 mt10" align="center">
			<span class="alert-danger">{{ session('danger') }}</span>
		</div>
	@endif
	
	@if(Session::has('success'))
		<div align="center" class="alertboxalign" role="alert">
			<p class="alert {{ Session::get('alert', Session::get('type') ) }}">
				{{ Session::get('success') }}
			</p>
		</div>
	@endif

	<div class="col-xs-12 pull-left mt10 mb10">
		<a href="javascript:goindexpage('{{ $request->mainmenu }}');" class="button button-blue textDecNone" 
			style="text-decoration: none !important;">
			<span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}
		</a>
		<a href="javascript:addeditview('edit','{{ $userview[0]->id }}');" 
			class="button button-orange textDecNonex ml10 pull-right "
			style="text-decoration: none !important;">
			<span class="fa fa-edit"></span> {{ trans('messages.lbl_edit') }}
		</a>
		<a href="javascript:passwordchange('{{ $request->mainmenu }}','{{ $userview[0]->id }}');" 
			class="button button-blue textDecNone  pull-right "
			style="text-decoration: none !important;">
			<span class="fa fa-key"></span> {{ trans('messages.lbl_passwordchange') }}
		</a>
	</div>

	{{ Form::open(array('name'=>'frmuserview',
			'id'=>'frmuserview',
			'url' => 'user/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
			'files'=>true,
			'method' => 'POST')) }}
		{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('sortOptn',$request->usersort , array('id' => 'sortOptn')) }}
		{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
		{{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
		{{ Form::hidden('editflg', '', array('id' => 'editflg')) }}
		{{ Form::hidden('id', $userview[0]->id , array('id' => 'id')) }}
		{{ Form::hidden('viewid', $request->viewid , array('id' => 'viewid')) }}
		{{ Form::hidden('editid', $userview[0]->id , array('id' => 'editid')) }}

	<fieldset class="mt2">
		<div class="col-xs-12">
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 lb tar">
					<label>{{ Form::label('lbl_usercode', trans('messages.lbl_usercode'), array('class' => 'lbl_usercode clr_blue')) }}</label>
				</div>
				<div class="col-xs-8 mw" style="word-wrap: break-word;">
					{{ ($userview[0]->usercode != "") ? $userview[0]->usercode : 'Nill'}}
				</div>
			</div>

			<div class="col-xs-9 mt10">
				<div class="col-xs-4 lb tar">
					<label>{{ Form::label('lbl_userid', trans('messages.lbl_userid'), array('class' => 'lbl_userid clr_blue')) }}</label>
				</div>
				<div class="col-xs-8 mw" style="word-wrap: break-word;">
					{{ ($userview[0]->userid != "") ? $userview[0]->userid : 'Nill'}}
				</div>
			</div>
			
			<div class="col-xs-9 mt10">
				<div class="col-xs-4  tar">
					{{ Form::label('lbl_userclassification', trans('messages.lbl_userclassification'), array('class' => 'lbl_userclassification clr_blue')) }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ ($userview[0]->userclassification != "") ? $userview[0]->userclassification : 'Nill'}}
				</div>
			</div>

			@if(Session::get('userclassification') == 4)
			<div class="col-xs-9 mt10">
				<div class="col-xs-4  tar">
					<label class="clr_blue">Data View Eligible From Date</label>
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ ($userview[0]->accessDate != "") ? $userview[0]->accessDate : 'Nill'}}
				</div>
			</div>
			@endif

			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar">
					{{ Form::label('lbl_username', trans('messages.lbl_unamesurname'), array('class' => 'lbl_username clr_blue')) }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ ($userview[0]->username != "") ? $userview[0]->username : 'Nill'}}
				</div>
			</div>

			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar">
					{{ Form::label('lbl_givenname', trans('messages.lbl_givenname'), array('class' => 'lbl_givenname clr_blue')) }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ ($userview[0]->givenname != "") ? $userview[0]->givenname : 'Nill'}}
				</div>
			</div>

			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar">
					{{ Form::label('lbl_nickname', trans('messages.lbl_nickname'), array('class' => 'lbl_nickname clr_blue')) }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ ($userview[0]->nickName != "") ? $userview[0]->nickName : 'Nill'}}
				</div>
			</div>

			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar">
					{{ Form::label('lbl_dob', trans('messages.lbl_dob'), array('class' => 'lbl_dob clr_blue')) }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ ($userview[0]->dob != "" && $userview[0]->dob != "0000-00-00") ? $userview[0]->dob : 'Nill'}}
				</div>
			</div>

			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar">
					{{ Form::label('lbl_gender', trans('messages.lbl_gender'), array('class' => 'lbl_gender clr_blue')) }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ ($userview[0]->gender != "") ? $userview[0]->gender : 'Nill'}}
				</div>
			</div>

			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar">
					{{ Form::label('lbl_mobilenum', trans('messages.lbl_mobilenumber'), array('class' => 'lbl_mobilenum clr_blue')) }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ ($userview[0]->mobileno != "") ? $userview[0]->mobileno : 'Nill'}}
				</div>
			</div>

			<div class="col-xs-9 mt10 mb10">
				<div class="col-xs-4 tar">
					{{ Form::label('lbl_mailid', trans('messages.lbl_mailid'), array('class' => 'lbl_mailid clr_blue')) }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ ($userview[0]->email != "") ? $userview[0]->email : 'Nill'}}
				</div>
			</div>
			
		</div>
	</fieldset>
	{{ Form::close() }}
</article>
</div>		
@endsection