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
		$("#resHistfrm").submit();
	}
	function pageLimitClick(pagelimitval) {
		$('#page').val('');
		$('#plimit').val(pagelimitval);
		$("#resHistfrm").submit();
	}

</script>
{{ Form::open(array('name'=>'resHistfrm',
		'id'=>'resHistfrm',
		'url' => 'Employee/resumeHistory?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
		'method' => 'POST')) }}
		
		{{ Form::hidden('viewid', '' , array('id' => 'viewid')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('title', '' , array('id' => 'title')) }}
		{{ Form::hidden('empid', $request->empid ,array('id' => 'empid')) }}
		{{ Form::hidden('empname', $request->empname ,array('id' => 'empname')) }}
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="mail" class="DEC_flex_wrapper" data-category="employee emp_sub_1">
	<!-- Start Heading -->
	<fieldset class="pm0 mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/staffList.png')  }}">
			<h2 class="h2cnt">{{ trans('messages.lbl_ResumeHist') }}
			</h2>
		</div>
	</fieldset>
	<!-- End Heading -->

	<div class="box100per tableShrink pt10 mnheight mb0">
		<div class=""> 
			<a href="javascript:fnredirectindex();" class="button pull-left button-blue textDecNone" 
				style="text-decoration: none !important;">
				<span class="fa fa-arrow-left"></span> {{ trans('messages.lbl_back') }}
			</a>
		</div> <br/> <br/>
		<div class="fwb mt5 mb5 "> 
			{{ trans('messages.lbl_empid')}}
			<span class="ml5 brown fwb">
				{{ $request->empid }}
			</span>
			<span class="ml15 fwb">
				{{ trans('messages.lbl_empName')}}
			</span>  
			<span class="fwn blue ml5">
				{{ $employeDetail[0]->FirstName }}&nbsp{{ $employeDetail[0]->LastName }}
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
						{{ trans('messages.lbl_cvName') }}
					</th>
					<th class="tac fs10">
						{{ trans('messages.lbl_cvName') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_upDate') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_download') }}
					</th>
				</tr>
			</thead>
			<tbody class="tablealternateclr">
				@if(count($resumedetails)!="")
					@for ($i = 0; $i < count($resumedetails); $i++)
					<tr>
						<td class="text-center vam">
							{{ $i+1 }} 
						</td>

						<td>
							{{ $resumedetails[$i]->resume}}
						</td>

						<td>
							{{ $resumedetails[$i]->createdDate }}
						</td>

						<td>
							<a href="javascript:downloadResume('{{ $resumedetails[$i]->resume }}','History');" style="color:blue;" class="pl10 pb5">
									{{ trans('messages.lbl_download') }} </a>
						</td>
					</tr>
					@endfor
				@else
				<tr class="nodata">
					<td class="text-center red nodatades1" colspan="4">
						{{ trans('messages.lbl_nodatafound') }}
					</td>
				</tr>
				@endif
			</tbody>
		</table>
	</div>

	<div class="text-center">
		@if(!empty($resumedetails->total()))
			<span class="pull-left mt24">
				{{ $resumedetails->firstItem() }} ~ {{ $resumedetails->lastItem() }} / {{ $resumedetails->total() }}
			</span>
		@endif 
		{{ $resumedetails->links() }}
		<div class="CMN_display_block flr">
				{{ $resumedetails->linkspagelimit() }}
		</div>
	</div>

	{{ Form::close() }}

	{{ Form::open(array('name'=>'formpdfdwnld',
							'id'=>'formpdfdwnld',
							'url' => 'Interview/resexceldownloadprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
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