@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/settinglayout.css')) }}
{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::style(asset('public/css/footable.core.css')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::script(asset('public/js/footable.js')) }}
{{ HTML::script(asset('public/js/mailsignature.js')) }}

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
		$("#mailsignaturefrm").submit();
	}
	function pageLimitClick(pagelimitval) {
		$('#page').val('');
		$('#plimit').val(pagelimitval);
		$("#mailsignaturefrm").submit();
	}
</script>
{{ Form::open(array('name'=>'mailsignaturefrm',
		'id'=>'mailsignaturefrm',
		'url' => 'MailSignature/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
		'method' => 'POST')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('filvalhdn', '', array('id' => 'filvalhdn')) }}
		{{ Form::hidden('delflg', '', array('id' => 'delflg')) }}
		{{ Form::hidden('signatureId', '', array('id' => 'signatureId')) }}
		{{ Form::hidden('editflg', '', array('id' => 'editflg')) }}
<div class="" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="mail" class="DEC_flex_wrapper" data-category="mail mail_sub_2">
		<!-- Start Heading -->
		<fieldset class="pm0 mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/signature.png')  }}">
				<h2 class="pull-left pl5 mt10">{{ trans('messages.lbl_mailsignature') }}</h2>
				</h2>
			</div>
		</fieldset>
		<!-- End Heading -->
		<!-- Session msg Start-->
		@if(Session::has('success'))
			<div align="center" class="alertboxalign" role="alert">
				<p class="alert {{ Session::get('alert', Session::get('type') ) }}">
				{{ Session::get('success') }}
				</p>
			</div>
		@endif
		@if(Session::has('danger'))
			<div align="center" class="alertboxalign" role="alert">
				<p class="alert {{ Session::get('alert', Session::get('type') ) }}">
				{{ Session::get('danger') }}
				</p>
			</div>
		@endif
		@php Session::forget('success'); @endphp
		@php Session::forget('danger'); @endphp
		<!-- Session msg End-->
		<div class="col-xs-12 pm0 pull-left mt5 mt13">
			<div class="pull-left">
				<button type="button" onclick="fngotoregister('{{ $request->mainmenu }}');"
						class="button button-green pull-right">
					<span class="fa fa-plus"></span> {{ trans('messages.lbl_mail')}}
				</button>
			</div>
			<div class="pull-left">
				<a class="btn btn-linkemp {{ $disabledall }}" href="javascript:fnfilter(1);" class="pl10 pb5">
						{{ trans('messages.lbl_all') }}
				</a>
				<span>|</span>
				<a class="btn btn-linkemp {{ $disableduse }}" href="javascript:fnfilter(2);" class="pl10 pb5">
					{{ trans('messages.lbl_use') }}
				</a>
				<span>|</span>
				<a class="btn btn-linkemp {{ $disablednotuse }}" href="javascript:fnfilter(3);" class="pl10 pb5">
					{{ trans('messages.lbl_notuse') }}
				</a>
			</div>
		</div>
		<div class="box100per tableShrink pt10 mnheight mb0">
			<table class="table-striped table footable table-bordered mt10 mb10">
				<colgroup>
					<col width="4%">
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
							{{ trans('messages.lbl_mailsignatureid') }}
						</th>
						<th data-hide="phone" class="tac fs10">
							{{ trans('messages.lbl_userid') }}
						</th>
						<th data-hide="phone" class="tac fs10">
							{{ trans('messages.lbl_username') }}
						</th>
						<th data-hide="phone" class="tac fs10">
							{{ trans('messages.lbl_mailsignature') }}
						</th>
					</tr>
				</thead>
				<tbody class="tablealternateclr">
					@forelse ($getlist as $count => $data)
						<tr>
							<td class="text-center vam">{{ ++$count }}</td>
							<td class="text-center vam">
								<a class="anchorstyle" href="javascript:gotosignview('{{ $data->id }}');">{{ $data->signID }}</a>
							</td>
							<td class="text-center vam">{{ $data->user_ID  }}</td>
							<td class="text-center vam">
								{{ $data->username }} {{ $data->givenname }} 
								@if($data->nickName != "")
									({{ $data->nickName }})
								@else 
								@endif 
							</td>
							<td>{!! nl2br(e(($data->content))) !!}
								<div class="inb col-xs-3 pm0 mb10" style="float: right;padding-right:1%;">
									<span style="float: right;" class="inb pm0">
										@if($data->delFlg == 0)
										<span class="pm0">
											<a href="javascript:fndelflg('{{ '1' }}','{{ $data->id }}');" class="fwb">{{ trans('messages.lbl_use') }}</a>
										</span>
										@else
										<span class="pm0">
											<a href="javascript:fndelflg('{{ '0' }}','{{ $data->id }}');" class="fwb ftclr" id="notuse" style="color: red;">
											{{ trans('messages.lbl_notuse') }}</a>
										</span>
										@endif
									</span>
								</div>
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
		@if($getlist->total())
			<div class="text-center col-xs-12 pm0 pagealign">
				@if(!empty($getlist->total()))
					<span class="pull-left mt24 pagination1">{{ $getlist->firstItem() }}
						<span class="mt5 pagination2">～</span>
						{{ $getlist->lastItem() }} / {{ $getlist->total() }}
					</span>
				　@endif 
				<span class ="pagintion2">
				{{ $getlist->links() }}
				</span>
				<span class="pull-right pagination mt0">
					{{ $getlist->linkspagelimit() }}
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

