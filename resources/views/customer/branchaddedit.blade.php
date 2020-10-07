@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/lib/bootstrap-datepicker.min.js')) }}
{{ HTML::style(asset('public/css/lib/bootstrap-datetimepicker.min.css')) }}
{{ HTML::script(asset('public/js/customer.js')) }}
{{ HTML::script(asset('public/js/yubinbango.js')) }}
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
	$(document).ready(function() {
    	setDatePicker("txt_custagreement");
  	});
</script>
<div class="" id="main_contents">
	<article id="customer" class="DEC_flex_wrapper" data-category="customer cus_sub_1">
		@if(!empty($bdetails))
	        {{ Form::model($bdetails,array('name'=>'frmbranchaddedit','method' => 'POST',
	                                         'class'=>'form-horizontal h-adr',
	                                         'id'=>'frmbranchaddedit', 
	                                         'url' => 'Customer/Branchaddeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'))) }}
	            {{ Form::hidden('editid', $request->editid, array('id' => 'editid')) }}
	            {{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }}
	            {{ Form::hidden('id', $request->id , array('id' => 'id')) }}
	            {{ Form::hidden('custid',$request->custid,array('id' => 'custid')) }}
    	@else
	        {{ Form::open(array('name'=>'frmbranchaddedit', 'id'=>'frmbranchaddedit', 
	                            'class' => 'form-horizontal h-adr',
	                            'files'=>true,
	                            'url' => 'Customer/Branchaddeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
	                            'method' => 'POST')) }}
	                {{ Form::hidden('custid',$request->custid, array('id' => 'custid')) }}
	                {{ Form::hidden('id',$request->id, array('id' => 'id')) }} 
	                {{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }} 
	                {{ Form::hidden('editid', '', array('id' => 'editid')) }} 
    	@endif
    	<fieldset class="mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/Client.png')  }}">
				<h2 class="pull-left h2cnt">{{trans('messages.lbl_branch')}}</h2>
				<h2 class="pull-left h2cnt">&#9642;</h2>
				@if ($request->flg!=1)
					<h2 class="pull-left mt10 green">{{ trans('messages.lbl_register') }}</h2>
				@else
					<h2 class="pull-left mt10 red">{{ trans('messages.lbl_edit') }}</h2>
				@endif
			</div>
		</fieldset>
		<fieldset class="mt10 pull-left dispMainMobile">
			
		</fieldset>                       
	</article>
</div>
@endsection