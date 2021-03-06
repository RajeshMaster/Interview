@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/mail.js')) }}
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
			<h2 class="h2cnt">{{ trans('messages.lbl_sendMail') }}</h2>
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
			{{ Form::button(trans('messages.lbl_all'),
							array('class'=>'pageload btn btn-link filmail',
							'type'=>'button',
							'onclick' => 'javascript:return fnfilter(1)' ,$disabledall)) 
			}}
			<span class = "filmail">|</span>
			{{ Form::button(trans('messages.lbl_use'),
							array('class'=>'pageload btn btn-link filmail',
							'type'=>'button',
							'onclick' => 'javascript:return fnfilter(2)',$disableduse)) 
			}}
			<span class = "filmail">|</span>
			{{ Form::button(trans('messages.lbl_notuse'),
							array('class'=>'pageload btn btn-link filmail',
							'type'=>'button',
							'onclick' => 'javascript:return fnfilter(3)',$disablednotuse)) 
			}}
		</div>
	</div>
	<div class="box100per tableShrink pt10 mnheight mb0">
		<table class="table-striped table footable table-bordered mt10 mb10" >
			<colgroup>
				<col width="5%">
				<col width="25%">
				<col width="30%">
				<col width="30%">
				<col width="10%">
				<col>
			</colgroup>
			<thead class="CMN_tbltheadcolor">
				<tr class="CMN_tbltheadcolor">
					<th class="tac fs10 sno">
						{{ trans('messages.lbl_sno') }}
					</th>
					<th class="tac fs10">
						{{ trans('messages.lbl_mailid') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_mailname') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_mailsubject') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						<!-- {{ trans('messages.lbl_branchName') }} -->
					</th>
				</tr>
			</thead>
			<tbody class="tablealternateclr">
				@forelse ($mailcontent as $count => $content)
					<tr>
						<td class="text-center">
							{{ ($mailcontent->currentpage()-1) * $mailcontent->perpage() + $count + 1 }}
						</td>
						<td class="text-center">
							<a href="javascript:fncontentview('{{ $content->mailId }}');" 
									class="fwb">{{ $content->mailId }}</a>
						</td>
						<td class="text-left">
							{{ $content->typeName }}
						</td>
						<td class="text-left">
							{{ $content->subject }}
						</td>
						
						<td class="text-left">
							@if($content->delFlg == 0)
								<span class="pm0">
									<a href="javascript:fndelflg('{{ '1' }}','{{ $content->mailId }}');" class="fwb">{{ trans('messages.lbl_use') }}</a>
								</span>
								@else
								<span class="pm0">
									<a href="javascript:fndelflg('{{ '0' }}','{{ $content->mailId }}');" class="fwb ftclr" id="notuse" style="color: red;">
									{{ trans('messages.lbl_notuse') }}</a>
								</span>
							@endif
						</td>
					</tr>
				@empty
					<tr class="nodata">
						<th class="text-center red nodatades" colspan="2">
							{{ trans('messages.lbl_nodatafound') }}
						</th>
					</tr>
					<tr class="nodata">
						<td class="text-center red nodatades1" colspan="5">
							{{ trans('messages.lbl_nodatafound') }}
						</td>
					</tr>
				@endforelse
			</tbody>
		</table>
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