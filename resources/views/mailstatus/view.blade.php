@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::script(asset('public/js/mailstatus.js')) }}
<div class="" id="main_contents">
	<!-- article to select the main&sub menu -->
<article id="mail" class="DEC_flex_wrapper" data-category="mail mail_sub_3">
	<fieldset class="mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/signature.png')  }}">
			<h2 class="h2cnt">{{ trans('messages.lbl_mailstatus') }}</h2>
			<h2 class="pull-left h2cnt">&#9642;</h2> 
			<h2 class="pull-left h2cnt" style="color:blue;">{{ trans('messages.lbl_view') }}
			</h2>
		</div>
	</fieldset>
	<div class="col-xs-12 pull-left mt10 mb10">
		<a href="javascript:fnback();" class="button button-blue textDecNone" 
			style="text-decoration: none !important;">
			<span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}
		</a>
	</div>
	{{ Form::open(array('name'=>'mailStatusView',
			'id'=>'mailStatusView',
			'url' => 'mail/mailcontentView?time='.date('YmdHis'), 
			'method' => 'POST')) }}
	<fieldset class="mt2">		
		<div class="col-xs-12">
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar lb">
					{{ Form::label('mailnum', trans('messages.lbl_companyName'), array('class' => 'mailnum clr_blue')) }}
				</div>
				<div class="col-xs-8 fontcolor fwb mw clr_black" style="word-break: break-word;">
					{{ $singlemailstatus[0]->customer_name }}
				</div>
			</div>
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar lb">
					{{ Form::label('mailnum', trans('messages.lbl_to'), array('class' => 'mailnum clr_blue')) }}
				</div>
				<div class="col-xs-8 fontcolor fwb mw clr_black" style="word-break: break-word;">
					@if($singlemailstatus[0]->toMail !="")
					<div class="col-xs-12 pm0">
					<?php $extomail = explode(",", $singlemailstatus[0]->toMail); ?>
						<div class="col-xs-12 pm0">
							<?php for ($i=0; $i < count($extomail); $i++) { ?>
							<div class="col-xs-12 pm0">
								{{ $extomail[$i] }}<?php if(count($extomail)-1 != $i) { echo ","; } ?>
							</div>
							<?php } ?>
						</div>
					</div>
					@else
						{{ "NILL" }}
					@endif
				</div>
			</div>
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar lb">
					{{ Form::label('mailnum', trans('messages.lbl_cc'), array('class' => 'mailnum clr_blue')) }}
				</div>
				<div class="col-xs-8 fontcolor fwb mw clr_black" style="word-break: break-word;">
					@if($singlemailstatus[0]->cc !="")
					<div class="col-xs-12 pm0">
					<?php $excc = explode(",", $singlemailstatus[0]->cc); ?>
						<div class="col-xs-12 pm0">
							<?php for ($i=0; $i < count($excc); $i++) { ?>
							<div class="col-xs-12 pm0">
								{{ $excc[$i] }}<?php if(count($excc)-1 != $i) { echo ","; } ?>
							</div>
							<?php } ?>
						</div>
					</div>
					@else
						{{ "NILL" }}
					@endif
				</div>
			</div>
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar lb">
					{{ Form::label('mailnum', trans('messages.lbl_subject'), array('class' => 'mailnum clr_blue')) }}
				</div>
				<div class="col-xs-8 fontcolor fwb mw clr_black" style="word-break: break-word;">
					@if($singlemailstatus[0]->subject !="")
						{{ $singlemailstatus[0]->subject }}
					@else
						{{ "NILL" }}
					@endif
				</div>
			</div>
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar lb">
					{{ Form::label('mailnum', trans('messages.lbl_content'), array('class' => 'mailnum clr_blue')) }}
				</div>
				<div class="col-xs-8 fontcolor fwb mw clr_black" style="word-break: break-word;">
					@if($singlemailstatus[0]->content !="")
	            		{!! nl2br(e($singlemailstatus[0]->content)) !!}
					@else
						{{ "NILL" }}
					@endif
				</div>
			</div>
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar lb">
					{{ Form::label('mailnum', trans('messages.lbl_fileName'), array('class' => 'mailnum clr_blue')) }}
				</div>
				<div class="col-xs-8 fontcolor fwb mw clr_black" style="word-break: break-word;">
					@if($singlemailstatus[0]->pdfNames !="")
						{{$singlemailstatus[0]->pdfNames}}
						@if($singlemailstatus[0]->excelNames !="")
							<br>{{$singlemailstatus[0]->excelNames}}
						@endif
					@else
						{{ "NILL" }}
					@endif
				</div>

			</div>
			<div class="col-xs-9 mt10">
				<div class="col-xs-4 tar lb">
					{{ Form::label('mailnum', trans('messages.lbl_attachmentCnt'), array('class' => 'mailnum clr_blue')) }}
				</div>
				<div class="col-xs-8 fontcolor fwb mw clr_black" style="word-break: break-word;">
					@if($singlemailstatus[0]->attachCount !="")
						{{ $singlemailstatus[0]->attachCount }}
					@else
						{{ "NILL" }}
					@endif
				</div>
			</div>
		</div>	
	</fieldset>	
	{{ Form::close() }}		
</article>
</div>
@endsection