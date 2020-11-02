@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::style(asset('public/css/footable.core.css')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::script(asset('public/js/footable.js')) }}
{{ HTML::script(asset('public/js/employment.js')) }}
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
			$("#onsitefrm").submit();
		}
		function pageLimitClick(pagelimitval) {
			$('#page').val('');
			$('#plimit').val(pagelimitval);
			$("#onsitefrm").submit();
		}
	</script>

	{{ Form::open(array('name'=>'onsitefrm',
		'id'=>'onsitefrm',
		'url' => 'Employee/Onsitehistory?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
		'method' => 'POST')) }}
	
	{{ Form::hidden('viewid', '' , array('id' => 'viewid')) }}
	{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
	{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
	{{ Form::hidden('title', '' , array('id' => 'title')) }}
	{{ Form::hidden('empid', $request->empid ,array('id' => 'empid')) }}
	{{ Form::hidden('empname', $request->empname ,array('id' => 'empname')) }}
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="employee" class="DEC_flex_wrapper" data-category="employee emp_sub_2">
	<!-- Start Heading -->
	<fieldset class="pm0 mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/staffList.png')  }}">
			<h2 class="h2cnt">{{ trans('messages.lbl_onsitehistory') }}
			</h2>
		</div>
	</fieldset>
	<!-- End Heading -->

	<div class="box100per tableShrink pt10 mnheight mb0">
		<div class=""> 
			<a href="javascript:fnindex();" class="button pull-left button-blue textDecNone" 
				style="text-decoration: none !important;">
				<span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}
			</a>
		</div><br/><br/>
		<div class="fwb mt5 mb5 "> 
			{{ trans('messages.lbl_empid')}}
			<span class="ml5 brown fwb">
				{{ $request->empid}}
			</span>

			<span class="ml15 fwb">
				{{ trans('messages.lbl_empName')}}
			</span>  
			<span class="fwn blue ml5">
				{{ $request->hdnempname}}
			</span>
		</div>

		<table class="table-striped table footable table-bordered mt10 mb10" >
			<colgroup>
				<col width="4%">
				<col width="25%">
				<col width="15%">
				<col width="15%">
			</colgroup>
			<thead class="CMN_tbltheadcolor" >
				<tr class="CMN_tbltheadcolor">
					<th class="tac fs10 sno">
						{{ trans('messages.lbl_sno') }}
					</th>
					<th class="tac fs10">
						{{ trans('messages.lbl_workStdate') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_workEdate') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_yearmonth') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_status') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_custname') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_branchName') }}
					</th>
				</tr>
			</thead>
			<tbody class="tablealternateclr">
				@if(count($customerhistory)!="")
					@for ($i = 0; $i < count($customerhistory); $i++)
					<tr>
						<td class="text-center vam">
							{{ $i+1 }} 
						</td>

						<td>
							@if($customerhistory[$i]['start_date'] == '0000-00-00' )
							@else
								{{ $customerhistory[$i]['start_date'] }}
							@endif  
						</td>

						<td>
							@if($customerhistory[$i]['end_date'] == '0000-00-00' )
							@else
								{{ $customerhistory[$i]['end_date'] }}
							@endif 	
						</td>

						<td>
							{{ $customerhistory[$i]['experience'] }} Yrs
						</td>

						<td>
							@if($customerhistory[$i]['status']=='1')
								{{ "StayIN"}}
							@elseif($customerhistory[$i]['status']=='2')	
								{{ "Returned"}}
							@elseif($customerhistory[$i]['status']=='3')	
								{{ "Client Changed"}}
							@elseif($customerhistory[$i]['status']=='4')	
								{{ "Others"}}
							@else	
								{{ "Work End"}}			
							@endif
						</td>
						<td>
							{{ $customerhistory[$i]['customer_name'] }}
						</td>
						<td>
							{{ $customerhistory[$i]['branch_name'] }}
						</td>
					</tr>
					@endfor
				@else
				<tr class="nodata">
					<td class="text-center red nodatades1" colspan="7">
						{{ trans('messages.lbl_nodatafound') }}
					</td>
				</tr>
				@endif
			</tbody>
		</table>
	</div>

	@if(!empty($customerhistory))
	<div class="text-center">
		@if(!empty($cushistory->total()))
			<span class="pull-left mt24">
				{{ $cushistory->firstItem() }} ~ {{ $cushistory->lastItem() }} / {{ $cushistory->total() }}
			</span>
		@endif 
		{{ $cushistory->links() }}
		<div class="CMN_display_block flr">
			{{ $cushistory->linkspagelimit() }}
		</div>
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

<div id="uploadRes" class="modal fade" style="width: 775px;">
	<div id="login-overlay">
		<div class="modal-content">
		<!-- Popup will be loaded here -->
		</div>
	</div>
</div>
@endsection