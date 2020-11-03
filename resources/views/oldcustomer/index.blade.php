@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::style(asset('public/css/footable.core.css')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::script(asset('public/js/footable.js')) }}
{{ HTML::script(asset('public/js/oldcustomer.js')) }}
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
		setDatePickerBeforeCurrent("datarange");
	});
	function pageClick(pageval) {
		$('#page').val(pageval);
		$('#Oldcustomerindexform').attr('action', '../OldCustomer/index'+'?mainmenu=menu_mail&time='+datetime);
		$("#Oldcustomerindexform").submit();
	}
	function pageLimitClick(pagelimitval) {
		$('#page').val('');
		$('#plimit').val(pagelimitval);
		$('#Oldcustomerindexform').attr('action', '../OldCustomer/index'+'?mainmenu=menu_mail&time='+datetime);
		$("#Oldcustomerindexform").submit();
	}
	function mulclick(divid){
		if($('#'+divid).css('display') == 'block'){
			document.getElementById(divid).style.display = 'none';
			document.getElementById(divid).style.height = "260px";
		} else {
			document.getElementById(divid).style.display = 'block';
		}
	}
</script>
<div class="" id="main_contents">
	<article id="customer" class="DEC_flex_wrapper" data-category="customer cus_sub_3">
	{{ Form::open(array('name'=>'Oldcustomerindexform',
		'id'=>'Oldcustomerindexform',
		'url' => 'OldCustomer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
		'method' => 'POST')) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
		{{ Form::hidden('hdnempid', '', array('id' => 'hdnempid')) }}
		{{ Form::hidden('hdnempname', '', array('id' => 'hdnempname')) }}
		{{ Form::hidden('sorting', '' , array('id' => 'sorting')) }}
		{{ Form::hidden('viewid', '' , array('id' => 'viewid')) }}
		{{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
		{{ Form::hidden('sortOptn',$request->cussort , array('id' => 'sortOptn')) }}
		{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
		{{ Form::hidden('useval','',array('id' => 'useval')) }}
		{{ Form::hidden('id','',array('id' => 'id')) }}
		{{ Form::hidden('custid','',array('id' => 'custid')) }}
		{{ Form::hidden('viewflg', '2', array('id' => 'viewflg')) }}
		{{ Form::hidden('hid_branch_id','', array('id' => 'hid_branch_id')) }}
		{{ Form::hidden('ordervalue', $request->ordervalue, array('id' => 'ordervalue')) }}
		{{ Form::hidden('oldfilter', $request->filterval, array('id' => 'oldfilter')) }}

	<!-- Start Heading -->
	<fieldset class="pm0 mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/Client.png')  }}">
			<h2 class="h2cnt">{{ trans('messages.lbl_customerList') }}
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
	<!-- 	<a class="btn btn-link {{ $disabledactive }}" href="javascript:filter('1');"> {{ trans('messages.lbl_active') }} </a>
		<span>|</span>
		<a class="btn btn-link {{ $disabledinactive }}" href="javascript:filter('2');"> {{ trans('messages.lbl_inactive') }} </a>
		<span>|</span>
		<a class="btn btn-link {{ $disabledusenotuse }}" href="javascript:filter('3');"> {{ trans('messages.lbl_notuse') }} </a>

 -->
		<a href="javascript:importpopupenable('{{ $request->mainmenu }}');" style="color:blue;" class="mr10 pb15 box30">
            <img class="box22 mr7 mb5" src="{{ URL::asset('public/images/copy.png') }}">Import
        </a>

		<a href="javascript:clearsearch()" title="Clear Search">
			<img class="pull-right box35 mr10 pageload clearposition" src="{{ URL::asset('public/images/clearsearch.png')  }}">
		</a>
		{{ Form::select('cussort', $customersortarray, $request->cussort,
						array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right mb10',
					   'id' => 'cussort',
					   'name' => 'cussort'))
		}}
	</div>
	<div style="margin-top:17.5%;position: fixed;" 
		@if($request->singlesearchtxt != ""  || $request->searchmethod == 2) 
			class="open CMN_fixed mt242" 
		@else 
			class="CMN_fixed mt242" 
		@endif
	 		id="styleSelector">
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
					{!! Form::text('singlesearchtxt', trim($request->singlesearchtxt),
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
			<a href="#demo" onclick="mulclick('demo');" style="font-family: arial, verdana;">
				{{ trans('messages.lbl_multi_search') }}
			</a>
		</div>

		<div id="multisearch">
			 <ul id="demo" 
			 	@if ($request->searchmethod == 2) class="collapse in ml5 pull-left" 
				@else class="collapse ml5 pull-left"  @endif>
				<li class="theme-option"  onKeyPress="return checkSubmitmulti(event)">
					<div class="mt5">
						<span class="pt3" style="font-family: arial, verdana;">
							{{ trans('messages.lbl_name') }}
						</span>
						<div class="mt5 box88per" style="display: inline-block!important;">
							{!! Form::text('name', trim($request->name),
								array('','class'=>' form-control box95per pull-left','style'=>'height:30px;','id'=>'name')) !!}
						</div>
					</div>
						<div class="mt5">
						<span class="pt3" style="font-family: arial, verdana;">
							{{ trans('messages.lbl_daterange') }}
						</span>
						<div class="mt5 box88per" style="display: inline-block!important;">
							<span class="CMN_display_block box33per " style="display: inline-block!important;">
							{{ Form::text('startdate','',array('id'=>'startdate', 'name' => 'startdate','data-label' => trans('messages.lbl_dob'),'class'=>'form-control box100per datarange','onkeypress' => 'return isNumberKey(event)')) }}
							</span>
							<label class="mt10 ml2 fa fa-calendar fa-lg CMN_display_block pr5" 
									for="startdate" aria-hidden="true" style="display: inline-block!important;">
							</label>
							<span class="CMN_display_block box33per " style="display: inline-block!important;">
							{{ Form::text('enddate','',array('id'=>'enddate', 'name' => 'enddate','data-label' => trans('messages.lbl_dob'),'class'=>'form-control box100per datarange','onkeypress' => 'return isNumberKey(event)')) }}
							</span>
							<label class="mt10 ml2 fa fa-calendar fa-lg CMN_display_block" 
									for="enddate" aria-hidden="true" style="display: inline-block!important;">
							</label>
						</div>
					</div>
					<div class="mt5">
						<span class="pt3" style="font-family: arial, verdana;">
							{{ trans('messages.lbl_address') }}
						</span>
						<div class="mt5 box88per" style="display: inline-block!important;">
							{!! Form::text('address', trim($request->address),
							 array('','id' => 'address','style'=>'height:30px;','class'=>'form-control box93per 
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
		<table class="table-striped table footable table-bordered mt10 mb10" >
			<colgroup>
				<col width="4%">
				<col width="10%">
				<col width="10%">
				<col width="35%">
				<col>
			</colgroup>

			<thead class="CMN_tbltheadcolor">
				<tr class="CMN_tbltheadcolor">
					<th class="tac fs10 sno">
						{{ trans('messages.lbl_sno') }}
					</th>
					<th class="tac fs10">
						{{ trans('messages.lbl_customerno') }}
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
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_branchName') }}
					</th>
				</tr>
			</thead>
			<tbody class="tablealternateclr">
				@if(count($cstviews)!="")
					@for ($i = 0; $i < count($cstviews); $i++)
						<tr>
							<td>
								<!-- @if($cstviews[$i]['delflg']==0) -->
									{{ ($detailview->currentpage()-1) * $detailview->perpage() + $i + 1 }}<br>
								<!-- 	<a title="Not Use" class="fr" href="javascript:ChangecutomerUse('1',{{ $cstviews[$i]['id'] }});">x</a>
								@else
									{{ ($detailview->currentpage()-1) * $detailview->perpage() + $i + 1 }}<br>
									<a title="Use" href="javascript:ChangecutomerUse('0',{{ $cstviews[$i]['id'] }});">○</a>
								@endif -->
							</td>

							<td class="text-center">
								@if($cstviews[$i]['customer_id'])
									{!! nl2br(e($cstviews[$i]['customer_id'])) !!}
								@else
									{{ "NILL"}}
								@endif
							</td>

							<td>
								<a class="colbl fwb" href="javascript:custview('{{ $cstviews[$i]['id'] }}','{{ $cstviews[$i]['customer_id'] }}');">
								@if($cstviews[$i]['customer_name'])
									{{ $cstviews[$i]['customer_name'] }}</a>
								@else
									{{ "NILL"}}
								@endif
								<br>
								@if($cstviews[$i]['romaji'])
									{{ $cstviews[$i]['romaji'] }}
								@endif 
								<br>
								@if($cstviews[$i]['contract']=="0000-00-00")
								@else
									{{ $cstviews[$i]['contract'] }}
								@endif
							</td>

							<td> 
								@if($cstviews[$i]['customer_address'])
									{!! nl2br(e($cstviews[$i]['customer_address'])) !!}
								@endif
							</td>

							<td>
								<span class="clr_blue">{{ trans('messages.lbl_mobileno') }}</span> <span>:</span><span class="ml5">
									@if($cstviews[$i]['customer_contact_no'])
										{{ $cstviews[$i]['customer_contact_no'] }}
									@else
										{{ "NILL"}}
									@endif
								</span><br>
								<span class="clr_blue">{{ trans('messages.lbl_fax') }}</span><span class="ml40">:</span><span class="ml5">
								@if($cstviews[$i]['customer_fax_no'])
									{{ $cstviews[$i]['customer_fax_no'] }}
								@else
									{{ "NILL"}}
								@endif
								</span><br>
								<span class="clr_blue">URL</span><span class="ml39">:</span>
								@if($cstviews[$i]['customer_website'])
									<span class="ml5 colbl">
										<a class="colbl" href="http://{{ $cstviews[$i]['customer_website'] }}" target="_blank">{{ $cstviews[$i]['customer_website'] }}</a>
									</span>
								@else
									<span class="ml5">
										{{ "NILL"}}
									</span>
								@endif
							</td>

							<td>
								@if(isset($cstviews[$i]['BranchName']))
									@for ($k = 0; $k < count($cstviews[$i]['BranchName']); $k++)
										@if(isset($cstviews[$i]['BranchName'][$k]))
											{{ $cstviews[$i]['BranchName'][$k] }}<br/>
										@else
											{{ "NILL" }}<br/>
										@endif
									@endfor
								@else
									{{ "NILL"}}
								@endif 
							</td>
						</tr>
					@endfor

				@else
				<tr>
					<td class="text-center fr" colspan="6">
					{{ trans('messages.lbl_nodatafound') }}
					</td>
				</tr>
				@endif


			</tbody>
		</table>
	</div>
		
	@if(!empty($cstviews))
		<div class="text-center pl13">
			@if(!empty($detailview->total()))
				<span class="pull-left mt24">
					{{ $detailview->firstItem() }} ~ {{ $detailview->lastItem() }} / {{ $detailview->total() }}
				</span>
			@endif 
			{{ $detailview->links() }}
			<div class="CMN_display_block flr mr10">
				{{ $detailview->linkspagelimit() }}
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

<div id="importpopup" class="modal fade" style="width: 775px;">
	<div id="login-overlay">
		<div class="modal-content">
		<!-- Popup will be loaded here -->
		</div>
	</div>
</div>
@endsection
