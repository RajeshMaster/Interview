{{ HTML::style(asset('public/css/settinglayout.css')) }}
<style>
	.highlight { background-color: #428eab !important; }
	#dwnArrow,#upArrow {
	text-decoration:none;
	font-size:22px;
	color:#bbb5b5;
	box-shadow: none;
	background-color: Transparent;
	border: none; 
	padding: 0px;
  }
  @media all and (max-width: 1200px) {
  .messagedisplay{
	font-size: 80%;
	margin-top:3%!important;
	margin-bottom:-6%!important;
	margin-left:11%!important;
  }
  .designchange{
	margin-right:4%!important;
  }
}
</style>

<script type="text/javascript">
	$(document).ready(function() {

		$("#data tr").click(function() {
			var selected = $(this).hasClass("highlight");
			$("#data tr").removeClass("highlight");
			if(!selected)
			$(this).addClass("highlight");
		});
		$("#staffsearch").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#search tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
		$("#staffsearch").on("focus", function() {
			var value = $(this).val().toLowerCase();
			$("#search tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
		$('.selectskill').on('click', function() {
			var jplevel = $('#japaneselevel').val();
			if(jplevel==""){
				$("#empty_textbox1").removeClass("display_none");
				return false;
			}else{
				$("#empty_textbox1").addClass("display_none");
			}	
			$('#hidskillId').val("");
			if ($("[name='incharge[]']:checked").length <= 0){
				alert("Please Select Programming Language");
				return false;
			}else{
				$("#hidcheck").val('1');
				var getchecked = $("#hidcheck").val();
				$("[name='incharge[]']:checked").each(function(){
					var res = $(this).val();
					if (getchecked == 1) {
						getchecked = 2;
						$('#hidskillId').val($('#hidskillId').val() + res);
					}else{
						$('#hidskillId').val($('#hidskillId').val() + "," + res);
					}
				});
				pageload();
    			$("#skillAddfrm").submit();
			}
		});
		check();
	});

	function check(){
		var edit= $('#editFlg').val();
		if(edit==1){
			var sklist= $('#skillList').val();
			var strarray = sklist.split(',');
			for (var i = 0; i < strarray.length; i++) {
				jQuery("."+strarray[i]).prop("checked", true);
			}
		}
		
	}
// Single Click in tr
function fnSclkTrInc(grpid,grpname) {
	if ($('.' + grpid).is(':checked')) {
		$("."+grpid).prop("checked", false);
	} else {
		$("."+grpid).prop("checked", true);
	}
}
	
</script>
{{ Form::open(array('name'=>'skillAddfrm',
		'id'=>'skillAddfrm',
		'url' => 'MailSend/skillAddEditProcess?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
		'method' => 'POST')) }}
{{ Form::hidden('mainmenu', $request->mainmenu, array('id' => 'mainmenu')) }}
{{ Form::hidden('empId', $request->empId, array('id' => 'empId')) }}
{{ Form::hidden('hidcheck', null, array('id' => 'hidcheck')) }}
{{ Form::hidden('hidskillId', null, array('id' => 'hidskillId')) }}
{{ Form::hidden('editFlg', $editFlg, array('id' => 'editFlg')) }}
@if($editFlg == "1")
	{{ Form::hidden('skillList', $empSkill[0]->programming_lang, array('id' => 'skillList')) }}
@else
	{{ Form::hidden('skillList', '', array('id' => 'skillList')) }}
@endif

<div class="popupstyle popupsize">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" style="color: red;" aria-hidden="true">&#10006;</button>
			<h3 class="modal-title custom_align"><B>{{ trans('messages.lbl_customerNameSel') }}</B></h3>
		</div>
		<div>
			<div style="display: inline-block;float: right;margin-top: 5px;">
				{!! Form::text('staffsearch', $request->staffsearch, array('','class'=>' form-control box85per pull-left','style'=>'height:30px;','id'=>'staffsearch','placeholder'=>'Search')) !!}
			</div>
		</div>

		{{--*/ $overflow = 'overflow-y: scroll;' /*--}}
		{{--*/ $tableWidth = 'width:99.5%;' /*--}}
		{{--*/ $height = 'height:235px;' /*--}}
		
		<div class="mt10" style="<?php echo $overflow;?>;<?php echo $height;?>;<?php echo $tableWidth;?>">
			<table id="data" class="tablealter  table-bordered table-striped mt10" width="99.95%" style="table-layout: fixed;">
				<colgroup>
					<col width="6%">
					<col width="8%">
					<col width="">
				</colgroup>
				<thead class="CMN_tbltheadcolor" >
					<th class="tac">{{ trans('messages.lbl_sno') }}</th>
					<th class="tac"></th>
					<th class="tac">{{ trans('messages.lbl_PLTypeNM') }}</th>
				</thead>
				<tbody id="search" class="staff">
					<?php $i=0; ?>
					@forelse($pgDetails as $key => $groupvalue)
						<tr class="h25" onclick="fnSclkTrInc('<?php echo $groupvalue->id; ?>','<?php echo $groupvalue->ProgramLangTypeNM; ?>');">
							<td class="tac"  >
								{{ ++$key }}
							</td>
							<td class="tac">
							<input type="checkbox" name="incharge[]" id="incharge[]"
							class="<?php echo $groupvalue->id; ?>" 
								value="<?php  echo $groupvalue->id; ?>"
								onclick="fnSclkTrInc('<?php echo $groupvalue->id; ?>','<?php echo $groupvalue->ProgramLangTypeNM; ?>');">
							</td>
							<td class="pl5 tal">
								@if($groupvalue->ProgramLangTypeNM  != "")
								 {{ $groupvalue->ProgramLangTypeNM }}
								@endif
							</td>
						</tr>
					<?php $i++; ?>
					@empty
						<tr>
							<td class="text-center" colspan="3" style="color: red;">
							{{ trans('messages.lbl_nodatafound') }}</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		<fieldset class="h50 mr7 ml7">
					<div class="dispinline col-md-12 mt10 mb5 ml50">
						<div class="pull-left text-right clr_blue fwb mt5 labeltext ml40">
							{{ trans('messages.lbl_japanese_skills') }}
							<span style="color:red;"> * 
							</span>
						</div>
						<div class="dispinline ml15 mb5 pull-left box30per">
							{{ Form::select('japaneselevel',[null=>'Please select'] + $getJapaneseLevel,(isset($empSkill[0]->japanese_skill)) ? $empSkill[0]->japanese_skill : '',array('class'=>'ime_mode_disable txt dispinline form-control firstname regdes p-region-id',
								'style'=> 'width:200px;','id' =>'japaneselevel','data-label' => trans('messages.lbl_japanese_skills'),'name' => 'japaneselevel')) }}
						</div>
						<label id="empty_textbox1" class="display_none mt6 change">
							This Field is required.
						</label>
						<label id="existsChk_textbox1" class="registernamecolor display_none mt6 change">
							This Value is already exists.
						</label>
					</div>  
				</fieldset>
	<div class="modal-footer bg-info mt10">
	  <center>
	  	@if($editFlg == "1")
	  	 <button  type="button" id="add" class="btn btn-warning CMN_display_block box100 selectskill">
			<i class="fa fa-edit" aria-hidden="true"></i>
			   {{ trans('messages.lbl_update') }}
		 </button>
	  	@else
	  	 <button  type="button" id="add" class="btn btn-success CMN_display_block box100 selectskill">
			<i class="fa fa-plus" aria-hidden="true"></i>
			   {{ trans('messages.lbl_register') }}
		 </button>
	  	@endif
		 <button data-dismiss="modal" class="btn btn-danger CMN_display_block box100">
			<i class="fa fa-times" aria-hidden="true"></i>
			   {{ trans('messages.lbl_cancel') }}
		 </button>
	  </center>
	</div>
</div>

   </div>
   {{ Form::close() }}
   </div>
   <script>
	$('.footable').footable({
	  calculateWidthOverride: function() {
		return { width: $(window).width() };
	  }
	}); 
  </script>