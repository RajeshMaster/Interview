@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/mail.js')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
</script>
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
	<article id="mail" class="DEC_flex_wrapper" data-category="mail mail_sub_2">
		<fieldset class="mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/mail.png')  }}">
				<h2 class="h2cnt">{{ trans('messages.lbl_mailstatus') }}</h2>
				<h2 class="pull-left h2cnt">&#9642;</h2> 
				<h2 class="pull-left h2cnt" style="color:blue;">{{ trans('messages.lbl_view') }}
				</h2>
			</div>
		</fieldset>
		<div class="col-xs-12 pull-left mt10 mb10 ">
			<a href="javascript:fnredirectmailstatus();" class="button button-blue textDecNone" 
				style="text-decoration: none !important;">
				<span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}
			</a>
		</div>
		{{ Form::open(array('name'=>'mailView',
		'id'=>'mailView',
		'url' => 'mail/mailView?menuid='.$request->menuid.'&time='.date('YmdHis'), 
		'method' => 'POST')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('menuid', $request->menuid , array('id' => 'menuid')) }}
		{{ Form::hidden('filval', $request->filval , array('id' => 'filval')) }}
		{{ Form::hidden('fileflg', '' , array('id' => 'fileflg')) }}
		{{ Form::hidden('mailid', $request->mailid , array('id' => 'mailid')) }}
		<fieldset class="mt20 mb20">
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 lb tar">
					<label>{{ trans('messages.lbl_username')}}</label>
				</div>
				<div class="col-xs-8 mw" style="word-wrap: break-word;">
					@if($mailView[0]->lastName =="")
						<span>{{ trans('messages.lbl_nil')}}</span>
					@else 
						{{ucwords(strtolower($mailView[0]-> lastName))}}
					@endif
					
				</div>
			</div>
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 lb tar">
					<label>{{ trans('messages.lbl_to')}}</label>
				</div>
				<div class="col-xs-8 mw" style="word-wrap: break-word;">
					@if($mailView[0]->toMail =="")
						<span>{{ trans('messages.lbl_nil')}}</span>
					@else 
					<span>{!! nl2br(e($mailView[0]->toMail)) !!}</span>
					@endif
				</div>
			</div>
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 lb tar" >
					<label>{{ trans('messages.lbl_subject')}}</label>
				</div>
				<div class="col-xs-8 mw" style="word-wrap: break-word;">
					@if($mailView[0]->subject =="")
						<span>{{ trans('messages.lbl_nil')}}</span>
					@else
						<span>{!! nl2br(e($mailView[0]->subject)) !!}</span>
					@endif
				</div>
			</div>
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 lb tar">
					<label>{{ trans('messages.lbl_senddatetime')}}</label>
				</div>
				<div class="col-xs-8 mw">
					@if($mailView[0]->subject =="")
						<span>{{ trans('messages.lbl_nil')}}</span>
					@else
						{{ $mailView[0]->createdDateTime }}
					@endif
				</div>
			</div>
			<div class="col-xs-9 mt10 mb10">
				<div class="col-xs-4 lb tar">
					<label>{{ trans('messages.lbl_mailcontent')}}</label>
				</div>
				<div class="col-xs-8 mw">
					@if($mailView[0]->content =="")
						<span>{{ trans('messages.lbl_nil')}}</span>
					@else
						@if(substr($mailView[0]->content, 1, 3) == 'div')
							{!!html_entity_decode($mailView[0]->content)!!}
						@else
							{!! nl2br(e($mailView[0]->content)) !!}
						@endif
					@endif
				</div>
			</div>
		</fieldset>
		{{ Form::close() }}
@endsection