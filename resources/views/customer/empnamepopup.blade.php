{{ HTML::script(asset('public/js/setting.js')) }}
{{ HTML::script(asset('public/js/common.js')) }}
{{ HTML::script(asset('public/js/customer.js')) }}
{{ HTML::style(asset('public/css/settinglayout.css')) }}
{{ HTML::script(asset('public/js/lib/bootstrap-datepicker.min.js')) }}
{{ HTML::style(asset('public/css/lib/bootstrap-datetimepicker.min.css')) }}
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
	$(document).ready(function() {
    	setDatePicker("txt_start_date");
    	setDatePicker("txt_end_date");
  	});
</script>
<style type="text/css">
	/*Start Mobile layout*/
	@media all and (max-width: 1200px) {
		.regdes{
			width:128%!important;
		}
		.h2cnt {
			font-size: 150%!important;
			margin-top: 3%!important;
		}
		.buttondes {
			font-size: 80%!important;
		}
		.col-xs-3 {
			 width:50%;
			 font-size:80%;
			 margin-left:-10%;
		}
		.col-xs-9 {
			width:50%;
		}
		.dispMainMobile {
			width:100%;
		}
		.dispSubMobile {
			width:100%;
		}
	}
	/*End Mobile layout*/
	@media all and (min-width:1205px) {
		.dispMainMobile {
			width:50%;
		}
		.dispSubMobile {
			width:48%;
		}
		.col-xs-3 {
			width:50%;
			font-size:100%;
			margin-left:-10%;
		}
		.col-xs-9 {
			width:50%;
		}
	}
</style>
 @if(!empty($cemployeeview))
	{{ Form::model($cemployeeview,array('name'=>'frmempnameedit','method' => 'POST',
						'class'=>'form-horizontal',
						'id'=>'frmempnameedit', 
						'url' => 'Customer/EmpNamePopupAddEditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'))) }}
	{{ Form::hidden('custid',$request->custid,array('id' => 'custid')) }}
	{{ Form::hidden('id',$request->id,array('id' => 'custid')) }}
	{{ Form::hidden('empidd',$request->employeeid,array('id' => 'empidd')) }}
	{{ Form::hidden('selectionid','',array('id' => 'selectionid')) }} 
@else
	{{ Form::open(array('name'=>'frmempnameedit', 
		'id'=>'frmempnameedit', 
		'url' => 'Customer/EmpNamePopupAddEditprocess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
		'files'=>true,
		'method' => 'POST')) }}
	{{ Form::hidden('custid',$request->custid,array('id' => 'custid')) }}
@endif
	{{ Form::hidden('id',$request->id,array('id' => 'id')) }}
	{{ Form::hidden('empidd',$request->employeeid,array('id' => 'empidd')) }}
	{{ Form::hidden('selectionid','',array('id' => 'selectionid')) }}
	{{ Form::hidden('editid',$request->selectionid,array('id' => 'editid')) }}
<div class="popupstyle popupsize">
	<div class="modal-content">
		<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" style="color: red;" aria-hidden="true">&#10006;</button>
			<h3 class="modal-title custom_align"><B>{{ trans('messages.lbl_employeenameselection') }}</B></h3>
    	</div>
    	<fieldset class="box98per dispMainMobile ml5"> 
    		<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_custname(JP & Eng)') }} </label>
					<span class="fr ml2 fs7"> </span>
				</div>
				<div class="col-xs-9 mw">
						@if(isset($cusdetail[0]->customer_name))
							{{ $cusdetail[0]->customer_name}}
						@else
							{{ "NILL"}}
						@endif
				</div>
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_branchName') }} </label>
					<span class="fr ml2 fs7"> </span>
				</div>
				@if($request->selectionid !=1)
				<div class="col-xs-9 mw">
					@if(isset($cemployeeview[0]['branch_name']))
						{{ $cemployeeview[0]['branch_name']}}
					@else
						{{ "NILL"}}
					@endif
				</div>
				@else
				<div class="col-xs-9 mw">
					{{ Form::select('newbranches',[null=>'']+$bname, null,array('name' => 'newbranches','id'=>'newbranches','data-label' => trans('messages.lbl_branch_name'),'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
	                                'style' =>'width:240px;ime-mode: disabled;','onchange'=>'fnGetbranchDetail();','selected'))}}
								{{ Form::hidden('hidebranchname','', array('id' => 'hidebranchname')) }}
				</div>
				@endif
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_inchargename') }} </label>
					<span class="fr ml2 fs7"> </span>
				</div>
				@if($request->selectionid !=1)
					<div class="col-xs-9 mw">
						@if(isset($cemployeeview[0]['incharge_name']))
							{{ $cemployeeview[0]['incharge_name']}}
						@else
							{{ "NILL"}}
						@endif
					</div>
				@else
					<div class="col-xs-9 mw">
						{{ Form::select('inchargeId',[null=>''],'',array('name' => 'inchargeId',
								  'id'=>'inchargeId',
								  'data-label' => trans('messages.lbl_inchargename'),
								  'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
                               	 'style' =>'width:240px;ime-mode: disabled;')) }}
					</div>
				@endif
			</div>
			<div class="col-xs-12 mt10">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_empName') }} </label>
					<span class="fr ml2 fs7"> </span>
				</div>
				@if($request->selectionid !=1)
					<div class="col-xs-9 mw">
						<label class="fwb">
							@if(isset($empdt[0]->LastName))
								{{ $empdt[0]->LastName}}
							@else
								{{ "NILL"}}
							@endif
						</label>
						<label class="fwb ml5 colbl">
							@if(isset($empdt[0]->Emp_ID))
								{{ $empdt[0]->Emp_ID}}
							@else
								{{ "NILL"}}
							@endif 
						</label>
					</div>
				@else
					<div class="col-xs-9 mw">
						{{ Form::select('newemployeename',[null=>'']+$empname1, null,array('name' => 'newemployeename','id'=>'newemployeename','data-label' => trans('messages.lbl_empName'), 'class'=>'ime_mode_disable txt dispinline form-control firstname regdes',
                               	 'style' =>'width:240px;ime-mode: disabled;','onselect'=>'return valchange()','onchange'=>'return valchange()'))}}
						<span class="pl10 fwb" style="color: blue;" id="empno"></span>
					</div>
				@endif
			</div>
			@if($request->selectionid!=1)
				{{--*/ $style = '' /*--}}
			@else
				{{--*/ $style = 'mb15' /*--}}
			@endif
			<div class="col-xs-12 mt10 {{$style}} ">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_workStdate') }} </label>
					<span class="fr ml2 fs7"> </span>
				</div>
				<div class="col-xs-9 mw">
					{{ Form::text('txt_start_date',(isset($cemployeeview[0]['start_date'])) ? $cemployeeview[0]['start_date'] : '',array('id'=>'txt_start_date',
						'name' => 'txt_start_date',
						'class'=>'ime_mode_disable txt dispinline form-control firstname regdes txt_start_date',
                   		'style' =>'width:240px;ime-mode: disabled;',
						'data-label' => trans('messages.lbl_workStdate'),
						'onkeypress'=>'return event.charCode >=6 && event.charCode <=58',
						'autocomplete'=> 'off',
						'maxlength' => '10')) }}
					<label class="mt10 ml2 fa fa-calendar fa-lg" for="txt_start_date" aria-hidden="true"></label>
				</div>
			</div>
			@if($request->selectionid !=1)
			<div class="col-xs-12 mt10 mb15">
				<div class="col-xs-3 lb text-right pm0">
					<label class="clr_black"> {{ trans('messages.lbl_workEdate') }} </label>
					<span class="fr ml2 fs7"> </span>
				</div>
				<div class="col-xs-9 mw">
					{{ Form::text('txt_end_date',(isset($cemployeeview[0]['end_date'])) ? $cemployeeview[0]['end_date'] : '',array('id'=>'txt_end_date',
						'name' => 'txt_end_date',
						'class'=>'ime_mode_disable txt dispinline form-control firstname regdes txt_end_date',
   						'style' =>'width:240px;ime-mode: disabled;',
						'data-label' => trans('messages.lbl_workEdate'),
						'autocomplete'=> 'off',
						'onkeypress'=>'return event.charCode >=6 && event.charCode <=58','maxlength' => '10')) }}
					<label class="mt10 ml2 fa fa-calendar fa-lg" for="txt_end_date" aria-hidden="true"></label>
				</div>
			</div>
			@endif
    	</fieldset>
    	@if($request->selectionid !=1)
	    	<div class="modal-footer">
				<div class="bg-info">
					<center>
						<button  id="updatebutton" type="button" class="btn btn-warning CMN_display_block box100 mt15 mb15 empaddeditprocess" >
						<i class="fa fa-edit"></i> {{ trans('messages.lbl_update') }}</button>
						<button type="button" onclick="closefunction();" class="btn btn-danger CMN_display_block box100 button mt15 mb15" ><i class="fa fa-times" aria-hidden="true"></i> {{ trans('messages.lbl_cancel') }}</button>
					</center>
				</div>
			</div>
		@else
			<div class="modal-footer" style="border: none !important;">
				<div class="bg-info">
					<center>
						<button  id="regbutton" type="button" class="btn btn-success CMN_display_block box100 mt15 mb15 empaddeditprocess" >
						<i class="fa fa-plus"></i> {{ trans('messages.lbl_register') }}</button>
						<button type="button" onclick="closefunction();" class="btn btn-danger CMN_display_block box100 button mt15 mb15" ><i class="fa fa-times" aria-hidden="true"></i> {{ trans('messages.lbl_cancel') }}</button>
					</center>
				</div>
			</div> 
		@endif	 
	</div>
</div>
{{ Form::close() }}