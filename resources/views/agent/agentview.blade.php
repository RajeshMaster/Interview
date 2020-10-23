@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/agent.js')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::style(asset('public/css/designtable.css')) }}
<div class="" id="main_contents">
	<article id="customer" class="DEC_flex_wrapper" data-category="customer cus_sub_2">
		<fieldset class="mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/Client.png')  }}">
				<h2 class="h2cnt">{{ trans('messages.lbl_agent') }}</h2>
				<h2 class="pull-left h2cnt">&#9642;</h2> 
				<h2 class="pull-left h2cnt" style="color:blue;">{{ trans('messages.lbl_view') }}
				</h2>
			</div>
		</fieldset>
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
		
		{{ Form::open(array('name'=>'agentviewform', 'id'=>'agentviewform','url' => 'Agent/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 'method' => 'POST')) }}
		{{ Form::hidden('id',$request->id,array('id' => 'id')) }}
		{{ Form::hidden('agentId',$request->agentId,array('id' => 'agentId')) }}
		{{ Form::hidden('editflg','',array('id' => 'editflg')) }}
		{{ Form::hidden('cuseditflg','',array('id' => 'cuseditflg')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
		{{ Form::hidden('hidselectcus', null, array('id' => 'hidselectcus')) }}
		{{ Form::hidden('selected',$allcustomernames, array('id' => 'selected')) }}
		<div class="col-xs-12 pull-left mt10 mb10">
			<a href="javascript:goindexpage();" class="button button-blue textDecNone" 
				style="text-decoration: none !important;">
				<span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}
			</a>
			<a href="javascript:edit('{{ $getdetails[0]->id}}','{{ $getdetails[0]->txt_agentId}}');" 
				class="button button-orange textDecNone"
				style="text-decoration: none !important;">
				<span class="fa fa-edit"></span> {{ trans('messages.lbl_edit') }}
			</a>
			@if(!isset($getdetails[0]->customerId) && ($getdetails[0]->customerId == "" || $getdetails[0]->customerId == NULL))
				<a href="javascript:customerAddEdit('add','{{ $getdetails[0]->txt_agentId}}' );" style="float: right; margin-top: inherit;">
					<span class="fa fa-plus csrp"></span><span class="ml5 csrp">{{trans('messages.lbl_newCustomer')}}</span>
				</a>
			@else
				<a href="javascript:customerAddEdit('edit','{{ $getdetails[0]->txt_agentId}}' );" style="float: right; margin-top: inherit;">
					<span class="fa fa-pencil csrp"></span><span class="ml5 csrp">{{trans('messages.lbl_newCustomer')}}</span>
				</a>
			@endif	
		</div>
		<fieldset class="mt2">
			<div class="col-xs-12">
				<div class="col-xs-9 mt10">
					<div class="col-xs-4 tar lb">
						{{ Form::label(trans('messages.lbl_agentId'), trans('messages.lbl_agentId'), array('class' => 'mailnum clr_blue')) }}
					</div>
					<div class="col-xs-8 fontcolor fwb mw clr_black">
						@if(isset($getdetails[0]->txt_agentId))
							{{ $getdetails[0]->txt_agentId}}
						@else
							{{ "NILL"}}
						@endif	
					</div>
				</div>
				<div class="col-xs-9 mt10">
					<div class="col-xs-4 tar lb">
						{{ Form::label(trans('messages.lbl_agentname(JP&Eng)'), trans('messages.lbl_agentname(JP&Eng)'), array('class' => 'mailnum clr_blue')) }}
					</div>
					<div class="col-xs-8 fontcolor fwb mw clr_black">
						@if(isset($getdetails[0]->txt_agentName))
							{{ $getdetails[0]->txt_agentName}}
						@endif		
					</div>
				</div>
				<div class="col-xs-9 mt10">
					<div class="col-xs-4 tar lb">
						{{ Form::label(trans('messages.lbl_agentname(kana)'), trans('messages.lbl_agentname(kana)'), array('class' => 'mailnum clr_blue')) }}
					</div>
					<div class="col-xs-8 fontcolor fwb mw clr_black">
						@if(isset($getdetails[0]->txt_agentNameJp))
							{{ $getdetails[0]->txt_agentNameJp}}
						@else
							{{ "NILL"}}
						@endif	 	
					</div>
				</div>
				<!-- <div class="col-xs-9 mt10">
					<div class="col-xs-4 tar lb">
						{{ Form::label(trans('messages.lbl_custname'), trans('messages.lbl_custname'), array('class' => 'mailnum clr_blue')) }}
					</div>
					<div class="col-xs-8 fontcolor fwb mw clr_black">
						@if(isset($allcustomernames))
							{{ $allcustomernames}}
						@else
							{{ "NILL"}}
						@endif	 	
					</div>
				</div> -->
				<div class="col-xs-9 mt10">
					<div class="col-xs-4 tar lb">
						{{ Form::label(trans('messages.lbl_email'), trans('messages.lbl_email'), array('class' => 'mailnum clr_blue')) }}
					</div>
					<div class="col-xs-8 fontcolor fwb mw clr_black">
						@if(isset($getdetails[0]->txt_emailId))
							{{ $getdetails[0]->txt_emailId }}
						@else
							{{ "NILL" }}
						@endif	 	
					</div>
				</div>
				<div class="col-xs-9 mt10">
					<div class="col-xs-4 tar lb">
						{{ Form::label(trans('messages.lbl_agentagreement'), trans('messages.lbl_agentagreement'), array('class' => 'mailnum clr_blue')) }}
					</div>
					<div class="col-xs-8 fontcolor fwb mw clr_black">
						@if(isset($getdetails[0]->txt_agentContract))
							{{ $getdetails[0]->txt_agentContract }}
						@else
							{{ "NILL"}}
						@endif	 	
					</div>
				</div>
				<div class="col-xs-9 mt10">
					<div class="col-xs-4 tar lb">
						{{ Form::label(trans('messages.lbl_mobilenumber'), trans('messages.lbl_mobilenumber'), array('class' => 'mailnum clr_blue')) }}
					</div>
					<div class="col-xs-8 fontcolor fwb mw clr_black">
						@if(isset($getdetails[0]->txt_mobilenumber))
							{{ $getdetails[0]->txt_mobilenumber }}
						@else
							{{ "NILL"}}
						@endif	 	
					</div>
				</div>
				<div class="col-xs-9 mt10">
					<div class="col-xs-4 tar lb">
						{{ Form::label(trans('messages.lbl_fax'), trans('messages.lbl_fax'), array('class' => 'mailnum clr_blue')) }}
					</div>
					<div class="col-xs-8 fontcolor fwb mw clr_black">
						@if(isset($getdetails[0]->txt_fax)  && $getdetails[0]->txt_fax !="")
							{{ $getdetails[0]->txt_fax }}
						@else
							{{ "NILL"}}
						@endif	 	
					</div>
				</div>
				<div class="col-xs-9 mt10">
					<div class="col-xs-4 tar lb">
						{{ Form::label(trans('messages.lbl_url'), trans('messages.lbl_url'), array('class' => 'mailnum clr_blue')) }}
					</div>
					<div class="col-xs-8 fontcolor fwb mw clr_black">
						@if(isset($getdetails[0]->txt_url) && $getdetails[0]->txt_url !="")
							{{ $getdetails[0]->txt_url}}
						@else
							{{ "NILL"}}
						@endif		
					</div>
				</div>
				<div class="col-xs-9 mt10">
					<div class="col-xs-4 tar lb">
						{{ Form::label(trans('messages.lbl_postalCode'), trans('messages.lbl_postalCode'), array('class' => 'mailnum clr_blue')) }}
					</div>
					<div class="col-xs-8 fontcolor fwb mw clr_black">
						@if(isset($getdetails[0]->postalNumber))
							<b>〒</b>&nbsp;{!! nl2br(e($getdetails[0]->postalNumber)) !!}
						@else
							{{ "NILL"}}
						@endif		
					</div>
				</div>
				<div class="col-xs-9 mt10">
					<div class="col-xs-4 tar lb">
						{{ Form::label(trans('messages.lbl_kenmei'), trans('messages.lbl_kenmei'), array('class' => 'mailnum clr_blue')) }}
					</div>
					<div class="col-xs-8 fontcolor fwb mw clr_black">
						@if(isset($getdetails[0]->kenmei))
							{!! nl2br(e($getdetails[0]->prefNameJP)) !!}
						@else
							{{ "NILL"}}
						@endif		
					</div>
				</div>
				<div class="col-xs-9 mt10">
					<div class="col-xs-4 tar lb">
						{{ Form::label(trans('messages.lbl_address'), trans('messages.lbl_address'), array('class' => 'mailnum clr_blue')) }}
					</div>
					<div class="col-xs-8 fontcolor fwb mw clr_black">
						@if(isset($getdetails[0]->shimei) && (isset($getdetails[0]->street_address)))
							{!! nl2br(e($getdetails[0]->shimei)) !!}&nbsp;&nbsp;{!! nl2br(e($getdetails[0]->street_address)) !!} &nbsp;{!! nl2br(e($getdetails[0]->buildingname)) !!}
						@else
							{{ "NILL"}}
						@endif			
					</div>
				</div>
				<div class="col-xs-9 mt10">
					<div class="col-xs-4 tar lb">
						{{ Form::label(trans('messages.lbl_remarks'), trans('messages.lbl_remarks'), array('class' => 'mailnum clr_blue')) }}
					</div>
					<div class="col-xs-8 fontcolor fwb mw clr_black">
						@if(isset($getdetails[0]->txt_address) && $getdetails[0]->txt_address!="")
							{!! nl2br(e($getdetails[0]->txt_address)) !!}
						@else
							{{ "NILL"}}
						@endif		
					</div>
				</div>
			</div>
		</fieldset>
		{{ Form::close() }}
		<div class="col-xs-12 pm0 pull-left mt5 mt13">
			<div class="pull-left">
				{{ trans('messages.lbl_customer') }} : 
			</div>
		</div>
		<div class="box100per tableShrink pt10 mnheight mb0">
			<table class="table-striped table footable table-bordered mt10 mb10">
				<colgroup>
					<col width="4%">
					<col width="5%">
					<col width="7%">
					
					<col width="9%">
					<col width="9%">
					
					
				</colgroup>
				<thead class="CMN_tbltheadcolor">
				<tr>
					<th class="tac fs10 sno">{{ trans('messages.lbl_sno') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_empid') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_name') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_mobileno') }}</th>
					<th data-hide="phone" class="tac fs10"></th>
					
				</tr>
			</thead>
			<tbody class="tablealternateclr">
				@if(count($getCusName[0])!="")
					@for ($i = 0; $i < count($getCusName); $i++)
					@if(isset($getCusName[$i][0]->customer_id) && $getCusName[$i][0]->customer_id!="")
					<tr>
						<td class="text-center">
							@if(isset($getCusName[$i][0]->customer_id) && $getCusName[$i][0]->customer_id!="")
							{{$i+1}}
							@endif
						</td>
						<td class="text-center">
							@if(isset($getCusName[$i][0]->customer_id) && $getCusName[$i][0]->customer_id!="")
							{{ $getCusName[$i][0]->customer_id }}
							@endif
							
						</td>
						<td class="text-center">
							@if(isset($getCusName[$i][0]->customer_name) && $getCusName[$i][0]->customer_name!="")
							{{ $getCusName[$i][0]->customer_name }}
							@endif
						</td>
						<td> 
							@if(isset($getCusName[$i][0]->customer_contact_no) && $getCusName[$i][0]->customer_contact_no!="")
							{{ $getCusName[$i][0]->customer_contact_no }} 
							@endif
						</td>
						<td> 
							@if(isset($getCusName[$i][0]->customer_id) && $getCusName[$i][0]->customer_id!="")
							<a href="javascript:fnRemove('{{ $getCusName[$i][0]->customer_id }}');">
								Remove
							</a>
							@endif
					 	</td>
					</tr>
					@endif
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
	</article>
</div>
<div id="cusGroup" class="modal fade" style="width: 775px;">
	<div id="login-overlay">
		<div class="modal-content">
			<!-- Popup will be loaded here -->
		</div>
	</div>
</div>
<script>
	$('.footable').footable({
		calculateWidthOverride: function() {
			return { width: $(window).width() };
		}
	}); 
</script>
@endsection