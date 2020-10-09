@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/settinglayout.css')) }}
{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::style(asset('public/css/footable.core.css')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::script(asset('public/js/footable.js')) }}
{{ HTML::script(asset('public/js/customer.js')) }}
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
	function pageClick(pageval) {
		$('#page').val(pageval);
		$("#emphistoryviewform").submit();
	}
	function pageLimitClick(pagelimitval) {
		$('#page').val('');
		$('#plimit').val(pagelimitval);
		$("#emphistoryviewform").submit();
	}
</script> 
{{ Form::open(array('name'=>'emphistoryviewform', 'id'=>'emphistoryviewform','url' => 'Customer/Onsitehistory?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 'method' => 'POST')) }}
	{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
	{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
	{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
	{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
	{{ Form::hidden('hdnempid', '$request->hdnempid', array('id' => 'hdnempid')) }}
	{{ Form::hidden('hdnempname', '$request->hdnempname', array('id' => 'hdnempname')) }}
	{{ Form::hidden('hdnback', $request->hdnback, array('id' => 'hdnback')) }}
	{{ Form::hidden('id',$request->id,array('id' => 'id')) }}
	{{ Form::hidden('custid',$request->custid,array('id' => 'custid')) }}
	{{ Form::hidden('viewflg', '3', array('id' => 'viewflg')) }}
	{{ Form::hidden('empid', $request->empid ,array('id' => 'empid')) }}
   	{{ Form::hidden('empname', $request->empname ,array('id' => 'empname')) }}
   	<div class="" id="main_contents">
   		<article id="customer" class="DEC_flex_wrapper" data-category="customer cus_sub_1">
   			<!-- Start Heading -->
			<fieldset class="pm0 mt20">
				<div class="header">
					<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/Client.png')  }}">
					<h2 class="pull-left pl5 mt10">{{ trans('messages.lbl_onsitehistory') }}</h2>
					</h2>
				</div>
			</fieldset>
			<!-- End Heading -->
			<div class="col-xs-12 pm0 pull-left mt5 mt13">
				<div class="pull-left">
					<button type="button" onclick="fngoback('{{ $request->mainmenu }}');"
							class="btn btn-info box80 pull-right">
						<span class="fa fa-arrow-left"> {{ trans('messages.lbl_back')}}
					</button>
				</div>
			</div>
			<div class="col-xs-12 pm0 pull-left mt5 mt13 mb10">
				<div class="pull-left">
					{{ trans('messages.lbl_empid')}} :
					<span class="ml5 colbl fwb">
						{{ $request->hdnempid }}
					</span>
					<span class="ml15 fwb">
						{{ trans('messages.lbl_empName')}} :
					</span>  
					<span class="fwn ml5">
					 {{ $request->hdnempname }} 
					</span>
				</div>
			</div>
			<div class="box100per tableShrink pt10 mnheight mb0">
				<table class="table-striped table footable table-bordered mt10 mb10">
					<colgroup>
						<col width="5%">
						<col width="15%">
						<col width="15%">
						<col width="15%">
						<col width="15%">
						<col width="">
					</colgroup>
					<thead class="CMN_tbltheadcolor">
						<tr class="CMN_tbltheadcolor">
							<th>{{ trans('messages.lbl_sno') }}</th>
							<th>{{ trans('messages.lbl_workStdate') }}</th>
							<th data-hide="phone">{{ trans('messages.lbl_workEdate') }}</th>
							<th data-hide="phone">{{ trans('messages.lbl_yearmonth') }}</th>
							<th data-hide="phone">{{ trans('messages.lbl_status') }}</th>
							<th data-hide="phone">{{ trans('messages.lbl_cusname') }}</th>
							<th data-hide="phone">{{ trans('messages.lbl_branchname') }}</th>
						</tr>
					</thead>
					<tbody class="tablealternateclr">
						@if(count($customerhistory)!="")
							@for ($i = 0; $i < count($customerhistory); $i++)
								<tr>
									<td class="text-center"> {{ $i+1 }} </td>
									<td class="text-center">
										@if($customerhistory[$i]['start_date'] == '0000-00-00' )
										@else
											{{ $customerhistory[$i]['start_date'] }}
										@endif  
									</td>
									<td class="text-center">
										@if($customerhistory[$i]['end_date'] == '0000-00-00' )
										@else
								  			{{ $customerhistory[$i]['end_date'] }}
										@endif 	
									</td>
									<td class="text-center"> {{ $customerhistory[$i]['experience'] }} Yrs </td>
									<td class="text-left">
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
									<td class="text-left">
										{{ $customerhistory[$i]['customer_name'] }}
									</td>
									<td class="text-left">
										{{ $customerhistory[$i]['branch_name'] }}
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
			@if($cushistory->total())
			<div class="text-center col-xs-12 pm0 pagealign">
				@if(!empty($cushistory->total()))
					<span class="pull-left mt24 pagination1">{{ $cushistory->firstItem() }}
						<span class="mt5 pagination2">～</span>
						{{ $cushistory->lastItem() }} / {{ $cushistory->total() }}
					</span>
				　@endif 
				<span class ="pagintion2">
				{{ $cushistory->links() }}
				</span>
				<span class="pull-right pagination mt0">
					{{ $cushistory->linkspagelimit() }}
				</span>
			</div>
			@endif 
   		</article>
   	</div>
{{ Form::close() }}
@endsection