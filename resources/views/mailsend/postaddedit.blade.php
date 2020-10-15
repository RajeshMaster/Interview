@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/addeditlayout.css')) }}
{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::script(asset('public/js/lib/bootstrap-datepicker.min.js')) }}
{{ HTML::style(asset('public/css/lib/bootstrap-datetimepicker.min.css')) }}
{{ HTML::style(asset('public/css/lib/jquery.ui.autocomplete.css')) }}
{{ HTML::script(asset('public/js/lib/jquery-ui.min.js')) }}
{{ HTML::script(asset('public/js/sendmail.js')) }}

<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	var mainmenu = '<?php echo $request->mainmenu; ?>';
	
</script>
<style type="text/css">
	
</style>
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="mail" class="DEC_flex_wrapper" data-category="employee emp_sub_4">
	<fieldset class="mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/employee.png')  }}">
			<h2 class="pull-left h2cnt">{{trans('messages.lbl_sendMail')}}</h2>
		</div>
	</fieldset>

		{{ Form::open(array('name'=>'senmailfrm',
							'id'=>'senmailfrm',
							'class'=>'focusFields',
							'method' => 'POST',
						'url' => 'MailSend/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
							'files'=>true)) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('editid', $request->editid, array('id' => 'editid')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('selectedEmployee', $request->selSendMail , array('id' => 'selectedEmployee')) }}
		{{ Form::hidden('selectedEmployeeResume', $resuemPdf , array('id' => 'selectedEmployeeResume')) }}
		{{ Form::hidden('selectedType', '' , array('id' => 'selectedType')) }}

	<fieldset id="hdnfield" class="mt10">
		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label>{{ trans('messages.lbl_empid') }}<span class="fr red">&nbsp;&nbsp;</span></label>
			</div>
			<div class="col-xs-7 mw">
				<span  class="CMN_display_block box33per ml2 brown">
					{{ $SelectedEmpid }}
				</span>
			</div>
		</div>

		<div class="col-xs-12 ">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_empName')}}<span class="fr">&nbsp;&nbsp;</span></label>
			</div>
			<div class="col-xs-7 mw">
				<span  class="CMN_display_block box33per blue ml2">
					{{ $selectedEmpName }}
				</span>
			</div>
		</div>

		<div class="col-xs-12 ">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_pdffile')}}<span class="fr">&nbsp;&nbsp;</span></label>
			</div>
			<div class="col-xs-7 mw">
				<span  class="ml2" style="word-wrap: break-word">
					<?php $attachments = explode(",", $resuemPdf); ?>
					<?php $selectedEmpNamearr = explode(",", $selectedEmpName); ?>
					<?php for ($i=0; $i < count($attachments); $i++) { ?>
						@if(isset($selectedEmpNamearr[$i]))
							{{ $selectedEmpNamearr[$i] }} 
 						@endif
						{{--*/ $src = $noimage . '/pdf.png'; /*--}}
						&nbsp;&nbsp;
						<a class="csrp" onclick="pdfview('{{  $attachments[$i] }}');">
							<img class="box30 mr5  ml20" src="{{ $src }}" width="30" height = "30"></img>
						</a>
						<br/>
					<?php } ?>
				</span>
			</div>
		</div>

		@if($url != "")
			<div class="col-xs-12 ">
				<div class="col-xs-3 lb tar" >
					<label for="name">{{ trans('messages.lbl_pdffile')}}<span class="fr">&nbsp;&nbsp;</span></label>
				</div>
				<div class="col-xs-7 mw">
					<span  class="CMN_display_block box38per ml2" style="word-wrap: break-word">
						<?php $url = explode(",", $url); ?>
						<?php for ($i=0; $i < count($url); $i++) { ?>
							<a class="csrp" onclick="pdfview('{{  $url[$i] }}');">
								{{ $url[$i] }}
							</a>	
							<br/>
						<?php } ?>
					</span>
				</div>
			</div>
		@endif

		<div class="col-xs-12 mt8">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_CC')}}<span class="fr">&nbsp;&nbsp;</span></label>
			</div>
			<div class="col-xs-7 mw">
				<span class="CMN_display_block box34per "> 

					{{ Form::text('ccemail','',array('id'=>'ccemail', 
							'name' => 'ccemail',
							'data-label' => trans('messages.lbl_CC'),
							'class'=>'box100per form-control ',
							'maxlength'=>'30')) }}
				</span>
			</div>
		</div>

		<div class="col-xs-12 mt8">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_select_Type')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw">
				<span class="CMN_display_block  "> 
	            	<label style="font-weight: normal;">
						{{ Form::radio('type', '1','', 
									array('id' =>'type1',
										  'name' => 'type',
										  'class' => 'comp',
										  'style' => 'margin:-2px 0 0 !important',
										  'onclick' => 'javascript:return slectType("1");',
										  'data-label' => trans('messages.lbl_select_Type'))) }}
						<span class="vat">&nbsp;{{ trans('messages.lbl_group') }}&nbsp;</span>
					</label>
					<label style="font-weight: normal;">
						{{ Form::radio('type', '2','', 
									array('id' =>'type2',
										  'name' => 'type',
										  'class' => 'ntcomp',
										  'style' => 'margin:-2px 0 0 !important',
										  'onclick' => 'javascript:return slectType("2");',
										  'data-label' => trans('messages.lbl_select_Type'))) }}
						<span class="vat">&nbsp;{{ trans('messages.lbl_custname') }}&nbsp;</span>
					</label>
					<span style="display: none;color: #9C0000" id="rdoreq"> Required</span>
				</span>
			</div>
		</div>

		<div class="col-xs-12 mt4 grpdiv" style="display: none;" >
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_group')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>

			<div class="col-xs-7 mw">
				<input type="hidden" id="groupvalue" name="groupvalue" value="" />
					{{ Form::text('groupname','',array('id'=>'groupname', 
						'name' => 'groupname',
						'data-label' => trans('messages.lbl_group'),
						'class'=>'form-control box50per dispinline mlength ',
						'onkeypress' => 'event.preventDefault();',
						'readonly' => 'true',
						'maxlength'=>'30')) }}
				<div id="customerdiv" class="CMN_display_block box20per ml1">
					<button data-toggle="modal" type="button" class="btn btn-success add box70per"
						style="height:30px;width: 140px; margin-top: -3px;" 
						onclick="return groupSelect();">
						<i class="fa fa-plus vat">  {{ trans('messages.lbl_group') }}</i>
					</button>
				</div>
			</div>
		</div>

		<div class="col-xs-12 mt4 cstdiv" style="display: none">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_cusname')}}<span class="fr" id="customernamerequired">&nbsp;&#42;</span></label>
			</div>

			<div class="col-xs-7 mw">
				<input type="hidden" name="customerid" id="customerid" value=""/>
				{{ Form::text('customerName','',array('id'=>'customerName', 
													'name' => 'customerName',
													'data-label' => trans('Sur Name'),
													'readonly' => 'true',
													'class'=>'form-control box50per dispinline mlength customerName')) }}
				{{ Form::hidden('customerId', "" , array('id' => 'customerId')) }}
				<button data-toggle="modal" type="button" class="btn btn-success add" 
					style="width: 100px;height: 30px;margin-top: 5px;" 
					 onclick="return customerSelectPopup();">
					 <i class="fa fa-plus vat">{{ trans('messages.lbl_browse') }}</i>
				</button>
				<a class="btn btn-danger box67 p4" href="javascript:fncusclear();"
							style="height:30px;width: 70px; margin-top: 5px;" >{{ trans('messages.lbl_clear') }}</a>
				<div class="customerName_err dispinline"></div>
			</div>
		</div>

		<div class="col-xs-12 mt5 bradiv" style="display: none">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_branchName')}}<span class="fr" id="branchnamerequired">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
				{{ Form::select('branchId',[null=>''],'', 
					array('name' => 'branchId',
					'id'=>'branchId',
					'onchange'=>'fnGetinchargeDetails();',
					'data-label' => trans('messages.lbl_branchname'),
					'class'=>'form-control  mlength',
					'style'=>'width :50% !important;display :inline')) }}
				<div class="Name_err dispinline"></div>
			</div>
		</div>

		<div class="col-xs-12 mt7 incdiv" style="display: none">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_inchargename')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">

				{{ Form::text('inchargeDetails','', 
								array('name' => 'inchargeDetails',
									  'id'=>'inchargeDetails',
									  'data-label' => trans('messages.lbl_inchargename'),
									  'class'=>'form-control pl5mlength','readonly' => 'readonly',
									  'style'=>'width :50% !important;display :inline')) }}
		
					<button data-toggle="modal" type="button" class="btn btn-success incadd" 
					style="width: 100px;height: 30px;margin-top: 5px;display: none" 
					 onclick="return inchargename();">
					 <i class="fa fa-plus vat">{{ trans('messages.lbl_browse') }}</i>
					</button>
					<a class="btn btn-danger box67 p4 btnclr" href="javascript:fninchclear();"
							style="height:30px;width: 70px; margin-top: 5px;display: none" >{{ trans('messages.lbl_clear') }}</a>
				
				<div class="customerName_err dispinline"></div>
				<div class="inchargeDetails_err dispinline"></div>
				<input type="hidden" name="hidincharge" id="hidincharge">
				<input type="hidden" name="hidcheck" id="hidcheck">
			</div>
		</div>

		<div class="col-xs-12 mt7 incmaildiv" style="display: none">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_to_mail')}}<span class="fr">&nbsp;&nbsp;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">

				{{ Form::text('inchargemailDetails','', 
								array('name' => 'inchargemailDetails',
									  'id'=>'inchargemailDetails',
									  'data-label' => trans('messages.lbl_inchargename'),
									  'class'=>'form-control pl5mlength','readonly' => 'readonly',
									  'style'=>'width :50% !important;display :inline')) }}
				
				<input type="hidden" name="hidinchargemail" id="hidinchargemail">
			</div>
		</div>

		<div class="col-xs-12 mt6">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_subject')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw">
					{{ Form::text('subject','',array('id'=>'subject', 
							'name' => 'subject',
							'data-label' => trans('messages.lbl_subject'),
							'class'=>'box100per form-control pl5 mlength',
							'maxlength'=>'30',
							'style'=>'width :50% !important;display :inline')) }}
				<div class="tsubject_err dispinline"></div>
		</div>

		<!-- <div class="col-xs-12 ">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_passwordencryption')}}<span class="fr">&nbsp;&nbsp;</span></label>
			</div>
			<div class="col-xs-7 mw">
				<span class="CMN_display_block box34per ml2"> 
                  	{{ Form::checkbox('chk_passwordencryption', '1')  }}        
				</span>
			</div>
		</div> -->

		<div class="col-xs-12 mt10">
			<div class="col-xs-3 lb tar" >
				<label for="name">{{ trans('messages.lbl_content')}}<span class="fr">&nbsp;&#42;</span></label>
			</div>
			<div class="col-xs-7 mw" style="">
			
				{{ Form::textarea('txt_content',"",array('id'=>'txt_content',
												'name' => 'txt_content',
												'data-label' => trans('messages.lbl_txt_content'),
												'class' => 'mlength ntcomp dispinline form-control ime_mode_disable txt_content',
												'style' => 'height:130px; width :50%')) }}
				<div class="txt_content_err dispinline"></div>
			</div>
		</div>

	</fieldset> 
	<fieldset class="mt10 mb10">
		<div class="col-xs-12 mb10 mt10">
			<div class="col-xs-12 buttondes" style="text-align: center;">
				@if($request->editflg != "edit")
					<button type="button" class="button button-green sendmailRegister">
						<i class="fa fa-plus"></i>&nbsp;{{ trans('messages.lbl_register')}}
					</button>
					&emsp;
				@else
					<button type="button" class="button button-orange sendmailRegister">
						<i class="fa fa-edit"></i>&nbsp;{{ trans('messages.lbl_update') }}
					</button>
					&emsp;
				@endif
				<a href="javascript:fnbackmailindex();" class="button button-red textDecNone">
					<span class="fa fa-remove"></span> {{ trans('messages.lbl_cancel') }}
				</a>
			</div>
		</div>
	</fieldset>
	{{ Form::close() }}

	{{ Form::open(array('name'=>'frmaddeditcancel', 'id'=>'frmaddeditcancel', 'url' => 'Employee/view?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),'files'=>true,'method' => 'POST')) }}
		{{ Form::hidden('empid', $request->empid , array('id' => 'empid')) }}
		{{ Form::hidden('editid', $request->editid, array('id' => 'editid')) }}
	{{ Form::close() }}
	
	{{ Form::open(array('name'=>'frmurlview',
							'id'=>'frmurlview',
							'url' => 'MailSend/pdfViewProcess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'),
							'files'=>true,
							'target'=>'_blank',
							'method' => 'POST')) }}
		{{ Form::hidden('filename', '' , array('id' => 'filename')) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('empid', $request->empid , array('id' => 'empid')) }}
	{{ Form::close() }}
	
	<script type="text/javascript">
		var cancel_check = true;
		$('input, select, textarea').bind("change keyup paste", function() {
			cancel_check = false;
		});
	</script>
</article>
</div>

<div id="customerSelect" class="modal fade" style="width: 775px;">
	<div id="login-overlay">
		<div class="modal-content">
		<!-- Popup will be loaded here -->
		</div>
	</div>
</div>
@endsection