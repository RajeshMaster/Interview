@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::style(asset('public/css/footable.core.css')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::script(asset('public/js/footable.js')) }}
{{ HTML::script(asset('public/js/agent.js')) }}
{{ HTML::script(asset('public/js/lib/bootstrap-datepicker.min.js')) }}
{{ HTML::style(asset('public/css/lib/bootstrap-datetimepicker.min.css')) }}
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
	$(document).ready(function() {
    	setDatePicker("datarange");
 	});
	function pageClick(pageval) {
		$('#page').val(pageval);
		$('#agentindexform').attr('action', '../Agent/index'+'?mainmenu=menu_mail&time='+datetime);
		$("#agentindexform").submit();
	}
	function pageLimitClick(pagelimitval) {
		$('#page').val('');
		$('#plimit').val(pagelimitval);
		$('#agentindexform').attr('action', '../Agent/index'+'?mainmenu=menu_mail&time='+datetime);
		$("#agentindexform").submit();
	}
	function mulclick(divid){
		if($('#'+divid).css('display') == 'block'){
		document.getElementById(divid).style.display = 'none';
		document.getElementById(divid).style.height= "220px";
		}else {
		document.getElementById(divid).style.display = 'block';
		}
	}
</script>
<div class="" id="main_contents">
	<article id="customer" class="DEC_flex_wrapper" data-category="customer cus_sub_2">
		{{ Form::open(array('name'=>'agentindexform', 'id'=>'agentindexform','url' => 'Agent/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 'method' => 'POST')) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
		{{ Form::hidden('sorting', '' , array('id' => 'sorting')) }}
		{{ Form::hidden('sortOptn',$request->agentsort , array('id' => 'sortOptn')) }}
		{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
		{{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
		{{ Form::hidden('editflg', '' , array('id' => 'editflg')) }}
		{{ Form::hidden('useval','',array('id' => 'useval')) }}
		{{ Form::hidden('id','',array('id' => 'id')) }}
		{{ Form::hidden('agentId','',array('id' => 'agentId')) }}
		{{ Form::hidden('viewflg', '2', array('id' => 'viewflg')) }}
		<!-- Start Heading -->
		<fieldset class="pm0 mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/Client.png')  }}">
				<h2 class="h2cnt">{{ trans('messages.lbl_agent') }}
				</h2>
			</div>
		</fieldset>
		<!-- End Heading -->
		<!-- Session msg Start-->
		@if(Session::has('success'))
			<div align="center" class="alertboxalign col-xs-12 mt10" role="alert" >
				<span class="alert {{ Session::get('alert', Session::get('type') ) }}">
				{{ Session::get('success') }}
				</span>
			</div>
		@endif

		@if(Session::has('danger'))
			<div align="center" class="alertboxalign col-xs-12 mt10" role="alert">
				<span class="alert {{ Session::get('alert', Session::get('type') ) }}">
				{{ Session::get('danger') }}
				</span>
			</div>
		@endif
		@php Session::forget('success'); @endphp
		@php Session::forget('danger'); @endphp
		<!-- Session msg End-->
		<div class="col-xs-12 pm0 pull-left mt5 mt13">
			<div class="pull-left">
				<button type="button" onclick="fngotoregister('register');"
						class="button button-green pull-right">
					<span class="fa fa-plus"></span> {{ trans('messages.lbl_register')}}
				</button>
			</div>
		</div>	
		<div class="col-xs-12 pm0 pull-left mt5 mt13">
			<div class="pull-left">
				<a class="btn btn-link {{ $disabledactive }}" href="javascript:filter('1');"> {{ trans('messages.lbl_use') }}</a>
				<span>|</span>
				<a class="btn btn-link {{ $disabledusenotuse }}" href="javascript:filter('3');"> {{ trans('messages.lbl_notuse') }}</a>
			</div>
			<a href="javascript:clearsearch()" title="Clear Search">
				<img class="pull-right box35 mr10 pageload clearposition" src="{{ URL::asset('public/images/clearsearch.png')  }}">
			</a>
				{{ Form::select('agentsort', $agentsortarray, $request->agentsort,
					array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right','id' => 'agentsort',
					'style' => $sortMargin,'name' => 'agentsort'))
				}}
		</div>
		<div class="col-xs-12 pm0 pull-left searchpos" style="margin-top:17.5%;position: fixed;" id="styleSelector">
			<div class="selector-toggle">
				<a id="sidedesignselector" href="javascript:void(0)"></a>
			</div>
			<ul>
				<span>
					<li style="">
						<p class="selector-title">{{ trans('messages.lbl_search') }}</p>
					</li>
				</span>

				<li class="theme-option ml6">
					<div class="box100per mt5"  onKeyPress="return checkSubmitsingle(event)">
						{!! Form::text('singlesearchtxt', $request->singlesearchtxt,
						array('','class'=>' form-control box80per pull-left','style'=>'height:30px;','id'=>'singlesearchtxt')) !!}

						{{ Form::button('<i class="fa fa-search" aria-hidden="true"></i>', 
						array('class'=>'ml5 mt2 pull-left search box15per btn btn-info btn-sm', 
						'type'=>'button',
						'name' => 'advsearch',
						'onclick' => 'javascript:fnSingleSearch();',
						'style'=>'border: none;' 
						)) }}
					<div>
				</li>
			</ul>
			<div class="mt5 ml10 pull-left mb5">
				<a href="#demo" onclick="mulclick('demo');" class="" style="font-family: arial, verdana;" data-toggle="collapse">
	              	  {{ trans('messages.lbl_multi_search') }}
	              </a>
			</div>
			<div id="multisearch">
				<ul id="demo" @if ($request->searchmethod == 2) class="collapse in ml5 pull-left" 
						@else class="collapse ml5 pull-left"  @endif>
					<li class="theme-option"  onKeyPress="return checkSubmitmulti(event)">
						<div class="mt5">
							<span class="pt3" style="font-family: arial, verdana;">
								{{ trans('messages.lbl_name') }}
							</span>
							<div class="mt5 box88per" style="display: inline-block!important;">
								{!! Form::text('name', $request->name,
									array('','class'=>' form-control box95per pull-left','style'=>'height:30px;','id'=>'name')) !!}
							</div>
						</div>
	                 	<div class="mt5">
	                 		<span class="pt3" style="font-family: arial, verdana;">
	                 			{{ trans('messages.lbl_address') }}
	                 		</span>
	                 		<div class="mt5 box88per" style="display: inline-block!important;">
	                 			{!! Form::text('address', $request->address,
		                         array('','id' => 'address','style'=>'height:30px;','class'=>'form-control box95per pull-left 
		                         ')) !!}
	                 		</div>
	                 	</div>
						<div class="mt5 mb6">
							 {{ Form::button(
								 '<i class="fa fa-search" aria-hidden="true"></i> '.trans('messages.lbl_search'),
								 array('class'=>'mt10 btn btn-info btn-sm ',
										'onclick' => 'javascript:return umultiplesearch()',
										'type'=>'button')) 
							 }}
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="box100per tableShrink pt10 mnheight mb0">
			<table class="table-striped table footable table-bordered mt10 mb10">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="15%">
					<col width="30%">
					<col width="30%">
				</colgroup>
				<thead class="CMN_tbltheadcolor">
					<tr class="CMN_tbltheadcolor">
						<th class="tac fs10 sno">
							{{ trans('messages.lbl_use') }}
						</th>
						<th class="tac fs10">
							{{ trans('messages.lbl_agentId') }}
						</th>
						<th data-hide="phone" class="tac fs10">
							{{ trans('messages.lbl_name') }}
						</th>
						<th data-hide="phone" class="tac fs10">
							{{ trans('messages.lbl_address') }}
						</th>
						<th data-hide="phone" class="tac fs10">
							{{ trans('messages.lbl_Details') }}
						</th>
					</tr>
				</thead>
				<tbody>
				@if(count($agentViews)!="")
					@for ($i = 0; $i < count($agentViews); $i++)
					<tr>
						<td class="text-center">
							@if($agentViews[$i]['delflg'] == 0)
							{{ ($agentdetails->currentpage()-1) * $agentdetails->perpage() + $i + 1 }}
								<br><a title="Not Use" class="fr" href="javascript:changeAgentFlg('1',{{ $agentViews[$i]['id'] }});">x</a>
							@else
							{{ ($agentdetails->currentpage()-1) * $agentdetails->perpage() + $i + 1 }}
								<br><a title="Use" href="javascript:changeAgentFlg('0',{{ $agentViews[$i]['id'] }});">○</a>
							@endif
						</td>
						<td class="text-center">
							@if($agentViews[$i]['agent_id'])
								{!! nl2br(e($agentViews[$i]['agent_id'])) !!}
							@else
								{{ "NILL"}}
							@endif
						</td>
						<td> 
							<a class="colbl fwb" href="javascript:agentView('{{ $agentViews[$i]['id'] }}','{{ $agentViews[$i]['agent_id'] }}');">
							@if($agentViews[$i]['agent_name'])
								{{ $agentViews[$i]['agent_name'] }}</a>
							@else
								{{ "NILL"}}
							@endif<br>
							@if($agentViews[$i]['agent_kananame'])
								{{ $agentViews[$i]['agent_kananame'] }}
							@else
							@endif 
						</td>
						<td>
							@if(isset($agentViews[$i]['postalNumber']))
								〒 {{ $agentViews[$i]['postalNumber'] }}
							@endif
							@if(isset($agentViews[$i]['kenmei']))
								{{ $agentViews[$i]['kenmei'] }}
							@endif
							@if(isset($agentViews[$i]['shimei']))
								{{ $agentViews[$i]['shimei'] }}
							@endif
							@if(isset($agentViews[$i]['street_address']))
								{{ $agentViews[$i]['street_address'] }}
							@endif

							@if(isset($agentViews[$i]['buildingname']))
								{{ $agentViews[$i]['buildingname'] }}
							@endif
						</td>
						<td>
							<span class="clr_blue">{{ trans('messages.lbl_mobileno') }}</span> 
							<span>:</span>
							<span class="ml5" style="padding-left:1px; position: absolute;">
								@if($agentViews[$i]['agent_contact_no'])
									{{ $agentViews[$i]['agent_contact_no'] }}
								@else
									{{ "NILL"}}
								@endif
							</span><br>
							<span class="clr_blue">{{ trans('messages.lbl_email') }}</span> 
							<span class="ml33">:</span>
							<span class="ml5">
								@if($agentViews[$i]['agent_email_id'])
									{{ $agentViews[$i]['agent_email_id'] }}
								@else
									{{ "NILL"}}
								@endif
							</span><br>
							<span class="clr_blue">{{ trans('messages.lbl_fax') }}</span>
							<span class="ml47">:</span>
							<span class="ml5">
								@if($agentViews[$i]['agent_fax_no'])
									{{ $agentViews[$i]['agent_fax_no'] }}
								@else
									{{ "NILL"}}
								@endif
							</span><br>
							<span class="clr_blue">{{ trans('messages.lbl_url') }}</span>
							<span class="ml43">:</span>
							@if($agentViews[$i]['agent_website'])
								<span class="ml5 colbl" style=" position: absolute;
								padding-left:5px;">
									<a class="colbl" href="http://{{ $agentViews[$i]['agent_website'] }}" target="_blank">{{ $agentViews[$i]['agent_website'] }}</a>
								</span>
							@else
								<span class="ml5">
									{{ "NILL"}}
								</span>
							@endif
						</td>
					</tr>
					@endfor
				@else
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
				@endif
			</tbody>
			</table>
		</div>
		@if(!empty($agentViews))
			<div class="text-center pl13">
				@if(!empty($agentdetails->total()))
					<span class="pull-left mt24">
						{{ $agentdetails->firstItem() }} ~ {{ $agentdetails->lastItem() }} / {{ $agentdetails->total() }}
					</span>
				@endif 
				{{ $agentdetails->links() }}
				<div class="CMN_display_block flr mr10">
					{{ $agentdetails->linkspagelimit() }}
				</div>  
			</div>
		@endif
		{{ Form::close() }}
	</article>
</div>
<script>
	  $('.footable').footable({
			calculateWidthOverride: function() {
				return { width: $(window).width() };
			}
		}); 
	</script>
@endsection