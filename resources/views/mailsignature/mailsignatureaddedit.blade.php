@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/settinglayout.css')) }}
{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::style(asset('public/css/footable.core.css')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::script(asset('public/js/footable.js')) }}
{{ HTML::script(asset('public/js/mailsignature.js')) }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	var mainmenu = '<?php echo $request->mainmenu; ?>';
	$(document).ready(function() {
		if($('#editflg').val()=="2"){
			$('#reghead').show();
			$('#regbtn').show();
			$('#regcancel').show();
		} else {
			$('#edithead').show();
			$('#updatebtn').show();
			$('#updatecancel').show();
		}
	});
</script>
<div class="" id="main_contents">
	<article id="mail" class="DEC_flex_wrapper" data-category="mail mail_sub_2">
		<fieldset class="mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/signature.png')  }}">
				<h2 class="h2cnt">{{ trans('messages.lbl_mailsignature') }}</h2>
				<h2 class="pull-left h2cnt">&#9642;</h2>
					<h2 class="pull-left mt10 red" id="edithead" style="display: none;">{{ trans('messages.lbl_edit') }}</h2>
					<h2 class="pull-left mt10 green" id="reghead" style="display: none;">{{ trans('messages.lbl_register') }}</h2>
			</div>
		</fieldset>
		@if (session('danger'))
		<div class="col-xs-12 mt10" align="center">
			<span class="alert-danger">{{ session('danger') }}</span>
		</div>
	@elseif (session('message'))
		<div class="col-xs-12 mt10" align="center">
			<span class="alert-success">{{ session('message') }}</span>
		</div>
	@endif
	{{ Form::open(array('name'=>'mailSignatureReg',
							'id'=>'mailSignatureReg',
							'class'=>'focusFields',
							'method' => 'POST',
							'files'=>true)) }}
							{{ Form::hidden('editflg',$request->editflg, array('id' => 'editflg')) }}
	{{ Form::hidden('updateprocess',$request->updateprocess, array('id' => 'updateprocess')) }}
	{{ Form::hidden('signatureId',(isset($getdataforupdate[0]->id)?$getdataforupdate[0]->id:""), array('id' => 'signatureId')) }}
		<fieldset id="hdnfield" class="mt10 mb10">
			<div class="col-xs-12 mt10 mb10">
				<div class="col-xs-3 lb tar" >
					<label for="name">{{ trans('messages.lbl_username')}}<span class="fr">&nbsp;&#42;</span></label>
				</div>
				<div class="col-xs-9 mw">
					{{ Form::hidden('userid',(isset($getdataforupdate[0]->user_ID)?$getdataforupdate[0]->user_ID:""),array('id'=>'userid')) }}
					{{ Form::text('txtuserid',(isset($getname)?$getname:""), array('id'=>'txtuserid', 
															'name' => 'txtuserid',
															'maxlength'=>'100',
															'class'=>'form-control txt dispinline txtuserid',
															'style' =>'width:50%',
															'readonly','readonly'
															)) }}
					<div class="dispinline">
						<button type="button" onclick="return popupenable('{{ $request->mainmenu }}');"
								class="button button-green" >
							<span class="fa fa-plus"></span> {{ trans('messages.lbl_browse')}}
						</button>
					</div>
					<div class="txtuserid_err dispinline"></div>
				</div>
				
			</div>
			<div class="col-xs-12 mt10 mb10">
				<div class="col-xs-3 lb tar" >
					<label for="name">{{ trans('messages.lbl_mailsignature')}}<span class="fr">&nbsp;&#42;</span></label>
				</div>
				<div class="col-xs-6 mw">
					{{ Form::textarea('content', (isset($getdataforupdate[0]->content)?$getdataforupdate[0]->content:""), array('id'=>'content', 
															'name' => 'content',
															'class'=>'form-control txt-mw content dispinline textareaResizeNone',
															'style'=>'width:80%;',
															'size' => '30x10')) }}
					<div class="content_err dispinline"></div>
				</div>
			</div>
		</fieldset>
		<fieldset class="mt10 mb10">
			<div class="col-xs-12 mb10 mt10">
				<div class="col-xs-12 buttondes" style="text-align: center;">
					<button type="button" class="button button-orange mailSignatureRegister" id="updatebtn" style="display: none;">
						<i class="fa fa-edit"></i>&nbsp;{{ trans('messages.lbl_update') }}
					</button>
					&emsp;
					<button type="button" class="button button-green mailSignatureRegister" id="regbtn" style="display: none;">
						<i class="fa fa-plus"></i>&nbsp;{{ trans('messages.lbl_register')}}
					</button>
					&emsp;
					<a href="javascript:fngotoback();" class="button button-red textDecNone">
						<span class="fa fa-remove"></span> {{ trans('messages.lbl_cancel') }}
					</a>
				</div>
			</div>
	</fieldset>
		<div id="mailsignaturepopup" class="modal fade" style="width: 775px;">
			<div id="login-overlay">
				<div class="modal-content">
				<!-- Popup will be loaded here -->
				</div>
			</div>
		</div>
	</article>
</div>
@endsection