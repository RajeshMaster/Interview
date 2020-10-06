@extends('layouts.app')
@section('content')
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
</script>
<div class="" id="main_contents">
	<article id="customer" class="DEC_flex_wrapper" data-category="customer cus_sub_1">
		@if(!empty($getdetails))
        {{ Form::model($getdetails,array('name'=>'frmcustaddedit','method' => 'POST',
                                         'class'=>'form-horizontal h-adr',
                                         'id'=>'frmcustaddedit', 
                                         'url' => 'Customer/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'))) }}
            {{ Form::hidden('editid', $request->editid, array('id' => 'editid')) }}
            {{ Form::hidden('viewid', $request->editid, array('id' => 'viewid')) }}
            {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
            {{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }}
            {{ Form::hidden('id', $request->id , array('id' => 'id')) }}
            {{ Form::hidden('custid',$request->custid,array('id' => 'custid')) }}
            {{ Form::hidden('hid_branch_id','', array('id' => 'hid_branch_id')) }}
            {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
    	@else
        {{ Form::open(array('name'=>'frmcustaddedit', 'id'=>'frmcustaddedit', 
                            'class' => 'form-horizontal h-adr',
                            'files'=>true,
                            'url' => 'Customer/addeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
                            'method' => 'POST')) }}
        {{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
        {{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
        {{ Form::hidden('editid','', array('id' => 'editid')) }}
        {{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }}
        {{ Form::hidden('id', $request->id , array('id' => 'id')) }}
        {{ Form::hidden('custid',$request->custid,array('id' => 'custid')) }}
        {{ Form::hidden('hid_branch_id','', array('id' => 'hid_branch_id')) }}
    	@endif     
    	<fieldset class="mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/Client.png')  }}">
				<h2 class="pull-left h2cnt">{{trans('messages.lbl_customer')}}</h2>
				<h2 class="pull-left h2cnt">&#9642;</h2>
				@if ($request->flg!="")
					<h2 class="pull-left mt10 red">{{ trans('messages.lbl_edit') }}</h2>
				@else
					<h2 class="pull-left mt10 green">{{ trans('messages.lbl_register') }}</h2>
				@endif
			</div>
		</fieldset>
	</article>
</div>
@endsection