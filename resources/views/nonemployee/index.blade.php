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
		document.getElementById(divid).style.height= "220px";
		}else {
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
<article id="mail" class="DEC_flex_wrapper" data-category="employee emp_sub_2">
	<!-- Start Heading -->
	<fieldset class="pm0 mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/staffList.png')  }}">
			<h2 class="h2cnt">{{ trans('messages.lbl_nonEmployee') }}</h2>
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
		
			
		</div>
	</div>
	<div class="col-xs-12 pm0 pull-left searchpos" style="margin-top:17.5%;position: fixed;" 
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
					{!! Form::text('singlesearch', $request->singlesearch,
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
							{!! Form::text('employeeno', $request->employeeno,
								array('','class'=>' form-control box95per pull-left','style'=>'height:30px;','id'=>'employeeno')) !!}
						</div>
					</div>
					<div class="mt5">
						<span class="pt3" style="font-family: arial, verdana;">
							{{ trans('messages.lbl_empName') }}
						</span>
						<div class="mt5 box88per" style="display: inline-block!important;">
							{!! Form::text('employeename', $request->employeename,
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
@endsection