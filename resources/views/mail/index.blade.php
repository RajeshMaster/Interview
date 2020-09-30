@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/mail.js')) }}
{{ HTML::script(asset('public/js/footable.js')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::style(asset('public/css/footable.core.css')) }}
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="mail" class="DEC_flex_wrapper" data-category="mail mail_sub_1">
	<fieldset class="mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/mail.png')  }}">
			<h2 class="h2cnt">
				{{ trans('messages.lbl_mailcontent') }}
			</h2>
		</div>
	</fieldset>
	{{ Form::open(array('name'=>'frmcontentmindex', 
						'id'=>'frmcontentmindex', 
						'url' => 'Mailcontent/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
						'files'=>true,
						'method' => 'POST')) }}
		{{ Form::hidden('plimit', $request->plimit, array('id' => 'plimit')) }}
	<div class="col-xs-12 pm0 mt10 mb10 pull-left">
		<!-- Session msg -->
	@if(Session::has('success'))
		<div align="center" class="alertboxalign" role="alert">
			<p class="alert {{ Session::get('alert', Session::get('type') ) }}">
            {{ Session::get('success') }}
          	</p>
		</div>
	@endif
	@php Session::forget('success'); @endphp
<!-- Session msg -->
		<div class="col-xs-6 ml10 pm0 pull-left">
			<a href="javascript:fngotoregister('{{ $request->mainmenu }}');"  class="btn btn-success box125"><span class="fa fa-plus"></span> {{ trans('messages.lbl_register') }}</a>
		</div>
	</div>
	<div class="mr10 ml10 mt10">
		<div class="minh400">
			<table class="tablealternate box100per">
				<colgroup>
				   <col width="4%">
				   <col width="8%">
				   <col width="22%">
				   <col width="22%">
				   <col width="">
				</colgroup>
				<thead class="CMN_tbltheadcolor">
			   		<tr class="tableheader fwb tac"> 
				  		<th class="tac">{{ trans('messages.lbl_sno') }}</th>
				  		<th class="tac">{{ trans('messages.lbl_mailid') }}</th>
				  		<th class="tac">{{ trans('messages.lbl_mailname') }}</th>
				  		<th class="tac">{{ trans('messages.lbl_mailtype') }}</th>
				  		<th class="tac">{{ trans('messages.lbl_subject') }}</th>
			   		</tr>
			   	</thead>
			   	<tbody>
			   		@forelse($mailContent as $key => $data)
			   			<tr>
			   				<td class="text-center">
			   					{{ ($mailContent->currentpage()-1) * $mailContent->perpage()+$key+1 }}
			   				</td>
			   				<td class="text-center">
			   					<a class="anchorstyle" href="javascript:gotomailview('{{ $data->id }}');">{{ $data->mailId }}</a>
			   				</td>
			   				<td>
			   					{{ $data->mailName }}
			   				</td>
			   				<td class="">
			   					{{ $data->typeName }}
			   				</td>
			   				<td class="">
			   					{{ $data->subject }}
			   				</td>
			   			</tr>
			   		@empty
						<tr>
							<td class="text-center" colspan="3" style="color: red;">{{ trans('messages.lbl_nodatafound') }}</td>
						</tr>
					@endforelse
			   	</tbody>
			</table>
		</div>
	</div>
	<div class="text-center ml10">
		@if(!empty($mailContent->total()))
			<span class="pull-left mt24">
				{{ $mailContent->firstItem() }} ~ {{ $mailContent->lastItem() }} / {{ $mailContent->total() }}
			</span>
		@endif 
		{{ $mailContent->links() }}
		<div class="CMN_display_block flr pr10">
			{{ $mailContent->linkspagelimit() }}
		</div>
	</div>
	{{ Form::close() }}
	<script>
	  $('.footable').footable({
			calculateWidthOverride: function() {
				return { width: $(window).width() };
			}
		}); 
	</script>
</article>
</div>
@endsection