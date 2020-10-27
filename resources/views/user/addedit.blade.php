@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/user.js')) }}
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
		.lengthsetText {
			width:90%;
		}
		.btnlengthset {
			width:30%;
		}
		.lengthsetdate {
			width:76%;
		}
		.btnlengthsetmob {
			width:23%;
		}
		.btnlengthsetmob2 {
			width:27%;
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
		.lengthsetText {
			width:30%;
		}
		.lengthsetdate {
			width:27%;
		}
		.btnlengthset {
			width:15%;
		}
		.btnlengthsetmob {
			width:8%;
		}
		.btnlengthsetmob2 {
			width:8%;
		}
	}
</style>
<?php use App\Http\Helpers; ?>
	<div class="" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="settings" class="DEC_flex_wrapper" data-category="settings setting_sub_2">
		<fieldset class="mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/employee.png')  }}">
				<h2 class="pull-left h2cnt">{{trans('messages.lbl_user')}}</h2>
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

			{{ Form::open(array('name'=>'frmuseraddedit',
								'id'=>'frmuseraddedit',
								'class'=>'focusFields',
								'method' => 'POST',
								'url' => 'User/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
								'files'=>true)) }}

		{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('sortOptn',$request->usersort , array('id' => 'sortOptn')) }}
		{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
		{{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
		{{ Form::hidden('editflg', $request->editflg, array('id' => 'editflg')) }}
		{{ Form::hidden('id', '', array('id' => 'id')) }}
		{{ Form::hidden('viewid', $request->editid, array('id' => 'viewid')) }}
		{{ Form::hidden('editid', $request->editid, array('id' => 'editid')) }}
		{{ Form::hidden('DOB', $dob_year, array('id' => 'DOB')) }}
		{{ Form::hidden('hdnuserclassification', Session::get('userclassification'), array('id' => 'hdnuserclassification')) }}

		<fieldset id="hdnfield" class="mt10">
			@if($request->editflg =="edit")
				<div class="col-xs-12 mt10">
					<div class="col-xs-3 lb tar" >
						<label>{{ trans('messages.lbl_usercode') }}<span class="fr ml10 red">&nbsp;&#42;</span></label>
					</div>
					<div class="col-xs-7 mw">
						{{ ($userview[0]->usercode != "") ? $userview[0]->usercode : 'Nill'}}
					</div>
				</div>
			@endif

			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb tar" >
					<label>{{ trans('messages.lbl_userid') }}<span class="fr ml10 red">&nbsp;&#42;</span></label>
				</div>
				<div class="col-xs-7 mw">
					{{ Form::text('MstuserUserID',(isset($userview[0]->userid)) ? $userview[0]->userid : 										'',array('id'=>'MstuserUserID',
								'name' => 'MstuserUserID',
								'data-label' => trans('messages.lbl_userid'),
								'class'=>'lengthsetText form-control pl5 dispinline')) 
					}}
					<div class="MstuserUserID_err dispinline"></div>
					<div id="errorSectiondisplay" align="center"></div>
				</div>
			</div>


			@if($request->editflg !="edit")

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 lb tar" >
						<label>{{ trans('messages.lbl_password') }}<span class="fr ml10 red">&nbsp;&#42;</span></label>
					</div>
					<div class="col-xs-7 mw">
						{{ Form::password('MstuserPassword',array('id'=>'MstuserPassword',
																'name' => 'MstuserPassword',
																'data-label' => trans('messages.lbl_password'),
																'class'=>'lengthsetText form-control pl5 dispinline')) 
						}}
						<div class="MstuserPassword_err dispinline"></div>
					</div>
				</div>

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 lb tar" >
						<label>{{ trans('messages.lbl_confirmpassword') }}<span class="fr ml10 red">&nbsp;&#42;</span></label>
					</div>
					<div class="col-xs-7 mw">
						{{ Form::password('MstuserConPassword',array('id'=>'MstuserConPassword',
																'name' => 'MstuserConPassword',
																'data-label' => trans('messages.lbl_confirmpassword'),
																'class'=>'lengthsetText form-control pl5 dispinline')) 
						}}
						<div class="MstuserConPassword_err dispinline"></div>
					</div>
				</div>

			@endif


			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb tar" >
					<label for="name">{{ trans('messages.lbl_userclassification')}}<span class="fr">&nbsp;&#42;</span></label>
				</div>

				<div class="col-xs-7 mw">
					{{ Form::select('MstuserUserKbn',[null=>''] + $Classificationarray,(isset($userview[0]->userclassification)) ? 	$userview[0]->userclassification : '', array('name' => 'MstuserUserKbn',
																'id'=>'MstuserUserKbn',
																'data-label' => trans('messages.lbl_userclassification'),
																'onchange'=>'javascript:fnopendate(this.value);fnempty();',
																'class'=>'pl5 lengthsetText form-control dispinline'))
					}}
					<div class="MstuserUserKbn_err dispinline"></div>
				</div>
			</div>

			<!-- @if(Session::get('userclassification') != 4)
				{{ Form::hidden('DataView', (isset($userview[0]->accessDate)) ? $userview[0]->accessDate : '', array('id' => 'DataView')) }}
			@endif

			@if(Session::get('userclassification') == 4)

				<div class="col-xs-12 mt10">
					<div class="col-xs-3 lb tar" >
						<label for="name"> Eligible From Date<span class="fr">&nbsp;&#42;</span></label>
					</div>
					<div class="col-xs-7 mw">
						{{ Form::text('DataView',(isset($userview[0]->accessDate)) ? $userview[0]->accessDate : 										'',array('id'=>'DataView','name' => 'DataView',
													'data-label' => trans('Data View Date'),
													'class'=>'form-control pl5 lengthsetdate dataview dispinline')) 
						}}
						<label class="mt10 ml2 fa fa-calendar fa-lg" for="DataView" aria-hidden="true"></label>
						<div class="doj_err dispinline"></div>
					</div>
				</div>

			@endif -->


			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb tar" >
					<label>{{ trans('messages.lbl_unamesurname') }}<span class="fr ml10 red">&nbsp;&#42;</span></label>
				</div>
				<div class="col-xs-7 mw">
					{{ Form::text('MstuserSurNM',(isset($userview[0]->username)) ? $userview[0]->username : 													'',array('id'=>'MstuserSurNM',
														'name' => 'MstuserSurNM',
														'data-label' => trans('messages.lbl_unamesurname'),
														'class'=>'lengthsetText form-control pl5 dispinline')) 

					}}
					<div class="MstuserSurNM_err dispinline"></div>
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb tar" >
					<label>{{ trans('messages.lbl_givenname') }}<span class="fr ml10 red">&nbsp;&#42;</span></label>
				</div>
				<div class="col-xs-7 mw">
					{{ Form::text('MstuserSurNMK',(isset($userview[0]->givenname)) ? $userview[0]->givenname : 														'',array('id'=>'MstuserSurNMK',
													 'name' => 'MstuserSurNMK',
													 'data-label' => trans('messages.lbl_givenname'),
													 'class'=>'lengthsetText form-control pl5 dispinline')) 
					}}
					<div class="MstuserSurNMK_err dispinline"></div>
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb tar" >
					<label>{{ trans('messages.lbl_nickname') }}<span class="fr ml10 red">&nbsp;&#42;</span></label>
				</div>
				<div class="col-xs-7 mw">
					{{ Form::text('Mstusernickname',(isset($userview[0]->nickName)) ? $userview[0]->nickName : 														'',array('id'=>'Mstusernickname', 
													'name' => 'Mstusernickname',
													'data-label' => trans('messages.lbl_nickname'),
													'class'=>'lengthsetText form-control pl5 dispinline')) 
					}}
					<div class="Mstusernickname_err dispinline"></div>
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb tar" >
					<label for="name">{{ trans('messages.lbl_dob')}}<span class="fr">&nbsp;&#42;</span></label>
				</div>
				<div class="col-xs-7 mw">
					{{ Form::text('MstuserBirthDT',(isset($userview[0]->dob) && ($userview[0]->dob)!="0000-00-00") ? $userview[0]->								dob : '',array('id'=>'MstuserBirthDT',
																'name' => 'MstuserBirthDT',
																'data-label' => trans('messages.lbl_dob'),
																'class'=>'lengthsetdate form-control pl5 dob dispinline')) 
					}}
					<label class="mt10 ml2 fa fa-calendar fa-lg" for="MstuserBirthDT" aria-hidden="true"></label>
					<div class="MstuserBirthDT_err dispinline"></div>
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb tar" >
					<label for="name">{{ trans('messages.lbl_gender')}}<span class="fr">&nbsp;&#42;</span></label>
				</div>
				<div class="col-xs-7 mw" style="">
	            	<label style="font-weight: normal;">
						{{ Form::radio('MstuserSex', '1',(isset($userview[0]->gender) && ($userview[0]->gender)=="1") ? $userview[0]->							gender : '', array('id' =>'MstuserSex1',
																'name' => 'MstuserSex',
																'class' => 'comp',
																'data-label' => trans('messages.lbl_gender'))) 
						}}
						<span class="vam">&nbsp;{{ trans('messages.lbl_male') }}&nbsp;</span>
					</label>
					<label style="font-weight: normal;">
						{{ Form::radio('MstuserSex', '2',(isset($userview[0]->gender) && ($userview[0]->gender)=="2") ? $userview[						0]->gender : '', array('id' =>'MstuserSex2',
																	'name' => 'MstuserSex',
																	'class' => 'ntcomp',
																	'data-label' => trans('messages.lbl_gender')))
						}}
					<span class="vam">&nbsp;{{ trans('messages.lbl_female') }}&nbsp;</span>
					</label>
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb tar" >
					<label for="name">{{ trans('messages.lbl_mobileno')}}<span class="fr">&nbsp;&#42;</span></label>
				</div>
				<div class="col-xs-7 mw" style="">

					@if(isset($userview[0]->mobileno))
						{{--*/ $mobile = explode('-',$userview[0]->mobileno);/*--}}
						@if(!isset($mobile[0]))  {{$mobile[0]=""}} @endif
						@if(!isset($mobile[1]))  {{$mobile[1]=""}} @endif
						@if(!isset($mobile[2]))  {{$mobile[2]=""}} @endif
					@else
						{{$mobile[0]=""}}
						{{$mobile[1]=""}}
						{{$mobile[2]=""}}
					@endif

					{{ Form::text('MstuserTelNO',$mobile[0],array('id'=>'MstuserTelNO', 
															'name' => 'MstuserTelNO',
															'maxlength' => '3',
															'class'=>'btnlengthsetmob form-control pl5 dispinline',
															'data-label' => trans('messages.lbl_mobilenumber'),
															'onkeydown' => 'return nextfield("MstuserTelNO","MstuserTelNO1","3",event)',
															'onkeypress' => 'return isNumberKey(event)')) }} -

					{{ Form::text('MstuserTelNO1',$mobile[1],array('id'=>'MstuserTelNO1',
															'name' => 'MstuserTelNO1',
															'maxlength' => '4',
															'class'=>'btnlengthsetmob2 form-control pl5 dispinline',
															'data-label' => trans('messages.lbl_mobilenumber'),
															'onkeydown' => 'return nextfield("MstuserTelNO1","MstuserTelNO2","4",event)',
															'onkeypress' => 'return isNumberKey(event)')) }} -

					{{ Form::text('MstuserTelNO2',$mobile[2],array('id'=>'MstuserTelNO2',
															'name' => 'MstuserTelNO2',
															'maxlength' => '4',
															'class'=>'btnlengthsetmob2 form-control pl5 dispinline',
															'data-label' => trans('messages.lbl_mobilenumber'),
															'onkeypress' => 'return isNumberKey(event)')) }}
					<span>&nbsp;(Ex: 080-3138-4449）</span>
					<div class="MobileNo_err dispinline"></div>
				</div>
			</div>

			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb tar" >
					<label for="name">{{ trans('messages.lbl_email')}}<span class="fr">&nbsp;&#42;</span></label>
				</div>
				<div class="col-xs-7 mw" style="">
					{{ Form::text('MstuserMailID',(isset($userview[0]->email)) ? $userview[0]->email : 															'',array('id'=>'MstuserMailID', 
														'name' => 'MstuserMailID',
														'data-label' => trans('messages.lbl_mailid'),
														'class'=>'lengthsetText form-control pl5 dispinline')) 
					}}
					<span>&nbsp;(Ex: info@XXX.co.jp）</span>
					<div class="Email_err dispinline"></div>
					<div id="errorSectiondisplay1" align="center"></div>
				</div>
			</div>

		</fieldset> 
		<fieldset class="mt10 mb10">
			<div class="col-xs-12 mb10 mt10">
				<div class="col-xs-12 buttondes" style="text-align: center;">
					@if($request->editflg =="edit")
						<button type="button" class="btn edit btn-warning box100 addeditprocess">
							<i class="fa fa-edit" aria-hidden="true"></i> {{ trans('messages.lbl_update') }}
						</button>
						<a onclick="javascript:gotoindexpage('1','{{ $request->mainmenu }}');" class="btn btn-danger box120 white"><i class="fa fa-times" aria-hidden="true"></i> {{trans('messages.lbl_cancel')}}
						</a>
					@else
						<button type="button" class="btn btn-success add box100 addeditprocess ml5">
							<i class="fa fa-plus" aria-hidden="true"></i> {{ trans('messages.lbl_register') }}
						</button>
						<a onclick="javascript:gotoindexpage('2','{{ $request->mainmenu }}');" class="btn btn-danger box120 white"><i class="fa fa-times" aria-hidden="true"></i> {{trans('messages.lbl_cancel')}}
						</a>
					@endif
				</div>
			</div>
		</fieldset>
		{{ Form::close() }}

		{{ Form::open(array('name'=>'frmuseraddeditcancel', 'id'=>'frmuseraddeditcancel', 'url' => 'Ourdetail/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,'method' => 'POST')) }}

			{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
			{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
			{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
			{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
			{{ Form::hidden('sortOptn',$request->usersort , array('id' => 'sortOptn')) }}
			{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
			{{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
			{{ Form::hidden('viewid', $request->editid, array('id' => 'viewid')) }}
			{{ Form::hidden('editid', $request->editid, array('id' => 'editid')) }}

		{{ Form::close() }}
		
	</article>
	</div>

	@if($request->editflg =="edit")
		<script type="text/javascript">
			fnopendate('{{ $userview[0]->userclassification }}');
		</script>
	@endif

@endsection