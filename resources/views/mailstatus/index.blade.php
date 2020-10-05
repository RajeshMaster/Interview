@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/settinglayout.css')) }}
{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::style(asset('public/css/footable.core.css')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::script(asset('public/js/footable.js')) }}
{{ HTML::script(asset('public/js/mailstatus.js')) }}
<style type="text/css">
/* Start Laptop screen Setting index page design */
@media all and (min-width:1205px) {
	.settingdesign{
		margin-left: 15%!important;
	}
	.settingsubdesignfamily{
		margin-left: 21%!important;
	}
	.settingdesignright{
		margin-left: 7%!important;
	}
	.settingsubdesignright{
		margin-left: 13%!important;
	}
}
/*End Laptop screen Setting index page design */
</style>
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
	function pageClick(pageval) {
		$('#page').val(pageval);
		$('#mailstatusindx').attr('action', '../MailStatus/index'+'?mainmenu=menu_mail&time='+datetime);
		$("#mailstatusindx").submit();
	}
	function pageLimitClick(pagelimitval) {
		$('#page').val('');
		$('#plimit').val(pagelimitval);
		$('#mailstatusindx').attr('action', '../MailStatus/index'+'?mainmenu=menu_mail&time='+datetime);
		$("#mailstatusindx").submit();
	}
</script>
{{ Form::open(array('name'=>'mailstatusindx',
		'id'=>'mailstatusindx',
		'url' => 'MailStatus/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
		'method' => 'POST')) }}
{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
{{ Form::hidden('sendfilter','', array('id' => 'sendfilter')) }}
{{ Form::hidden('statusid','', array('id' => 'statusid')) }}
<div class="" id="main_contents">
	<article id="mail" class="DEC_flex_wrapper" data-category="mail mail_sub_3">
		<!-- Start Heading -->
		<fieldset class="pm0 mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/sentmail.png')  }}">
				<h2 class="pull-left pl5 mt10">{{ trans('messages.lbl_mailstatus') }}</h2>
				</h2>
			</div>
		</fieldset>
		<div class="col-xs-12 pm0 pull-left mt5 mt13">
			<div class="pull-left">
				<a class="btn btn-linkemp {{ $disabledsent }}" href="javascript:filtermail(1);" class="pl10 pb5">
						{{ trans('messages.lbl_sent') }}
				</a>
				<span>|</span>
				<a class="btn btn-linkemp {{ $disableddraft }}" href="javascript:filtermail(0);" class="pl10 pb5">
					{{ trans('messages.lbl_draft') }}
				</a>
			</div>
		</div>
		<!-- End Heading -->
		<div class="box100per tableShrink pt10 mnheight mb0">
			<table class="table-striped table footable table-bordered mt10 mb10">
				<colgroup>
					<col width="4%">
					<col width="10%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead class="CMN_tbltheadcolor" >
					<tr class="CMN_tbltheadcolor">
						<th class="tac fs10 sno">
							{{ trans('messages.lbl_sno') }}
						</th>
						<th class="tac fs10">
							{{ trans('messages.lbl_empid') }}
						</th>
						<th data-hide="phone" class="tac fs10">
							{{ trans('messages.lbl_companyName') }}
						</th>
						<th data-hide="phone" class="tac fs10">
							{{ trans('messages.lbl_branchName') }}
						</th>
						<th data-hide="phone" class="tac fs10">
							{{ trans('messages.lbl_mailid') }}
						</th>
						<th data-hide="phone" class="tac fs10">
							{{ trans('messages.lbl_senddatetime') }}
						</th>
						<th data-hide="phone" class="tac"></th>
					</tr>
				</thead>
				<tbody class="tablealternateclr">
					{{--*/ $sno = $getMailList->firstItem() /*--}}
			   		{{ $temp = ""}}
			   		{{ $tempcomp = ""}}
			   		{{ $row = ""}}
					@forelse ($getMailList as $count => $data)
					{{--*/ $loc = substr($data->updatedDate,0,10) /*--}}
			   			{{--*/ $loccomp = $data->customer_name /*--}}
			   			@if($loc != $temp) 
                        	@if($row==1)
                          		{{--*/ $style_tr = 'background-color: #E5F4F9;' /*--}}
                          		{{--*/ $row = '0' /*--}}
                        	@else
                          		{{--*/ $style_tr = 'background-color: #FFFFFF;' /*--}}
                          		{{--*/ $row = '1' /*--}}
                        	@endif
                        	{{--*/ $style_td = '' /*--}}
                      	@else
                        	{{--*/ $style_td = 'border-top: hidden;' /*--}}
                      	@endif
                      	@if($loccomp == $tempcomp && $loc == $temp) 
                        	{{--*/ $style_tdcomp = 'border-top: hidden;' /*--}}
                      	@else
                        	{{--*/ $style_tdcomp = '' /*--}}
                      	@endif
		   			<tr style="{{$style_tr}}">
		   				<td class="tac vam">{{ $sno }}</td>
		   				<td class="tac vam" style="">{{ $data->empId }}</td>
		   				<td class="tal vam" style="">{{ $data->customer_name }}</td>
		   				<td class="tal vam" style="">{{ $data->branch_name }}</td>
		   				<td class="tal vam">
		   					<?php $extomail = explode(",", $data->toMail); ?>
							<?php for ($i=0; $i < count($extomail); $i++) { ?>
							<div class="col-xs-12 pm0">
								{{ $extomail[$i] }}<?php if(count($extomail)-1 != $i) { echo ","; } ?>
							</div>
							<?php } ?>
		   				<td class="text-center vam" style="">{{ substr($data->updatedDate,0,19) }}</td>
						<td class="text-center vam"><a href="javascript:fnstatusView({{ $data->id }});"><img title="{{ trans('messages.lbl_view') }}" class=" box15" src="{{ URL::asset('public/images/ourdetails.png') }}"></a></td>
		   			</tr>
			   		{{--*/ $temp = $loc /*--}}
			   		{{--*/ $tempcomp = $loccomp /*--}}
			   		{{--*/ $sno = $sno + 1 /*--}}
					@empty
						<tr class="nodata">
							<th class="text-center red nodatades" colspan="3">
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
		@if($getMailList->total())
			<div class="text-center col-xs-12 pm0 pagealign">
				@if(!empty($getMailList->total()))
					<span class="pull-left mt24 pagination1">{{ $getMailList->firstItem() }}
						<span class="mt5 pagination2">～</span>
						{{ $getMailList->lastItem() }} / {{ $getMailList->total() }}
					</span>
				　@endif 
				<span class ="pagintion2">
				{{ $getMailList->links() }}
				</span>
				<span class="pull-right pagination mt0">
					{{ $getMailList->linkspagelimit() }}
				</span>
			</div>
		@endif 
	</article>
</div>
{{ Form::close() }}
<script>
	$('.footable').footable({
		calculateWidthOverride: function() {
			return { width: $(window).width() };
		}
	}); 
</script>
@endsection