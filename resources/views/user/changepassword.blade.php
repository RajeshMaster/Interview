@extends('layouts.app')
@section('content')

{{ HTML::script(asset('public/js/user.js')) }}

<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	var mainmenu = '<?php echo $request->mainmenu; ?>';
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
	<div class="" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="settings" class="DEC_flex_wrapper" data-category="settings setting_sub_2">
		<fieldset class="mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/passwordchange.png')  }}">
				<h2 class="pull-left h2cnt">{{trans('messages.lbl_passwordchange')}}</h2>
			</div>
		</fieldset>

		{{ Form::open(array('name'=>'frmpasswordchange','id'=>'frmpasswordchange', 'url' => 'user/passwordchangeprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,'method' => 'POST')) }}

		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('id', $request->id , array('id' => 'id')) }}
		{{ Form::hidden('viewid', $request->id , array('id' => 'viewid')) }}
		{{ Form::hidden('editid', $request->id , array('id' => 'editid')) }}


		<fieldset id="hdnfield" class="mt10">
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb tar" >
					<label>{{ trans('messages.lbl_usercode') }}<span class="fr ml10 red">&nbsp;&#42;</span></label>
				</div>
				<div class="col-xs-7 mw">
					{{ $view[0]->usercode }}
					<input type="hidden" name="hidusercode" id="hidusercode" value="{{$view[0]->usercode}}"><input type="hidden" name="hidpassword" id="hidpassword" value="{{$view[0]->password}}">
				</div>
			</div>
			@if(Session::get('usercode') == $view[0]->usercode)
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb tar" >
					<label>{{ trans('messages.lbl_oldpassword') }}<span class="fr ml10 red">&nbsp;&#42;</span></label>
				</div>
				<div class="col-xs-7 mw">
					{{ Form::password('MstuserOldPassword',array('id'=>'MstuserOldPassword',
															'name' => 'MstuserOldPassword',
															'data-label' => trans('messages.lbl_oldpassword'),
															'class'=>'lengthsetText form-control pl5 dispinline')) 
					}}
					<div class="MstuserOldPassword dispinline"></div>
					<div id="errorSectiondisplay" align="center"></div>
				</div>
			</div>
			@else
				{{ Form::hidden('MstuserOldPassword','', 
								array('name' => 'MstuserOldPassword',
									  'id'=>'MstuserOldPassword',
									  'data-label' => trans('messages.lbl_inchargename'),
									  'class'=>'form-control pl5mlength','readonly' => 'readonly',
									  'style'=>'width :50% !important;display :inline')) }}
			@endif
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

			<div class="col-xs-12 mt10 mb10">
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

		</fieldset> 

		<fieldset class="mt10 mb10">
			<div class="col-xs-12 mb10 mt10">
				<div class="col-xs-12 buttondes" style="text-align: center;">
					<button type="button" class="btn btn-success add box100 frmpasswordchange" >
						<i class="fa fa-key"></i>{{ trans('messages.lbl_register') }}
					</button>

					<a onclick="javascript:cancelpassword('view','{{ $request->mainmenu }}');" class="pageload btn btn-danger white"><span class="fa fa-times"></span> {{trans('messages.lbl_cancel')}}
					</a>
				</div>
			</div>
		</fieldset>
		{{ Form::close() }}
		
	</article>
</div>

@endsection