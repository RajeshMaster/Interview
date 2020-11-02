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
		$("#emphistoryform").submit();
	}
	function pageLimitClick(pagelimitval) {
		$('#page').val('');
		$('#plimit').val(pagelimitval);
		$("#emphistoryform").submit();
	}
</script>
{{ Form::open(array('name'=>'emphistoryform',
		'id'=>'emphistoryform',
		'url' => 'Employee/empHistory?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
		'method' => 'POST')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
		{{ Form::hidden('hdnempid', '', array('id' => 'hdnempid')) }}
		{{ Form::hidden('hdnempname', '', array('id' => 'hdnempname')) }}
		{{ Form::hidden('viewflg', '1', array('id' => 'viewflg')) }}
		{{ Form::hidden('id','',array('id' => 'id')) }}
		{{ Form::hidden('custid','',array('id' => 'custid')) }}
		{{ Form::hidden('empid','',array('id' => 'empid')) }}
		{{ Form::hidden('hdnback', '1', array('id' => 'hdnback')) }}
		{{ Form::hidden('pageflg', '1', array('id' => 'pageflg')) }}
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="employee" class="DEC_flex_wrapper" data-category="employee emp_sub_4">
	<!-- Start Heading -->
	<fieldset class="pm0 mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/employee.png')  }}">
			<h2 class="h2cnt">{{ trans('messages.lbl_emphistory') }}</h2>
		</div>
	</fieldset>
	<!-- End Heading -->

	<div class="box100per tableShrink pt10 mnheight mb0">
		<table class="table-striped table footable table-bordered mt10 mb10" >
			<colgroup>
				<col width="4%">
				<col width="7%">
				<col width="">
				<col width="10%">
				<col width="10%">
				<col width="10%">
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
						{{ trans('messages.lbl_name') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_Start_date') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_End_date') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_NoofYears') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_client_name') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_branch') }}
					</th>
					<th data-hide="phone" class="tac fs10">
					</th>
				</tr>
			</thead>
			<tbody class="tablealternateclr">
				@if(count($empdetailsdet)!="")
					@for ($i = 0; $i < count($empdetailsdet); $i++)
						<tr>
							<td class="text-center">
								{{ ($empdetails->currentpage()-1) * $empdetails->perpage() + $i + 1 }}
							</td>

							<td class="text-center">
								{{ $empdetailsdet[$i]['Emp_ID'] }}
							</td class="text-center">

							<td>
                				{{ $empdetailsdet[$i]['LastName'] }} {{ $empdetailsdet[$i]['FirstName'] }} 
                			</td>
                			<td class="text-center">
                				{{ $empdetailsdet[$i]['start_date'] }}
                			</td>
                			<td class="text-center">
                				{{ $empdetailsdet[$i]['end_date'] }}
                			</td>
                			<td class="text-center">
                				@if($empdetailsdet[$i]['experience']== '-')
                 				@else 
                  					{{ $empdetailsdet[$i]['experience'] }} Yrs
                 				@endif
                			</td>
                			<td>
                				<a class="colbl" href="javascript:customerview('{{ date('YmdHis') }}','{{ $empdetailsdet[$i]['id'] }}','{{ $empdetailsdet[$i]['cust_id'] }}');">
                     		 	{{ $empdetailsdet[$i]['customer_name'] }}</a>
                     		 </td>
                			<td class="text-left">
                				{{ $empdetailsdet[$i]['branch_name'] }}
                			</td>
                			<td class="text-center">
                				<a class="colbl" href="javascript:getdetails('{{ $empdetailsdet[$i]['Emp_ID'] }}','{{ $empdetailsdet[$i]['LastName'] }}','{{ date('YmdHis') }}','1');">{{ "Details" }}
                  				</a>    
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
						<td class="text-center red nodatades1" colspan="8">
							{{ trans('messages.lbl_nodatafound') }}
						</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
	@if(!empty($empdetails))
		<div class="text-center">
			@if(!empty($empdetails->total()))
				<span class="pull-left mt24">
					{{ $empdetails->firstItem() }} ~ {{ $empdetails->lastItem() }} / {{ $empdetails->total() }}
				</span>
			@endif 
				{{ $empdetails->links() }}
			<div class="CMN_display_block flr">
					{{ $empdetails->linkspagelimit() }}
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