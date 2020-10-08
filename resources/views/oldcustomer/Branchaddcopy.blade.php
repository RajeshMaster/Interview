@extends('layouts.app')
@section('content')

{{ HTML::script('resources/assets/js/oldcustomer.js') }}
{{ HTML::script('resources/assets/js/yubinbango.js') }}


<script type="text/javascript">

	var datetime = '<?php echo date('Ymdhis'); ?>';

	var mainmenu = '<?php echo $request->mainmenu; ?>';

</script>

	<div class="CMN_display_block"  id="main_contents">

	<article id="customer" class="DEC_flex_wrapper " data-category="customer customer_sub_2">


        {{ Form::open(array('name'=>'frmbranchaddcopy', 'id'=>'frmbranchaddcopy', 
                            'class' => 'form-horizontal h-adr',
                            'files'=>true,
                            'url' => 'OldCustomer/copyBranchProcess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
                            'method' => 'POST')) }}

            {{ Form::hidden('custid',$request->custid, array('id' => 'custid')) }}
            {{ Form::hidden('id',$request->id, array('id' => 'id')) }} 
            {{ Form::hidden('flg', $request->flg , array('id' => 'flg')) }} 
            {{ Form::hidden('editid', '', array('id' => 'editid')) }} 

            {{ Form::hidden('selctedIncharge','' , array('id' => 'selctedIncharge')) }}
            {{ Form::hidden('selctedInchargeNumber','' , array('id' => 'selctedInchargeNumber')) }}


	<!-- Start Heading -->
	<div class="row hline">
		<div class="col-xs-8 pl10 mt10">
			<img class="pull-left box35 mt5" src="{{ URL::asset('resources/assets/images/Client.png') }}">
			<h2 class="pull-left pl5 mt10">{{ trans('messages.lbl_branch') }}</h2>
            <h2 class="pull-left mt10">・</h2>
            <h2 class="pull-left mt10 green">{{ trans('messages.lbl_register') }}</h2>
		</div>
	</div>
    <div id="errorSectiondisplay" align="center" class="box100per"></div>
	<!-- End Heading -->
    <div class="pl5 pr5" style="margin-top: -10px;">
    <fieldset class="col-xs-12">
   
    <div class="col-xs-12 mt5">
        <div class="col-xs-3 text-right clr_blue ml6">
             <label>
                {{ trans('messages.lbl_branchname') }}<span class="fr ml2 red"> * </span></label>
        </div>
        <div class="col-xs-3">
                {{ Form::text('txt_branch_name',(isset($getbranchDetails[0]->branch_name)) ? $getbranchDetails[0]->branch_name : '',array(
                                    'id'=>'txt_branch_name',
                                    'name' => 'txt_branch_name',
                                    'class'=>'box85per form-control',
                                    'data-label' => trans('messages.lbl_branch_name'))) }}
        </div>
        <div class="col-xs-2 text-right clr_blue ml6">
            <label>
             {{ trans('messages.lbl_inchargename') }}<span class="fr ml2 red"> * </span></label>
        </div>
        <div class="col-xs-3" style="width: 350px;">
            <input type="hidden" id="inchargeValue" name="inchargeValue" value="" />
             {{ Form::text('txt_incharge_name','',array(
                            'id'=>'txt_incharge_name',
                            'name' => 'txt_incharge_name',
                            'class'=>'box65per form-control',
                            'data-label' => trans('messages.lbl_inchargename'))) }}
                <button data-toggle="modal" type="button" class="btn btn-success add" 
                    style="height:30px;width: 50px;;font-size: 12px;" onclick="return oldInchargeSelect();">
                    <span>{{ trans('messages.lbl_select') }}</span> 
               </button>
                <a onclick="javascript:cleartxt();" style="height:30px;width: 50px;;font-size: 12px;" 
                    class="btn btn-danger box47 white">
                      <span>{{ trans('messages.lbl_clear') }}</span>  
                </a>
        </div>
    </div>

     <div class="col-xs-12 mt5">
        <div class="col-xs-3 text-right clr_blue ml6">
            <label>
                {{ trans('messages.lbl_mobilenumber') }}<span class="fr ml2 red"> * </span></label>
        </div>
        <div class="col-xs-3">
            {{ Form::text('txt_mobilenumber',(isset($getbranchDetails[0]->branch_contact_no)) ? $getbranchDetails[0]->branch_contact_no : '',array(
                                'id'=>'txt_mobilenumber',
                                'name' => 'txt_mobilenumber',
                                'class'=>'box85per form-control',
                                'style'=>'ime-mode: disabled;',
                                'maxlength' => 13,
                                'data-label' => trans('messages.lbl_mobilenumber'),
                                'onkeypress' => 'return isNumberKeywithminus(event)')) }}
        </div>
        <div class="col-xs-2 text-right clr_blue ml6">
            <label>
            {{ trans('messages.lbl_incharge_mail') }}<span class="fr ml2 red"> * </span></label>
        </div>
        <div class="col-xs-3">
            {{ Form::text('txt_mailid','',array(
                                'id'=>'txt_mailid',
                                'name' => 'txt_mailid',
                                'class'=>'box85per form-control',
                                'style'=>'ime-mode: disabled;',
                                'data-label' => trans('messages.lbl_incharge_mail'))) }}
        </div>
    </div>
    <div class="col-xs-12 mt5">
        <div class="col-xs-3 text-right clr_blue ml6">
            <label>
                {{ trans('messages.lbl_fax') }}<span class="fr ml2 red"> * </span></label>
        </div>
        <div class="col-xs-3">
                {{ Form::text('txt_fax',(isset($getbranchDetails[0]->branch_fax_no)) ? $getbranchDetails[0]->branch_fax_no : '',array(
                                    'id'=>'txt_fax',
                                    'name' => 'txt_fax',
                                    'class'=>'box85per form-control',
                                    'maxlength' => 13,
                                    'style'=>'ime-mode: disabled;',
                                    'data-label' => trans('messages.lbl_fax'),
                                    'onkeypress' => 'return isNumberKeywithminus(event)')) }}
        </div>
    </div>
     <div class="col-xs-12 mt5">
        <span class="p-country-name" style="display:none;">Japan</span>
        
        <div class="col-xs-3 text-right clr_blue ml6">
            <label>
                {{ trans('messages.lbl_postalCode') }}<span class="fr ml2 red"> * </span></label>
        </div>
        <div class="col-xs-3">
            {{ Form::text('txt_postal',(isset($getbranchDetails[0]->postalNumber)) ? $getbranchDetails[0]->postalNumber : '',array(
                                    'id'=>'txt_postal',
                                    'name' => 'txt_postal',
                                    'class'=>'box38per form-control p-postal-code',
                                    'maxlength' => '8',
                                    'style'=>'ime-mode: disabled;',
                                    'data-label' => trans('messages.lbl_fax'),
                                    'onkeyup' => 'addHyphen(this)',
                                    'onkeypress' => 'return isNumberKeywithminus(event)')) }}
           <!--  <a onclick="javascript:fromPostlcode();" class="btn btn-info  box145 white">
            {{ trans('messages.lbl_frompostnumber') }}</a> -->
        </div>
    </div>
     <div class="col-xs-12 mt5">
        <div class="col-xs-3 text-right clr_blue ml6">
            <label>
                {{ trans('messages.lbl_kenmei') }}<span class="fr ml2 red"> * </span></label>
        </div>
        <div class="col-xs-3">
                {{ Form::select('kenmei',[null=>'Please select'] + $getKenname,(isset($getbranchDetails[0]->kenmei)) ? $getbranchDetails[0]->kenmei : '',array('class' => 'box60per form-control p-region-id','id' =>'kenmei','data-label' => trans('messages.lbl_kenmei'),'name' => 'kenmei')) }}
        </div>
    </div>
     <div class="col-xs-12 mt5">
        <div class="col-xs-3 text-right clr_blue ml6">
            <label>
                {{ trans('messages.lbl_shimei') }}<span class="fr ml2 red"> * </span></label>
        </div>
        <div class="col-xs-3">
                {{ Form::text('txt_shimei',(isset($getbranchDetails[0]->shimei)) ? $getbranchDetails[0]->shimei : '',array(
                                    'id'=>'txt_shimei',
                                    'name' => 'txt_shimei',
                                    'class'=>'box85per form-control p-locality',
                                    'maxlength' => 13,
                                    'style'=>'ime-mode: disabled;',
                                    'data-label' => trans('messages.lbl_shimei'))) }}
        </div>
    </div>
     <div class="col-xs-12 mt5">
        <div class="col-xs-3 text-right clr_blue ml6">
            <label>
                {{ trans('messages.lbl_streetaddress') }}<span class="fr ml2 red"> * </span></label>
        </div>
        <div class="col-xs-3">
                {{ Form::text('txt_streetaddress',(isset($getbranchDetails[0]->street_address)) ? $getbranchDetails[0]->street_address : '',array(
                                    'id'=>'txt_streetaddress',
                                    'name' => 'txt_streetaddress',
                                    'class'=>'box85per form-control p-street-address p-street-address',
                                    'maxlength' => 13,
                                    'style'=>'ime-mode: disabled;',
                                    'data-label' => trans('messages.lbl_streetaddress'))) }}
        </div>
    </div>
     <div class="col-xs-12 mt5">
        <div class="col-xs-3 text-right clr_blue ml6">
            <label>
                {{ trans('messages.lbl_buildingname') }}<span class="fr ml2 red" style="visibility: hidden"> * </span></label>
        </div>
        <div class="col-xs-3">
                {{ Form::text('txt_buildingname',(isset($getbranchDetails[0]->buildingname)) ? $getbranchDetails[0]->buildingname : '',array(
                                    'id'=>'txt_buildingname',
                                    'name' => 'txt_buildingname',
                                    'class'=>'box85per form-control',
                                    'maxlength' => 13,
                                    'style'=>'ime-mode: disabled;',
                                    'data-label' => trans('messages.lbl_buildingname'))) }}
        </div>
    </div>
    <div class="col-xs-12 mt5 pb15">
        <div class="col-xs-3 text-right clr_blue ml6">
            <label>
                {{ trans('messages.lbl_remarks') }}<span class="fr ml2 red" style="visibility: hidden"> * </span></label>
        </div>
        <div class="col-xs-3">
                {{ Form::textarea('txt_address',(isset($getbranchDetails[0]->branch_address)) ? $getbranchDetails[0]->branch_address : '',array(
                                    'id'=>'txt_address',
                                    'name' => 'txt_address',
                                    'class'=>'box85per',
                                    'style' => 'height :70px;',
                                    'name' => 'txt_address',
                                    'data-label' => trans('messages.lbl_address'))) }}
        </div>
    </div>
        <div class="CMN_display_block pb15"></div>
</fieldset>
        <fieldset class = "col-xs-12" style="background-color: #DDF1FA;" >
            <div class="form-group">
                <div align="center" class="mt5">
                   @if($request->flg ==1)
                    <button type="submit" class="btn edit btn-warning box100 Branchaddedcopy" >
                        <i class="fa fa-edit" aria-hidden="true"></i> {{ trans('messages.lbl_update') }}
                    </button>
                    <a onclick="javascript:gotoinpage('{{ $request->mainmenu }}',{{ date('YmdHis') }});" class="btn btn-danger box120 white"><i class="fa fa-times" aria-hidden="true"></i> {{ trans('messages.lbl_cancel') }} 
                        </a>
                    @else
                        <button type="submit" class="btn btn-success add box100 Branchaddedcopy ml5">
                            <i class="fa fa-plus" aria-hidden="true"></i> {{ trans('messages.lbl_register') }}
                        </button>
                        <a onclick="javascript:gotoinpage('{{ $request->mainmenu }}',{{ date('YmdHis') }});" class="btn btn-danger box120 white"><i class="fa fa-times" aria-hidden="true"></i> {{ trans('messages.lbl_cancel') }} 
                        </a>
                    @endif  
                </div>
            </div>
        </fieldset>
        </div>
    </article>
    </div>
    {{ Form::close() }}

    {{ Form::open(array('name'=>'frmbranchaddcopycancel', 'id'=>'frmbranchaddcopycancel', 'url' => 'Customer/Branchaddeditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,'method' => 'POST')) }}

            {{ Form::hidden('custid',Session::get('customerIdSel'), array('id' => 'custid')) }}

            {{ Form::hidden('id', Session::get('customerMax'), array('id' => 'id')) }} 

    {{ Form::close() }}

    <div id="inchargeSelect" class="modal fade">
      <div id="login-overlay">
        <div class="modal-content">
        <!-- Popup will be loaded here -->
        </div>
      </div>
    </div>

    @endsection