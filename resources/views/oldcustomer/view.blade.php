@extends('layouts.app')
@section('content')

@php use App\Http\Helpers; @endphp

{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::style(asset('public/css/footable.core.css')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::script(asset('public/js/footable.js')) }}
{{ HTML::script(asset('public/js/oldcustomer.js')) }}
{{ HTML::script(asset('public/js/lib/bootstrap-datepicker.min.js')) }}
{{ HTML::style(asset('public/css/lib/bootstrap-datetimepicker.min.css')) }}
<style type="text/css">
	#element_html {
  		position: absolute;
	  	opacity: .01;
	  	height: 0;
	  	overflow: hidden;
	}
	.pm0{padding: 0px;margin: 0px;}
	
	.image1 {
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}
	/*Start Mobile layout*/
	@media all and (max-width: 330px) {
		.banknick{
			font-size: 85%;
		}
	}
	@media all and (max-width: 1200px) {
		.dispviewMainMobile {
			width:100%;
		}
		.dispviewSubMobile {
			width:100%;
		}
	}
	/*End Mobile layout*/
	@media all and (min-width:1205px) {
		.dispviewMainMobile{
			width:52%;
		}
		.dispviewSubMobile{
			width:46%;
		}
	}

	@media all and (max-width: 1200px) {
		.dispviewMainMobile1 {
			width:100%;
		}
		.dispviewSubMobile1 {
			width:100%;
		}
	}
	/*End Mobile layout*/
	@media all and (min-width:1205px) {
		.dispviewMainMobile1 {
			width:52%;
		}
		.dispviewSubMobile1 {
			width:46%;
		}
	}
</style>
<script type="text/javascript">
	function copyContents() {
		$('#element_html').select();
		document.execCommand('copy');
	}
</script>
<div class="" id="main_contents">
	<article id="customer" class="DEC_flex_wrapper" data-category="customer cus_sub_3">
		{{ Form::open(array('name'=>'customerviewform', 'id'=>'customerviewform','url' => 'Customer/index?mainmenu=menu_oldcustomer&time='.date('YmdHis'), 'method' => 'POST')) }}
		{{ Form::hidden('id',$request->id,array('id' => 'id')) }}
		{{ Form::hidden('custid',$request->custid,array('id' => 'custid')) }}
		{{ Form::hidden('editid','',array('id' => 'editid')) }}
		{{ Form::hidden('hid_branch_id','', array('id' => 'hid_branch_id')) }}
		{{ Form::hidden('hid_custid','', array('id' => 'hid_custid')) }}
		{{ Form::hidden('emp_id', $request->emp_id , array('id' => 'emp_id')) }}
		{{ Form::hidden('branchid',$request->branchid, array('id' => 'branchid')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
		{{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }}
		{{ Form::hidden('empid', $request->empid , array('id' => 'empid')) }}
		{{ Form::hidden('selectionid', '1' , array('id' => 'selectionid')) }}
		{{ Form::hidden('hdnempid', '', array('id' => 'hdnempid')) }}
		{{ Form::hidden('hdnempname', '', array('id' => 'hdnempname')) }}
		{{ Form::hidden('hdnback', '3', array('id' => 'hdnback')) }}
		{{ Form::hidden('hdncancel', '1', array('id' => 'hdncancel')) }}
	<!-- Start Heading -->
	<fieldset class="pm0 mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/Client.png')  }}">
			<h2 class="pl5 pull-left mt10">{{ trans('messages.lbl_customer') }}<span class="ml5"></span><span class="colbl ml5">{{ trans('messages.lbl_view') }}</span></h2>
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
			@if(!empty($request->empid))
				<a href="javascript:goempindexpage('Employee',{{ date('YmdHis') }});" class="pageload btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>
			@else
				<a href="javascript:goindexpage('menu_customer',{{ date('YmdHis') }});" class="pageload btn btn-info box80"><span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}</a>
			@endif
		</div>
		<a href="javascript:copyCustomer()" style="float: right;" title="Copy">
			<img class="box30 mr20" src="{{ URL::asset('public/images/copy.png') }}">
		</a>
	</div>

	<fieldset class="mt10 mb10 pull-left dispviewMainMobile">
		<textarea id="element_html"></textarea>
		<div class="col-md-12">
			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_CustId') }}</label>
				</div>
				<div class="col-xs-8 mw">
					<label class="clr_black">
						{{ Form::hidden('txt_custID', (isset($getdetails[0]->custid)) ? $getdetails[0]->custid : '', array('id' => 'txt_custID')) }}
						@if(isset($getdetails[0]->custid))
							{{ $getdetails[0]->custid}}
						@else
							{{ "NILL"}}
						@endif
					</label>
				</div>
			</div>
			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_custname(JP & Eng)') }}</label>
				</div>
				<div class="col-xs-8 mw">
					<label class="clr_black">
						{{ Form::hidden('txt_custnamejp', (isset($getdetails[0]->txt_custnamejp)) ? $getdetails[0]->txt_custnamejp : '', array('id' => 'txt_custnamejp')) }}

						@if(isset($getdetails[0]->txt_custnamejp))
							{{ $getdetails[0]->txt_custnamejp}}
						@else
							{{ "NILL"}}
						@endif
					</label>
				</div>
			</div>

			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_custname(kana)') }}</label>
				</div>
				<div class="col-xs-8 mw">
					{{ Form::hidden('txt_kananame', (isset($getdetails[0]->txt_kananame)) ? $getdetails[0]->txt_kananame : '', array('id' => 'txt_kananame')) }}
					<label class="clr_black">
						@if(isset($getdetails[0]->txt_kananame))
							{{ $getdetails[0]->txt_kananame}}
						@else
							{{ "NILL"}}
						@endif
					</label>
				</div>
			</div>

			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_repname') }}</label>
				</div>
				<div class="col-xs-8 mw">
					{{ Form::hidden('txt_repname', (isset($getdetails[0]->txt_repname)) ? $getdetails[0]->txt_repname : '', array('id' => 'txt_repname')) }}

					<label class="clr_black">
						@if(isset($getdetails[0]->txt_repname))
							{{ $getdetails[0]->txt_repname}}
						@else
							{{ "NILL"}}
						@endif
					</label>
				</div>
			</div>
			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_branchName') }}</label>
				</div>
				<div class="col-xs-8 mw">
					<label class="clr_black">
						{{ Form::hidden('txt_branch_id', (isset($getbranchdetails[0]->branch_id)) ? $getbranchdetails[0]->branch_id : '', array('id' => 'txt_branch_id')) }}

						{{ Form::hidden('txt_branch_name', (isset($getbranchdetails[0]->branch_name)) ? $getbranchdetails[0]->branch_name : '', array('id' => 'txt_branch_name')) }}

						@if(isset($getbranchdetails[0]->branch_name))
							{{ $getbranchdetails[0]->branch_name}}
						@else
							{{ "NILL"}}
						@endif
					</label>
				</div>
			</div>

			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_custagreement') }}</label>
				</div>
				<div class="col-xs-8 mw">
					<label class="clr_black">
						{{ Form::hidden('txt_custagreement', (isset($getdetails[0]->txt_custagreement)) ? $getdetails[0]->txt_custagreement : '', array('id' => 'txt_custagreement')) }}

						@if(isset($getdetails[0]->txt_custagreement))
							{{ $getdetails[0]->txt_custagreement}}
						@else
							{{ "NILL"}}
						@endif
					</label>
				</div>
			</div>

			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_mobilenumber') }}</label>
				</div>
				<div class="col-xs-8 mw">
					<label class="clr_black">
						{{ Form::hidden('txt_mobilenumber', (isset($getdetails[0]->txt_mobilenumber)) ? $getdetails[0]->txt_mobilenumber : '', array('id' => 'txt_mobilenumber')) }}

						@if(isset($getdetails[0]->txt_mobilenumber))
							{{ Helpers::checkTELFAX($getdetails[0]->txt_mobilenumber) }}
						@else
							{{ "NILL"}}
						@endif	
					</label>
				</div>
			</div>

			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_fax') }}</label>
				</div>
				<div class="col-xs-8 mw">
					<label class="clr_black">
						{{ Form::hidden('txt_fax', (isset($getdetails[0]->txt_fax)) ? $getdetails[0]->txt_fax : '', array('id' => 'txt_fax')) }}

						@if(isset($getdetails[0]->txt_fax))
							{{ Helpers::checkTELFAX($getdetails[0]->txt_fax) }}
						@else
							{{ "NILL"}}
						@endif	
					</label>
				</div>
			</div>

			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">URL</label>
				</div>
				<div class="col-xs-8 mw">
					<label class="clr_black">
						{{ Form::hidden('txt_url', (isset($getdetails[0]->txt_url)) ? $getdetails[0]->txt_url : '', array('id' => 'txt_url')) }}

						@if(isset($getdetails[0]->txt_url))
							{{ $getdetails[0]->txt_url}}
						@else
							{{ "NILL"}}
						@endif
					</label>
				</div>
			</div>

			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_address') }}</label>
				</div>
				<div class="col-xs-8 mw">
					<label class="clr_black">
						{{ Form::hidden('txt_address', (isset($getdetails[0]->txt_address)) ? $getdetails[0]->txt_address : '', array('id' => 'txt_address')) }}

						@if(isset($getdetails[0]->txt_address))
							{!! nl2br(e($getdetails[0]->txt_address)) !!}
							<?php 
								$oldaddress="";
								if (strpos($getdetails[0]->txt_address, '〒') !== false) {
									$oldaddress = substr($getdetails[0]->txt_address, strpos($getdetails[0]->txt_address, "〒") + 3,8); 
								}
								if (strpos($oldaddress, '-')) {
									$oldaddress = $oldaddress;
								} else {
									$oldaddress = substr($oldaddress, 0, -1);
								}
							?> 
							{{ Form::hidden('txt_postal',$oldaddress, array('id' => 'txt_postal')) }}
						@else
							{{ "NILL"}}
						@endif
					</label>
				</div>
			</div>

		</div>
	</fieldset>
	@if(count($inchargeview)!="")
	<fieldset class="mt10 pull-right dispviewSubMobile">
		<div class="col-md-12">
		@for ($i = 0; $i < count($inchargeview); $i++)

			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_inchargename') }}</label>
				</div>
				<div class="col-xs-8 mw">
					<label class="clr_black">
						@if(isset($inchargeview[$i]['incharge_name']))
							{{ $inchargeview[$i]['incharge_name'] }} ({{ $inchargeview[$i]['incharge_name_romaji'] }})
						@else
							{{ "NILL"}}
						@endif	
					</label>
				</div>
			</div>

			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_mobilenumber') }}</label>
				</div>
				<div class="col-xs-8 mw">
					<label class="clr_black">
						@if(isset($inchargeview[$i]['incharge_contact_no']))
							{{ Helpers::checkTELFAX($inchargeview[$i]['incharge_contact_no']) }}	
						@else
							{{ "NILL"}}
						@endif
					</label>
				</div>
			</div>

			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_mail') }}</label>
				</div>
				<div class="col-xs-8 mw">
					<label class="clr_black">
						@if(isset($inchargeview[$i]['incharge_email_id']))
							@if(!empty($inchargeview[$i]['incharge_email_id']))
								{{ $inchargeview[$i]['incharge_email_id'] }}
							@else
								{{ 'NILL' }}
							@endif
						@else
							{{ 'NILL' }}
						@endif
					</label>
				</div>
			</div>

			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_designation') }}</label>
				</div>
				<div class="col-xs-8 mw">
					<label class="clr_black">
						@if(isset($inchargeview[$i]['DesignationNM']))
							{{ $inchargeview[$i]['DesignationNM'] }}
						@else
							{{ "NILL"}}
						@endif
					</label>
				</div>
			</div>

		@endfor
		</div>
	</fieldset>
	@endif

	<?php $Allbranch_Idset=""; ?>
	@if(count($branchview)!="")
	<fieldset class="mt20 mb20 col-xs-12 tac">
		<div class="row hline">
			<div class="col-sm-12">
				<h2 class="pl5 pull-left mt15">{{ trans('messages.lbl_branch') }}</h2>
			</div>
		</div>
		@for ($i = 0; $i < count($branchview); $i++)
		<div class="col-md-12">
		<fieldset class="mt20 mb20 dispviewMainMobile1 pull-left tac">

			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_branchid') }}</label>
				</div>
				<div class="col-xs-8 mw text-left">
					<label class="clr_black ">
						@if(isset($branchview[$i]['id']))
							{{ $branchview[$i]['id'] }}
						@else
							{{ "NILL"}}
						@endif
					</label>
				</div>
			</div>

			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_branchName') }}</label>
				</div>
				<div class="col-xs-8 mw text-left">
					<label class="clr_black">
						@if(isset($branchview[$i]['branch_name']))
							{{ $branchview[$i]['branch_name'] }}
						@else
							{{ "NILL"}}
						@endif
					</label>
				</div>
			</div>

			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_mobilenumber') }}</label>
				</div>
				<div class="col-xs-8 mw text-left">
					<label class="clr_black">
						@if(isset($branchview[$i]['branch_contact_no']))
							{{ $branchview[$i]['branch_contact_no'] }}
						@else
							{{ "NILL"}}
						@endif
					</label>
				</div>
			</div>
			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_fax') }}</label>
				</div>
				<div class="col-xs-8 mw text-left">
					<label class="clr_black">
						@if(isset($branchview[$i]['branch_fax_no']))
							{{ $branchview[$i]['branch_fax_no'] }}
						@else
							{{"NILL"}}
						@endif
					</label>
				</div>
			</div>

			<div class="col-xs-12 mt20">
				<div class="col-xs-4 lb text-right">
					<label class="clr_blue">{{ trans('messages.lbl_address') }}</label>
				</div>
				<div class="col-xs-8 mw text-left">
					<label class="clr_black">
						@if(isset($branchview[$i]['branch_address']))
							{!! nl2br(e( $branchview[$i]['branch_address'])) !!}
						@else
							{{ "NILL"}}
						@endif
					</label>
				</div>
			</div>

			<?php 

				if ($Allbranch_Idset == "" && $i == 1) {
					$Allbranch_Idset = $branchview[$i]['id'];
				} elseif ($i > 1) {
					$Allbranch_Idset = $Allbranch_Idset.','.$branchview[$i]['id'];
				}

			?>

		</fieldset>

		</div>
		@endfor
	</fieldset>
	@endif
	{{ Form::hidden('Allbranch_Idset', $Allbranch_Idset, array('id' => 'Allbranch_Idset')) }}

	@if(count($currentview)!="")
		<div class="col-xs-12 pm0 pull-left mt5 mt13">
			<div class="pull-left">
				{{ trans('messages.lbl_currentemployees') }} : 
			</div>
		</div>
		<div class="box100per tableShrink pt10 mnheight mb0">
			<table class="table-striped table footable table-bordered mt10 mb10" >
				<colgroup>
					<col width="5%">
					<col width="7%">
					<col>
					<col width="9%">
					<col width="9%">
					<col width="9%">
					<col width="9%">
					<col width="22%">
				</colgroup>
				<thead class="CMN_tbltheadcolor">
					<tr>
					<th class="tac fs10 sno">{{ trans('messages.lbl_sno') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_empid') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_name') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_workStdate') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_workEdate') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_yearmonth') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_status') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_updated_by') }}</th>
					</tr>
				</thead>
				<tbody class="tablealternateclr">
					@if(count($currentview)!="")
					@for ($i = 0; $i < count($currentview); $i++)
						<tr>
							<td class="text-center">{{$i+1}}</td>
							<td class="text-center colbl fwb"> 
								@if($currentview[$i]['emp_id'])
									{{ $currentview[$i]['emp_id'] }}
								@else
									{{"-"}}
								@endif
							</td>
							<td class="text">
								@if(!empty($currentview[$i]['LastName']))
									{{ $currentview[$i]['LastName'] }} {{ $currentview[$i]['FirstName'] }}
								@else
									{{""}}
								@endif
							</td>
							<td class="text-center">
								@if($currentview[$i]['start_date'])
									{{ $currentview[$i]['start_date'] }}
								@else
									{{"-"}}
								@endif
							</td>
							<td class="text-center">
								@if($currentview[$i]['end_date']!="0000-00-00")
									{{ $currentview[$i]['end_date'] }}
								@else
									{{""}}
								@endif
							</td>
							<td class="text-center">
								@if($currentview[$i]['experience'] != "-")
									{{ $currentview[$i]['experience'] }} Yrs
								@else
									{{ "0.0 Yr"}}
								@endif
							</td>
							<td>
								@if($currentview[$i]['status']=="1")
									{{ "StayIN" }}
								@else
									{{ "-"}}
								@endif
							</td>
							<td>
								@if(!empty($currentview[$i]['update_by']))
									{{ $currentview[$i]['update_by'] }}
								@else
									{{ "-"}}
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
							<td class="text-center red nodatades1" colspan="9">
								{{ trans('messages.lbl_nodatafound') }}
							</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>	
	@endif

	@if(count($currentempview)!="")

		<div class="col-xs-12 pm0 pull-left mt5 mt13">
			<div class="pull-left">
				{{ trans('messages.lbl_oldEmployeee') }} : 
			</div>
		</div>
		<div class="box100per tableShrink pt10 mnheight mb0">
			<table class="table-striped table footable table-bordered mt10 mb10" >
				<colgroup>
					<col width="5%">
					<col width="7%">
					<col>
					<col width="9%">
					<col width="9%">
					<col width="9%">
					<col width="15%">
					<col width="22%">
				</colgroup>
				<thead class="CMN_tbltheadcolor">
				<tr>
					<th class="tac fs10">{{ trans('messages.lbl_sno') }}</th>
					<th class="tac fs10">{{ trans('messages.lbl_empid') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_name') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_workStdate') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_workEdate') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_yearmonth') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_status') }}</th>
					<th data-hide="phone" class="tac fs10">{{ trans('messages.lbl_newemployees') }}</th>
				</tr>
				</thead>
				<tbody>
					@if(count($currentempview)!="")
						@for ($i = 0; $i < count($currentempview); $i++)
						<tr>
							<td class="text-center">{{$i+1}}</td>
							<td class="text-center"> 
								@if($currentempview[$i]['emp_id'])
									{{ $currentempview[$i]['emp_id'] }}
								@else
									{{ "-"}}
								@endif
							</td>
							<td class="text">
								@if(!empty($currentempview[$i]['LastName']))
									{{ $currentempview[$i]['LastName'] }} 
									{{ $currentempview[$i]['FirstName'] }}
								@else
									{{ "-"}}
								@endif
							</td>
							<td class="text-center">
								@if($currentempview[$i]['start_date'])
									{{ $currentempview[$i]['start_date'] }}
								@else
									{{ "-"}}
								@endif
							</td>
							<td class="text-center">
								@if($currentempview[$i]['end_date']!="0000-00-00")
									{{ $currentempview[$i]['end_date'] }}
								@else
									{{ ""}}
								@endif
							</td>
							<td class="text-center">
								@if($currentempview[$i]['experience']!="-")
									{{ $currentempview[$i]['experience'] }} Yrs
								@else
									{{ "0.0 Yr"}}
								@endif
							</td>
							<td>
								@if($currentempview[$i]['status']=='2')	
									{{ "Returned"}}
								@elseif($currentempview[$i]['status']=='3')	
									{{ "Client Changed"}}
								@elseif($currentempview[$i]['status']=='4')	
									{{ "Others"}}
								@else	
									{{ "Work End"}}
								@endif
							</td>
							<td>
								@if($currentempview[$i]['status']=='2')	
									{{ "Microbit"}}
								@elseif($currentempview[$i]['status']=='3')
									@if(isset($currentempview[$i]['customername']))
										{{ $currentempview[$i]['customername'] }}
									@else
									@endif
								@else	
									{{ "-"}}
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
							<td class="text-center red nodatades1" colspan="8">
								{{ trans('messages.lbl_nodatafound') }}
							</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>

	@endif
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