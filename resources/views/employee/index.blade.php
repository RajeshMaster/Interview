@extends('layouts.app')
@section('content')
<?php use App\Http\Helpers;?>
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
		$("#employeefrm").submit();
	}
	function pageLimitClick(pagelimitval) {
		$('#page').val('');
		$('#plimit').val(pagelimitval);
		$("#employeefrm").submit();
	}
	function mulclick(divid){
		if($('#'+divid).css('display') == 'block'){
			document.getElementById(divid).style.display = 'none';
			document.getElementById(divid).style.height = "210px";
		} else {
			document.getElementById(divid).style.display = 'block';
		}
	}
</script>
{{ Form::open(array('name'=>'employeefrm',
		'id'=>'employeefrm',
		'url' => 'Employee/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
		'method' => 'POST')) }}
		{{ Form::hidden('resignid', '' , array('id' => 'resignid')) }}
		{{ Form::hidden('sorting', '' , array('id' => 'sorting')) }}
		{{ Form::hidden('viewid', '' , array('id' => 'viewid')) }}
		{{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('title', '' , array('id' => 'title')) }}
		{{ Form::hidden('sortOptn',$request->staffsort , array('id' => 'sortOptn')) }}
		{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
		{{ Form::hidden('empid', $request->empid ,array('id' => 'empid')) }}
		{{ Form::hidden('empname', $request->empname ,array('id' => 'empname')) }}
		{{ Form::hidden('DOJ', $request->DOJ ,array('id' => 'DOJ')) }}
		{{ Form::hidden('hdnback', '', array('id' => 'hdnback')) }}
		{{ Form::hidden('ordervalue', $request->ordervalue, array('id' => 'ordervalue')) }}
		{{ Form::hidden('hdnempid', '$request->hdnempid', array('id' => 'hdnempid')) }}
		{{ Form::hidden('hdnempname', '$request->hdnempname', array('id' => 'hdnempname')) }}
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="employee" class="DEC_flex_wrapper" data-category="employee emp_sub_2">
	<!-- Start Heading -->
	<fieldset class="pm0 mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/staffList.png')  }}">
			<h2 class="h2cnt">{{ trans('messages.lbl_employee') }}
				<span style="font-weight:normal;font-size:16px;">({{ trans('messages.lbl_avgage') }} :
					<span style="color:#136E83;font-weight:normal;font-size:16px;">
						<?php echo number_format($detailage[0]->avg_age, 1);?>)
					</span>
				</span>
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
			<!-- <a class="btn btn-linkemp" href="javascript:candiateInt();" class="pl10 pb5">
			Interview Candiate
			</a><span>|</span> -->
			<a class="btn btn-linkemp {{ $disabledEmp }}" href="javascript:selectActive(0,2);" class="pl10 pb5">
					{{ trans('messages.lbl_employee') }}
			</a>
			<span>|</span>
			<a class="btn btn-linkemp {{ $disabledNotEmp }}" href="javascript:selectActive(0,3);" class="pl10 pb5">
				{{ trans('messages.lbl_nonMB') }}
			</a>
		</div>
		<a href="javascript:clearsearch()" title="Clear Search">
			<img class="pull-right box35 mr10 pageload clearposition" src="{{ URL::asset('public/images/clearsearch.png')  }}">
		</a>
		{{ Form::select('staffsort', $array, $request->staffsort,
						array('class' => 'form-control'.' ' .$request->sortstyle.' '.'CMN_sorting pull-right',
					   'id' => 'staffsort',
					   'name' => 'staffsort'))
		}}
	</div>

	<div style="margin-top:13.5%;position: fixed;" 
		@if($request->singlesearch != ""  || $request->searchmethod == 2) 
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
					{!! Form::text('singlesearch', trim($request->singlesearch),
					array('','class'=>' form-control box80per pull-left','style'=>'height:30px;','id'=>'singlesearch')) !!}

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
			<a onclick="mulclick('demo');" class="" style="font-family: arial, verdana;cursor: pointer;">
				{{ trans('messages.lbl_multi_search') }}
			</a>
		</div>

		<div>
			 <ul id="demo" @if ($request->searchmethod == 2) class="collapse in ml5 pull-left" 
						  @else class="collapse ml5 pull-left"  @endif>
				 <li class="theme-option"  onKeyPress="return checkSubmitmulti(event)">
					<div class="mt5">
						<span class="pt3" style="font-family: arial, verdana;">
							{{ trans('messages.lbl_empid') }}
						</span>
						<div class="mt5 box88per" style="display: inline-block!important;">
							{!! Form::text('employeeno', trim($request->employeeno),
								array('','class'=>' form-control box95per pull-left','style'=>'height:30px;','id'=>'employeeno')) !!}
						</div>
					</div>

					<div class="mt5">
						<span class="pt3" style="font-family: arial, verdana;">
							{{ trans('messages.lbl_empName') }}
						</span>
						<div class="mt5 box88per" style="display: inline-block!important;">
							{!! Form::text('employeename', trim($request->employeename),
								array('','class'=>' form-control box95per pull-left','style'=>'height:30px;','id'=>'employeename')) !!}
						</div>
					</div>

					<div class="mt5 mb6">
						 {{ Form::button(
							 '<i class="fa fa-search" aria-hidden="true"></i> '.trans('messages.lbl_search'),
							 array('class'=>'mt10 btn btn-info btn-sm ',
									'onclick' => 'javascript:return fnMultiSearch()',
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
				<col width="70%">
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
						{{ trans('messages.lbl_empdetails') }}
					</th>
					<th data-hide="phone" class="tac fs10">
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_doj') }}
					</th>
				</tr>
			</thead>
			<tbody class="tablealternateclr">
				@if(count($empdetailsdet)!="")
					@for ($i = 0; $i < count($empdetailsdet); $i++)
					<tr>
						<td class="text-center vam">
							{{ ($empdetails->currentpage()-1) * $empdetails->perpage() + $i + 1 }}
						</td>
						<td>
							<div class="tac">
								<label>
									<a href="javascript:employeeview('{{ $empdetailsdet[$i]['Emp_ID'] }}');" style="color:blue;" class="vam ml18">
										{{ $empdetailsdet[$i]['Emp_ID'] }}
									</a>
								<br>
								{{--*/ $file_exist = "../../uploads/profile/original/" . $empdetailsdet[$i]['Picture']; /*--}}
								{{--*/ $filename = $disPath . $empdetailsdet[$i]['Picture']; /*--}}
								@if (!file_exists($filename))
									{{--*/ $empdetailsdet[$i]['Picture'] = ""; /*--}}
								@endif

								@if($empdetailsdet[$i]['Picture'] != "")
									{{--*/ $src = $file_exist; /*--}}
								@else
									@if($empdetailsdet[$i]['Gender'] == 1)
										{{--*/ $src = $noimage . '/no-prof-male.JPG'; /*--}}
									@else
										{{--*/ $src = $noimage . '/no-prof-female.jpg'; /*--}}
									@endif
								@endif
								<!-- <div style="border: 2px solid red;text-align: center;"> -->
									<img class="pull-left box70 ml20 tac" src="{{ $src }}" width="90" height = "70"></img>
								<!-- </div> -->
								</label>
							</div>
						</td>

						<td>
							<div class="ml5">
								<div>　
									<span class="fll">
										{{ $empdetailsdet[$i]['FirstName'] }}
									</span>
									<span class="fwb" style="margin-left: -10px">
										{{ $empdetailsdet[$i]['LastName'] }}
									</span>
									
									<span class="" style="float: right">

									</span>
									@if($empdetailsdet[$i]['KanaFirstName'] != "" && $empdetailsdet[$i]['KanaLastName'] != "")
										<div>　
											<span class="fll">
												{{ $empdetailsdet[$i]['KanaFirstName'] }}
											</span>
											<span class="fwb" style="margin-left: -10px">
												{{ $empdetailsdet[$i]['KanaLastName'] }}
											</span>
										</div>
									@endif

									<div>
										<span class="f28 clr_blue"> 
											{{ trans('messages.lbl_dob') }} :
										</span>
										<span class="f12"> 
											{{ $empdetailsdet[$i]['DOB'] }} <b>
											@if(!empty($empdetailsdet[$i]['DOB']))({{ birthday($empdetailsdet[$i]['DOB']) }})@endif</b>
										</span>
										<span class="f28 clr_blue">
											{{ trans('messages.lbl_mobileno') }} :
										</span>
										<span class="f12"> 
											{{ (!empty($empdetailsdet[$i]['Mobile1']) ?  $empdetailsdet[$i]['Mobile1'] : "Nill")  }}
										</span>
										<span class="f18 clr_blue">
											{{ trans('messages.lbl_email') }} :
										</span>
										<span class="f12"> 
											{{ $empdetailsdet[$i]['Emailpersonal'] }}
										</span>
									</div>

									<div>
										<span class="clr_blue">{{ trans('messages.lbl_streetaddress') }}</span> :
										<span class="f12"> 
											{{ (!empty($empdetailsdet[$i]['Address1']) ?  $empdetailsdet[$i]['Address1'] : "Nill")  }}
										</span>
									</div>

									<div>
										<span class="clr_blue">{{ trans('messages.lbl_customer') }}</span> :
										<span class="f12"> 
										{{ (!empty($empdetailsdet[$i]['customer_name']) ?  $empdetailsdet[$i]['customer_name'] : "Nill")  }}
										</span>
									</div>

									<div class="mb4 CMN_display_block mt4">
										<div class="CMN_display_block">
											<a style="color:blue;" href="javascript:cushistory('{{ $empdetailsdet[$i]['Emp_ID'] }}','{{ $empdetailsdet[$i]['LastName'] }}');">{{ trans('messages.lbl_customer') }}</a>
										</div>
										&nbsp;|
										<div class="CMN_display_block">
											@if($empdetailsdet[$i]['clientStatus'] == 0 )
												<a style="color:blue;" href="javascript:workend('{{ $empdetailsdet[$i]['Emp_ID'] }}','{{ $empdetailsdet[$i]['LastName'] }}');">{{ trans('messages.lbl_workEdate') }}</a>&nbsp;|
											@else
												{{ trans('messages.lbl_workEdate') }}&nbsp;|
											@endif
										</div>

										<div class="CMN_display_block">
											<a style="color:blue;" href="javascript:uploadResume('{{ $empdetailsdet[$i]['Emp_ID'] }}','{{ $empdetailsdet[$i]['LastName'] }}');">{{ trans('messages.lbl_upResume') }}</a>&nbsp;|
										</div>

										<div class="CMN_display_block">
											<a style="color:blue;" href="javascript:resumeHistory('{{ $empdetailsdet[$i]['Emp_ID'] }}')">{{ trans('messages.lbl_cvHist') }}</a>
											
										</div>
									</div>

								</div>
							</div>
						</td>

						<td>
							@if($empdetailsdet[$i]['recentResume'] != "")
								{{--*/ $src = $noimage . '/pdf.png'; /*--}}
								<a href="javascript:downloadResume('{{ $empdetailsdet[$i]['recentResume'] }}')" ><img class="box30" src="{{ $src }}" width="30" height = "30"></img>
								</a>
							@else
								{{--*/ $src = $noimage . '/nopdf.png'; /*--}}
								<img class=" box30 " src="{{ $src }}" width="30" height = "30"></img>
							@endif
							@if($empdetailsdet[$i]['recentxlResume'] != "")
								{{--*/ $src = $noimage . '/excel_a.png'; /*--}}
								<a href="javascript:downloadResume('{{ $empdetailsdet[$i]['recentxlResume'] }}')" ><img class="box30" src="	{{ $src }}" width="32" height = "36"></img>
								</a>
							@else
								{{--*/ $src = $noimage . '/excel_ia.png'; /*--}}
								<img class="box30" src="	{{ $src }}" width="32" height = "36"></img>
								</a>
							@endif

						</td>

						<td class="tac">
							<div class="45px">
								<span>{{ $empdetailsdet[$i]['DOJ'] }}</span>
							</div>
							<div class="mt55">
								<span class="clr_blue">
									@if($empdetailsdet[$i]['experience'] > 1 )
										{{ $empdetailsdet[$i]['experience'] }} Yrs
									@elseif($empdetailsdet[$i]['experience'] <= 1 )
										{{ $empdetailsdet[$i]['experience'] }} Yr
									@else
										{{ 0 }} Yr
									@endif		
								</span>
							</div>
						</td>
					</tr>
					@endfor
				@else
				<tr class="nodata">
					<td class="text-center red nodatades1" colspan="5">
						{{ trans('messages.lbl_nodatafound') }}
					</td>
				</tr>
				@endif
			</tbody>
		</table>
	</div>

	@if(!empty($empdetailsdet))
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

	{{ Form::open(array('name'=>'formpdfdwnld',
							'id'=>'formpdfdwnld',
							'url' => 'employee/exceldownloadprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
							'files'=>true,
							'method' => 'POST')) }}
		{{ Form::hidden('filenamePdf', '' , array('id' => 'filenamePdf')) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('empId', $request->empId , array('id' => 'empId')) }}
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