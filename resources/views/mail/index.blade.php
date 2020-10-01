@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/mail.js')) }}
{{ HTML::style(asset('public/css/ullilayout.css')) }}
{{ HTML::style(asset('public/css/designtable.css')) }}
<style type="text/css">
.sort_asc {
	background-image:url({{ URL::asset('public/images/upArrow.png') }}) !important;
}
.sort_desc {
	background-image:url({{ URL::asset('public/images/downArrow.png') }}) !important;
}
</style>
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
	function pageClick(pageval) {
		$('#page').val(pageval);
		$('#mailcontentindx').attr('action', '../Mail/index'+'?mainmenu=menu_mail&time='+datetime);
		$("#mailcontentindx").submit();
	}
	function pageLimitClick(pagelimitval) {
		$('#page').val('');
		$('#plimit').val(pagelimitval);
		$('#mailcontentindx').attr('action', '../Mail/index'+'?mainmenu=menu_mail&time='+datetime);
		$("#mailcontentindx").submit();
	}
</script>
{{ Form::open(array('name'=>'mailcontentindx',
		'id'=>'mailcontentindx',
		'url' => 'Mail/mailcontent?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
		'method' => 'POST')) }}
{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
{{ Form::hidden('mailid', $request->mailid, array('id' => 'mailid')) }}
{{ Form::hidden('delflg', $request->delflg, array('id' => 'delflg')) }}
{{ Form::hidden('filvalhdn', '', array('id' => 'filvalhdn')) }}
{{ Form::hidden('editflg', '', array('id' => 'editflg')) }}
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="mail" class="DEC_flex_wrapper" data-category="mail mail_sub_1">
	<fieldset class="pm0 mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/mail.png')  }}">
			<h2 class="h2cnt">{{ trans('messages.lbl_mailcontent') }}</h2>
		</div>
	</fieldset>
	<div class="col-xs-12 pm0 pull-left mt5 mt13">
		<div class="pull-left">
			<button type="button" onclick="fngotoregister('{{ $request->mainmenu }}');"
					class="button button-green pull-right">
				<span class="fa fa-plus"></span> {{ trans('messages.lbl_mail')}}
			</button>
		</div>
		<div class="pull-left input-group mt6 filtermail">
			{{ Form::button(
							trans('messages.lbl_all'),
							array('class'=>'pageload btn btn-link filmail '.$disabledall,
							'type'=>'button',
							'onclick' => 'javascript:return fnfilter(1)')) 
			}}
			<span class = "filmail">|</span>
			{{ Form::button(
							trans('messages.lbl_use'),
							array('class'=>'pageload btn btn-link filmail '.$disableduse,
							'type'=>'button',
							'onclick' => 'javascript:return fnfilter(2)')) 
			}}
			<span class = "filmail">|</span>
			{{ Form::button(
							trans('messages.lbl_notuse'),
							array('class'=>'pageload btn btn-link filmail '.$disablednotuse,
							'type'=>'button',
							'onclick' => 'javascript:return fnfilter(3)')) 
			}}
		</div>
	</div>
	<div class="container bbgrey pm0">
		<ul class="list-group pm0 rowlist">
			@forelse ($mailcontent as $count => $content)
				<li class="list-group-item  col-xs-12" style="">
					<div class="inb col-xs-12 pm0 mt10 ml10">
						<div class="inb col-xs-12 pm0">
							<h4 class="">
								<a href="javascript:fncontentview('{{ $content->mailId }}');" 
									class="fwb">{{ $content->mailId }}</a>
							</h4>
						</div>
					</div>
					
					<div class="pull-left col-xs-12 pm0">
						<div class="inb col-xs-9 pm0 ml10">
							<span class="pm0">
								<span class="vam fwb">Name :</span>
								<span class="pm0">
									{{ $content->typeName }}
								</span>
							</span>
						</div>
					</div>
					<br>
					<div class="pull-left col-xs-12 pm0">
						<div class="inb col-xs-9 pm0 ml10">
							<span class="pm0">
								<span class="vam fwb">{{ trans('messages.lbl_mailtype') }} :</span>
								<span class="pm0">
									{{ $content->typeName }}
								</span>
							</span>
						</div>
					</div>
					<div class="pull-left col-xs-12 pm0">
						<div class="inb col-xs-9 pm0 ml10">
							<span class="pm0">
								<span class="vam fwb">{{ trans('messages.lbl_subject') }} :</span>
								<span class="pm0">
									{{ $content->subject }}
								</span>
							</span>
						</div>
						<div class="inb col-xs-3 pm0 mb10" style="float: right;padding-right:1%;">
							<span style="float: right;" class="inb pm0">
								@if($content->delFlg == 0)
								<span class="pm0">
									<a href="javascript:fndelflg('{{ '1' }}','{{ $content->mailId }}');" class="fwb">{{ trans('messages.lbl_use') }}</a>
								</span>
								@else
								<span class="pm0">
									<a href="javascript:fndelflg('{{ '0' }}','{{ $content->mailId }}');" class="fwb ftclr" id="notuse">
									{{ trans('messages.lbl_notuse') }}</a>
								</span>
								@endif
							</span>
						</div>
					</div>
				</li>
			@empty
				<span class="col-xs-12 fr" id="nodatafound" style="text-align : center">{{ trans('messages.lbl_nodatafound')}}</span>
			@endforelse
		</ul>
	</div>
	@if($mailcontent->total())
		<div class="text-center col-xs-12 pm0 pagealign">
			@if(!empty($mailcontent->total()))
				<span class="pull-left mt24 pagination1">{{ $mailcontent->firstItem() }}
					<span class="mt5 pagination2">～</span>
					{{ $mailcontent->lastItem() }} / {{ $mailcontent->total() }}
				</span>
			　@endif 
			<span class ="pagintion2">
			{{ $mailcontent->links() }}
			</span>
			<span class="pull-right pagination mt0">
				{{ $mailcontent->linkspagelimit() }}
			</span>
		</div>
	@endif 
	{{ Form::close() }}
</article>
</div>
@endsection