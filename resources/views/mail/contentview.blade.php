@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/mail.js')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::style(asset('public/css/designtable.css')) }}
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="mail" class="DEC_flex_wrapper" data-category="mail mail_sub_1">
	<fieldset class="mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/mail.png')  }}">
			<h2 class="h2cnt">{{ trans('messages.lbl_mailcontent') }}</h2>
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
		<a href="javascript:gotoeditpage('{{ $contentview[0]->mailId }}');" 
			class="button button-orange textDecNone"
			style="text-decoration: none !important;">
			<span class="fa fa-edit"></span> {{ trans('messages.lbl_edit') }}
		</a>
	</div>
	{{ Form::open(array('name'=>'mailcontentView',
			'id'=>'mailcontentView',
			'url' => 'mail/mailcontentView?time='.date('YmdHis'), 
			'method' => 'POST')) }}
	{{ Form::hidden('mailid', $request->mailid , array('id' => 'mailid')) }}
	{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
	{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
	{{ Form::hidden('filvalhdn', $request->filvalhdn , array('id' => 'filvalhdn')) }}
	<fieldset class="mt2">
		<div class="col-xs-12">
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar lb">
					{{ Form::label('mailnum', trans('messages.lbl_mailid'), array('class' => 'mailnum clr_blue')) }}
				</div>
				<div class="col-xs-8 fontcolor fwb mw clr_black">
					{{ $contentview[0]->mailId }}
				</div>
			</div>
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar lb">
					{{ Form::label('mailnm', trans('messages.lbl_mailname'), array('class' => 'mailnm clr_blue')) }}
				</div>
				<div class="col-xs-8 mw clr_black mailname">
					{{ $contentview[0]->mailName }}
				</div>
			</div>
			<div class="col-xs-9 mt10">
				<div class="col-xs-4  tar">
					{{ Form::label('mailsub', trans('messages.lbl_subject'), array('class' => 'mailsub clr_blue')) }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{ $contentview[0]->subject }}
				</div>
			</div>
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar">
					{{ Form::label('mailhr', trans('messages.lbl_header'), array('class' => 'mailhr clr_blue')) }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{{$contentview[0]->header }}
				</div>
			</div>
			<div class="col-xs-9 mt10 mb10">
				<div class="col-xs-4 tar">
					{{ Form::label('mailct', trans('messages.lbl_content'), array('class' => 'mailct clr_blue')) }}
				</div>
				<div class="col-xs-8 mw clr_black">
					{!! nl2br(e($contentview[0]->content)) !!}
				</div>
			</div>
		</div>
	</fieldset>
	{{ Form::close() }}
</article>
</div>		
@endsection