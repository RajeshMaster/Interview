@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::style(asset('public/css/footable.core.css')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::script(asset('public/js/footable.js')) }}
{{ HTML::script(asset('public/js/customer.js')) }}
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
		$('#customerindexform').attr('action', '../Customer/index'+'?mainmenu=menu_mail&time='+datetime);
		$("#customerindexform").submit();
	}
	function pageLimitClick(pagelimitval) {
		$('#page').val('');
		$('#plimit').val(pagelimitval);
		$('#customerindexform').attr('action', '../Customer/index'+'?mainmenu=menu_mail&time='+datetime);
		$("#customerindexform").submit();
	}
	function mulclick(divid){
		if($('#'+divid).css('display') == 'block'){
			document.getElementById(divid).style.display = 'none';
			document.getElementById(divid).style.height = "260px";
		}else {
			document.getElementById(divid).style.display = 'block';
		}
	}
</script>
<div class="" id="main_contents">
	<article id="customer" class="DEC_flex_wrapper" data-category="customer cus_sub_1">
	{{ Form::open(array('name'=>'customerindexform',
		'id'=>'customerindexform',
		'url' => 'Customer/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
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
		<div class="pull-left">
			<button type="button" onclick="fngotoregister('{{ $request->mainmenu }}');"
					class="button button-green pull-right">
				<span class="fa fa-plus"></span> {{ trans('messages.lbl_register')}}
			</button>
		</div>
	</div>	
	<div class="col-xs-12 pm0 pull-left mt5 mt13">

		<div class="pull-left">
			<a class="btn btn-linkemp {{ $disabledNotGroup }}"  href="javascript:filter('1');" class="pl10 pb5">
					Not IN Group
			</a>
			@php $i = 1 @endphp
		    @if(count($group) != 0)
			    @foreach($group as $key => $value)
					<span>|</span>
					@if($value->groupId != $request->filterval)
						<a class="btn btn-link  tal" href="javascript:filter('{{ $value->groupId }}');" title="<?php echo $value->groupName ?>" style = "padding-left: <?php if($i % 5 != 0) { ?> 0px; <?php } ?>"> 
		          		  {{ substr($value->groupName,0,12) }}
		                @if(isset($cntGrpCus[$value->groupId][0]))
		                  <span>({{ $cntGrpCus[$value->groupId][0]->cntCusId }})</span>
		                @endif</a>
					@else
						<a class="btn btn-link tal {{ $disabledGroup }}" href="javascript:filter('{{ $value->groupId }}');" title="<?php echo $value->groupName ?>" 
		                style = "padding-left:  <?php if($i % 5 != 0) { ?> 0px; <?php } ?>"> 
			                {{ substr($value->groupName,0,12) }}
		                  @if(isset($cntGrpCus[$value->groupId][0]))
		                    <span>({{ $cntGrpCus[$value->groupId][0]->cntCusId }})</span>
		                  @endif</a>
					@endif
				@php $i++ @endphp
	        	@endforeach
        	@endif	
		</div>
		<a href="javascript:clearsearch()" title="Clear Search">
			<img class="pull-right box35 mr10 pageload clearposition" src="{{ URL::asset('public/images/clearsearch.png')  }}">
		</a>
		{{ Form::select('cussort', $customersortarray, $request->cussort,
						array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right',
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
				<li>
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
				<col width="5%">
				<col width="10%">
				<col width="18%">
				<col width="34%">
				<!-- <col width="24%"> -->
				<col>
			</colgroup>
			<thead class="CMN_tbltheadcolor">
				<tr class="CMN_tbltheadcolor">
					<th class="tac fs10 sno">
						{{ trans('messages.lbl_sno') }}
					</th>
					<th class="tac fs10">
						{{ trans('messages.lbl_contractDate') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_name') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_address') }}
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
						<td class="text-center">
							{{ ($detailview->currentpage()-1) * $detailview->perpage() + $i + 1 }}<br>
          					<a title="selectGroup" href="javascript:selectGroup('{{ $cstviews[$i]['customer_id'] }}');">Group</a>
						</td>
						<td class="text-center">
							@if($cstviews[$i]['contract']=="0000-00-00")
					        @else
					          {{ $cstviews[$i]['contract'] }}
					        @endif
						</td>
						<td> 
					        <a class="colbl fwb" href="javascript:custview('{{ date('YmdHis') }}','{{ $cstviews[$i]['id'] }}','{{ $cstviews[$i]['customer_id'] }}');">
					          @if($cstviews[$i]['customer_name'])
					            {{ $cstviews[$i]['customer_name'] }}</a>
					          @else
					            {{ "NILL"}}
					          @endif    
					        <br>
					            @if($cstviews[$i]['romaji'])
					              {{ $cstviews[$i]['romaji'] }}
					            @else
					            @endif 
					        <br>
          				</td>
          				<td>
							@if(isset($cstviews[$i]['postalNumber']))
								〒 {{ $cstviews[$i]['postalNumber'] }}
							@endif
							@if(isset($cstviews[$i]['kenmei']))
								{{ $cstviews[$i]['kenmei'] }}
							@endif
							@if(isset($cstviews[$i]['shimei']))
								{{ $cstviews[$i]['shimei'] }}
							@endif
							@if(isset($cstviews[$i]['street_address']))
								{{ $cstviews[$i]['street_address'] }}
							@endif
							@if(isset($cstviews[$i]['buildingname']))
								{{ $cstviews[$i]['buildingname'] }}
							@endif
							<br>
							<span class="clr_blue">Tel</span><span>:</span> 
							@if($cstviews[$i]['customer_contact_no'])
								{{ $cstviews[$i]['customer_contact_no'] }}
							@else
								{{ "NILL"}}
							@endif 
							<span class="clr_blue">{{ trans('messages.lbl_fax') }}</span><span>:</span>
							@if($cstviews[$i]['customer_fax_no'])
								{{ $cstviews[$i]['customer_fax_no'] }}
							@else
								{{ "NILL"}}
							@endif
							<span class="clr_blue">URL</span><span>:</span>  
							@if($cstviews[$i]['customer_website'])
								<a class="colbl" title="URL: <?php echo $cstviews[$i]['customer_website']; ?>" href="http://{{ $cstviews[$i]['customer_website'] }}" target="_blank"><img class="search box2per pr5 langimg11" src="{{ URL::asset('public/images/url.png') }}" style="min-width:20px;cursor:pointer;"></img></a>
								</span>
							@else
								<img class="search box2per pr5 langimg11" src="{{ URL::asset('resources/assets/images/nourl.png') }}" style="min-width:20px;cursor:default;"></img>
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
	@if(!empty($cstviews))
		<div class="text-center">
			@if(!empty($detailview->total()))
				<span class="pull-left mt24">
					{{ $detailview->firstItem() }} ~ {{ $detailview->lastItem() }} / {{ $detailview->total() }}
				</span>
			@endif 
				{{ $detailview->links() }}
			<div class="CMN_display_block flr">
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
<div id="selectGroup" class="modal fade" style="width: 775px;">
	<div id="login-overlay">
		<div class="modal-content">
			<!-- Popup will be loaded here -->
		</div>
	</div>
</div>
@endsection
