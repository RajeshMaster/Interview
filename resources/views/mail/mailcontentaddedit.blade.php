@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/mail.js')) }}
{{ HTML::style(asset('public/css/addeditlayout.css')) }}
{{ HTML::style(asset('public/css/designtable.css')) }}
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="mail" class="DEC_flex_wrapper" data-category="mail mail_sub_1">
	<fieldset class="mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/mail.png')  }}">
			<h2 class="pull-left h2cnt">{{trans('messages.lbl_mailcontent')}}</h2>
			<h2 class="pull-left h2cnt">&#9642;</h2>
			@if ($request->editflg=="1")
				<h2 class="pull-left mt10 red">{{ trans('messages.lbl_edit') }}</h2>
		    	{{ Form::hidden('mailid',$getdataforupdate[0]->mailId, array('id' => 'mainid')) }}
			@else
				<h2 class="pull-left mt10 green">{{ trans('messages.lbl_register') }}</h2>
			@endif
		</div>
	</fieldset>
	@if($request->editflg == 1)
	{{ Form::model($getdataforupdate[0],array('name'=>'mail_reg',
										'method' => 'POST',
										'class'=>'form-horizontal focusFields',
										'id'=>'mail_reg', 
										'files'=>true)) }}
		{{ Form::hidden('whichprocess',1, array('id' => 'whichprocess')) }}
		{{ Form::hidden('mailid', $request->mailid , array('id' => 'mailid')) }}
	@else
		{{ Form::open(array('name'=>'mail_reg',
							'id'=>'mail_reg',
							'class'=>'focusFields',
							'method' => 'POST',
							'files'=>true)) }}
		{{ Form::hidden('whichprocess',0, array('id' => 'whichprocess')) }}
	@endif
	{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
	{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
	<fieldset id="hdnfield" class="mt10">
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_mailname')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-6 mw">
				{{ Form::text('mailName',null, array('id'=>'mailName', 
														'name' => 'mailName',
														'maxlength'=>'100',
														'class'=>'form-control txt dispinline mailName',
														'style' =>'width:49%'
														)) }}
				<div class="mailname_err dispinline"></div>
			</div>
		</div>
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_mailsubject')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-6 mw">
				{{ Form::text('subject',null, array('id'=>'subject', 
															'name' => 'subject',
															'maxlength'=>'100',
															'class'=>'form-control txt dispinline subject',
															'style' =>'width:49%'
															)) }}
			<div class="mailSubject_err dispinline"></div>
			</div>
		</div>
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_mailtype')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-6 mw">
				{{ Form::select('mailtype',[null=>''] + $getmailtypes + ['999'=>'Other'], (isset($getdataforupdate[0]->mailType)?$getdataforupdate[0]->mailType:""),
									array('name' => 'mailtype',
										  'id'=>'mailtype',
										  'onchange' => 'javascript:fndisablecharge(this.value);',
										  'data-label' => trans('messages.lbl_mailtype'),
										  'style' => 'width:49%;',
										  'class'=>'form-control txt dispinline mailtype'))}}
				{{ Form::text('mailother','',array(
											'id'=>'mailother',
											'name' => 'mailother',
											'class'=>'box30per form-control mailother',
											'style' => 'display:none;padding:0px !important;margin:0px !important;',
											'data-label' => trans('messages.lbl_mailother'))) }}
			<div class="mailheader_err dispinline"></div>
			</div>
		</div>
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_content')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
				{{ Form::textarea('content', null, array('id'=>'content', 
															'name' => 'content',
															'class'=>'form-control txt-mw content dispinline textareaResizeNone',
															'style'=>'width:79%;',
															'size' => '30x10')) }}
			<div class="mailContent_err dispinline"></div>
			</div>
		</div>
	</fieldset> 
	<fieldset class="mt10 mb10">
		<div class="col-xs-12 mb10 mt10">
			<div class="col-xs-12 buttondes" style="text-align: center;">
				@if($request->editflg == 1)
					<button type="button" class="button button-orange mailRegister">
						<i class="fa fa-edit"></i>&nbsp;{{ trans('messages.lbl_update') }}
					</button>
					&emsp;
				@else
					<button type="button" class="button button-green mailRegister">
						<i class="fa fa-plus"></i>&nbsp;{{ trans('messages.lbl_register')}}
					</button>
					&emsp;
				@endif
				<a href="javascript:fngotoback();" class="button button-red textDecNone">
					<span class="fa fa-remove"></span> {{ trans('messages.lbl_cancel') }}
				</a>
			</div>
		</div>
	</fieldset>
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