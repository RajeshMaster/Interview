@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/mailsignature.js')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::style(asset('public/css/designtable.css')) }}
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="mail" class="DEC_flex_wrapper" data-category="mail mail_sub_2">
	<fieldset class="mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/signature.png')  }}">
			<h2 class="h2cnt">{{ trans('messages.lbl_mailsignature') }}</h2>
			<h2 class="pull-left h2cnt">&#9642;</h2> 
			<h2 class="pull-left h2cnt" style="color:blue;">{{ trans('messages.lbl_view') }}
			</h2>
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
	<div class="col-xs-12 pull-left mt10 mb10">
		<a href="javascript:fnback();" class="button button-blue textDecNone" 
			style="text-decoration: none !important;">
			<span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}
		</a>
		<a href="javascript:gotoeditpage('{{ $mailSignatureView[0]->id }}');" 
			class="button button-orange textDecNone"
			style="text-decoration: none !important;">
			<span class="fa fa-edit"></span> {{ trans('messages.lbl_edit') }}
		</a>
	</div>
	{{ Form::open(array('name'=>'mailSignatureView',
			'id'=>'mailSignatureView',
			'url' => 'mail/mailcontentView?time='.date('YmdHis'), 
			'method' => 'POST')) }}
	{{ Form::hidden('mailid', $request->mailid , array('id' => 'mailid')) }}
	{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
	{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
	{{ Form::hidden('filvalhdn', $request->filvalhdn , array('id' => 'filvalhdn')) }}
	{{ Form::hidden('editflg', '', array('id' => 'editflg')) }}
	<fieldset class="mt2">
		<div class="col-xs-12">
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar lb">
					{{ Form::label('mailnum', trans('messages.lbl_mailsignatureid'), array('class' => 'mailnum clr_blue')) }}
				</div>
				<div class="col-xs-8 fontcolor fwb mw clr_black">
					{{ $mailSignatureView[0]->signID }}
				</div>
			</div>
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar lb">
					{{ Form::label('mailnum', trans('messages.lbl_userid'), array('class' => 'mailnum clr_blue')) }}
				</div>
				<div class="col-xs-8 fontcolor fwb mw clr_black">
					{{ $mailSignatureView[0]->user_ID }}
				</div>
			</div>
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar lb">
					{{ Form::label('mailnm', trans('messages.lbl_username'), array('class' => 'mailnm clr_blue')) }}
				</div>
				<div class="col-xs-8 mw clr_black mailname">
					{{ $mailSignatureView[0]->username }} {{ $mailSignatureView[0]->givenname }} 
								@if($mailSignatureView[0]->nickName != "")
									({{ $mailSignatureView[0]->nickName }})
								@else 
								@endif 
				</div>
			</div>
			
			<div class="col-xs-9 mt10 mb10">
				<div class="col-xs-4 tar">
					{{ Form::label('mailct', trans('messages.lbl_mailsignature'), array('class' => 'mailct clr_blue')) }}
				</div>
				<div class="col-xs-8 mw clr_black" style="word-break: break-word;">
					{!! nl2br(e($mailSignatureView[0]->content)) !!}
				</div>
			</div>
			
		</div>
	</fieldset>
	{{ Form::close() }}
</article>
</div>		
@endsection