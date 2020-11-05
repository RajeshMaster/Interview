@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/user.js')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
<style type="text/css">
	.textDecNone:hover {
		text-decoration: none !important;
		color: white !important;
	}
</style>
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
</script>
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="userlist" class="DEC_flex_wrapper" data-category="userlist userlist_sub_1">
	<fieldset class="headerbg mt20">
		{{ Form::open(array('name'=>'employeeview',
								'id'=>'employeeview',
								'url' => '', 
								'method' => 'POST',
								'files'=>true)) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('filenamePdf', '' , array('id' => 'filenamePdf')) }}
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/list.png')  }}">
			<h2 class="h2cnt">
				{{ trans('messages.lbl_empdetails') }}
			</h2>
		</div>
	</fieldset>
	@php $i = 0; @endphp
	@foreach($mailView as $mailkey => $mailvalue)
	<fieldset class="mt10 mb10">
		<div class="col-xs-9 mt10">
			<div class="col-xs-4 lb text-right">
				<label class="clr_blue">
					{{ trans('messages.lbl_empid') }}
				</label>
			</div>
			<div class="col-xs-8 mw clr_black">
				@if(isset($empDtls[$i][$mailvalue->empId]['Emp_ID']))
					{{ $empDtls[$i][$mailvalue->empId]['Emp_ID'] }}
				@else
					{{ trans('messages.lbl_nil') }}
				@endif
			</div>
		</div>
		<div class="col-xs-9 mt10">
			<div class="col-xs-4 lb text-right pm0">
				<label class="clr_blue">{{ trans('messages.lbl_empName')}}</label>
			</div>
			<div class="col-xs-8 mw pm0 clr_black">
				@if(isset($empDtls[$i][$mailvalue->empId]['FirstName']))
					{{ strtoupper(substr($empDtls[$i][$mailvalue->empId]['FirstName'], 0, 1)) }}
				@else
					{{ trans('messages.lbl_nil') }}
				@endif
				@if(isset($empDtls[$i][$mailvalue->empId]['LastName']))
					{{ strtoupper(substr($empDtls[$i][$mailvalue->empId]['LastName'], 0, 1)) }}
				@else
					{{ trans('messages.lbl_nil') }}
				@endif
			</div>
		</div>
		<div class="col-xs-9 mt10 mb10">
			<div class="col-xs-4 lb text-right pm0">
				<label class="clr_blue">{{ trans('messages.lbl_pdffile')}}</label>
			</div>
			<div class="col-xs-8 mw clr_black">
				@if(isset($mailvalue->pdfNames))
					<!-- {{ $mailvalue->pdfNames }} -->
					{{--*/ $src = '../public/images/pdf.png'; /*--}}
					<a href="javascript:downloadResume('{{ $mailvalue->pdfNames }}')">
						<img class="box30" src="{{ $src }}" width="30" height = "30"></img>
					</a>
				@else
					{{ trans('messages.lbl_nil') }}
				@endif
			</div>
		</div>
	</fieldset>
	@php $i++; @endphp
	@endforeach
</article>
</div>
@endsection