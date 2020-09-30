@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/mail.js')) }}
{{ HTML::script(asset('public/js/footable.js')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::style(asset('public/css/footable.core.css')) }}
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="mail" class="DEC_flex_wrapper" data-category="mail mail_sub_2">
	<fieldset class="mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/mail.png')  }}">
			<h2 class="h2cnt">
				{{trans('messages.lbl_mailstatus')}}
			</h2>
		</div>
	</fieldset>
	{{ Form::open(array('name'=>'mailstatus',
						 'id'=>'mailstatus', 
						 'url' => 'Mail/index?menuid='.$request->menuid.'&time='.date('YmdHis'), 
						 'method' => 'POST')) }}
	{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
	{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
	{{ Form::hidden('mailid', '' , array('id' => 'mailid')) }}
	{{ Form::hidden('filval', '' , array('id' => 'filval')) }}
		<div class="box100per tableShrink pt10 mnheight mb0">
			<table class="table-striped table footable table-bordered mt10 mb10" >
				<colgroup>
					<col width="5%">
					<col width="16%">
					<col width="">
					<col width="20%">
					<col width="16%">
					<col width="16%">
					<col width="5%">
				</colgroup>
				<thead class="CMN_tbltheadcolor" >
					<tr class="CMN_tbltheadcolor">
						<th class="tac fs10 sno">
							{{ trans('messages.lbl_sno') }}
						</th>
						<th class="tac fs10">
							{{ trans('messages.lbl_username') }}
						</th>
						<th data-hide="phone" class="tac fs10">
							{{ trans('messages.lbl_email') }}
						</th>
						<th data-hide="phone" class="tac fs10">
							{{ trans('messages.lbl_subject') }}
						</th>
						<th data-hide="phone" class="tac fs10">
							{{ trans('messages.lbl_mailsendby') }}
						</th>
						<th data-hide="phone" class="tac fs10">
							{{ trans('messages.lbl_senddatetime') }}
						</th>
						<th data-hide="phone" class="tac fs10">
						</th>
					</tr>
				</thead>
				<tbody class="tablealternateclr">
					{{ $temp = ""}}
					{{--*/ $row = '0' /*--}}
					{{ $tempcomp = ""}}
					{{--*/ $rowcomp = '0' /*--}}
					@forelse ($mailStatus as $count => $data)
						@php $cdata = $data ->lastName @endphp
						{{--*/ $loc = $cdata /*--}}
						{{--*/ $loccomp = $data->toMail /*--}}
						@if($loc != $temp) 
						@if($row==1)
						{{--*/ $row = '0' /*--}}
						@else
						{{--*/ $row = '1' /*--}}
						@endif
						{{--*/ $style_td = 'border-bottom: none;' /*--}}
						@else
						{{--*/ $style_td = 'border-top: none;border-bottom: none;' /*--}}
						@endif
						@if($loccomp != $tempcomp) 
						@if($rowcomp==1)
						{{--*/ $row = '0' /*--}}
						@else
						{{--*/ $row = '1' /*--}}
						@endif
						{{--*/ $style_tdcomp = 'border-bottom: none;' /*--}}
						@else
						{{--*/ $style_tdcomp = 'border-top: none;border-bottom: none;' /*--}}
					@endif
					<tr>
						<td class="text-center vam">
							{{ ($mailStatus->currentpage()-1) * $mailStatus->perpage() + $count + 1 }}
						</td>
						<td class="tal" style="{{$style_td}}" 
							title="{{ singlefieldtitle($data ->lastName, 18) }}">
							@php 
							$lastName = ucwords(strtolower($data ->lastName));
							if($lastName != "") {
								if($loc != $temp) {
									if(strlen($lastName) > 18) {
										echo singlefieldlength($lastName,18);
									} else {
										echo $lastName;
									}
								}
							}
							@endphp

						</td>
						<td class="tal" style="{{$style_tdcomp}}" 
							title="{{ singlefieldtitle($data ->toMail, 28) }}">
								@if(strlen($data->toMail) > 28)
									{{ singlefieldlength($data ->toMail,28) }}
								@else
									{{ $data ->toMail }}
								@endif
						</td>
						<td class="tal">
							@if($data ->subject =="")
								<span>{{ trans('messages.lbl_nil')}}</span>
							@else
								{{ $data ->subject }}
							@endif
						</td>
						<td class="tal">
							{{ $data ->createdBy }}
						</td>
						<td class="tac vam">
							{{ substr($data->createdDateTime,0,10) }} {{ substr($data->createdDateTime,11) }}
						</td>
						<td class="tac vam">
							<a href="javascript:mailview('<?php echo $data->id ?>');"><img title="{{ trans('messages.lbl_view') }}" class=" box15" src="{{ URL::asset('public/images/ourdetails.png')}}"></a>
						</td>
					</tr>
					{{--*/ $temp = $loc /*--}}
						@empty
						<tr class="nodata">
							<th class="text-center red nodatades" colspan="2">
								{{ trans('messages.lbl_nodatafound') }}
							</th>
						</tr>
						<tr class="nodata">
							<td class="text-center red nodatades1" colspan="7">
								{{ trans('messages.lbl_nodatafound') }}
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		<a id="back2Top" title="Back to top" href="#">&#10148;</a>
		@if($mailStatus->total())
			<div class="text-center col-xs-12 pagealign" style="padding: 0px;">
				@if(!empty($mailStatus->total()))
					<span class="pull-left mt24 pl0 pagination1">{{ $mailStatus->firstItem() }}
						<span class="mt5">～</span>
						{{ $mailStatus->lastItem() }} / {{ $mailStatus->total() }}
					</span>
				　@endif 
				<span class ="pagintion2">
				{{ $mailStatus->links() }}
				</span>
				<span class="pull-right pagination mt0">
					{{ $mailStatus->linkspagelimit() }}
				</span>
			</div>
		@endif
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