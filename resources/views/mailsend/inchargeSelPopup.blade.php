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
.dis_none{
 	display: none;
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

	$('.selectinchargegroup').click(function(){
		document.getElementById("tomailSelected").value = "";
		document.getElementById("hidmailSelectedid").value = "";
		document.getElementById("inchargeDetails").value = "";
		document.getElementById("hidincharge").value = "";
		document.getElementById("inchargemailDetails").value = "";
		$('span[id^="toselmail"]').remove();
		$('.otherlabel').find('br').remove();
		$('span[id^="junk"]').remove();
		$('.mailidLabel').find('br').remove();
		
		var hidVal = $("#hidincharge").val();
		if ($("[name='incharge[]']:checked").length <= 0 && hidVal == "") {
			alert("Please select atleast one Incharge");
			return false;
		} else {
			$("#hidcheck").val('1');
			var getchecked = $("#hidcheck").val();
			$("[name='incharge[]']:checked").each(function(){
				var res = $(this).val().split("$"); 
				if (getchecked == 1) {
				getchecked = 2;
				$('#inchargeDetails').val($('#inchargeDetails').val() + res[0]);
				$('#hidincharge').val($('#hidincharge').val() + res[1]);
				$('#inchargemailDetails').val($('#inchargemailDetails').val() + res[2]);
				} else {
					$('#inchargeDetails').val($('#inchargeDetails').val() + ";" + res[0]);
					$('#hidincharge').val($('#hidincharge').val() + ";" + res[1]);
					$('#inchargemailDetails').val($('#inchargemailDetails').val()  + ";" + res[2]);
				}
			});
			if ($('#hidincharge').val() != "") {
				var getcusId = $('#hidincharge').val().slice(0,-1);
				var strarray = getcusId.split(';');
			}
			if ($("[name='incharge[]']:checked").length > 0) {
				var v = document.getElementById("inchargeDetails").value;
				document.getElementById("inchargeDetails").value = v + ";";
				var mail = document.getElementById("inchargemailDetails").value;
				document.getElementById("inchargemailDetails").value = mail + ";";
				var s = document.getElementById("hidincharge").value;
				document.getElementById("hidincharge").value = s + ";";
			}
			var mailarray = mail.split(';');
			for (var i = 0; i < mailarray.length; i++) {
				$("<span id='junk'>"+ mailarray[i] +"</span><br>").appendTo(".mailidLabel");
			}

			if($("[name='other[]']:checked").length > 0){
				document.getElementById("tomailSelected").value = "";
				document.getElementById("hidmailSelectedid").value = "";
				$('span[id^="toselmail"]').remove();
				$('.otherlabel').find('br').remove();
				$("[name='other[]']:checked").each(function(){
					var res = $(this).val().split("$");
					$("<span id='toselmail'>"+ res[2] +"</span><br id='ch'>").appendTo(".otherlabel");
					var otherselect = $("#tomailSelected").val();
					var otherselectid = $("#hidmailSelectedid").val();
					if (otherselect.length > 0) {
						$('#tomailSelected').val(otherselect + ";" + res[2]);
						$('#hidmailSelectedid').val(otherselectid + ";" + res[1]);
						
					}else{
						$('#tomailSelected').val(otherselect + res[2]);
						$('#hidmailSelectedid').val(otherselectid + res[1]);
					}
				});
			}

			$("body div").removeClass("modalOverlay");
			$('#customerSelect').empty();
			$('#customerSelect').modal('toggle');
		}
		});
			$('.addmail').click(function(){
				var textbox2 = $('#textbox2').val();
				var textbox1 = $('#textbox1').val();
				var hidEditId = $('#hidEditId').val();
				if(textbox1==""){
					$("#empty_textbox1").removeClass("display_none");
					return false;
				}else{
					$("#empty_textbox1").addClass("display_none");

				}
				if(textbox2==""){
					$("#empty_textbox2").removeClass("display_none");
					return false;
				}else{
					$("#empty_textbox2").addClass("display_none");
					var reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					if(reg.test($('#textbox2').val()) == false){
						alert("Please Enter The Correct Mail Id");
						$('#othertomail_1').focus()
						return false;
					}
				}
				if(textbox1!="" && textbox2!=""){
					$.ajax({
						type: 'GET',
                    	url: 'getMailExistsCheck',
                    	data: {"mailId": textbox2,
                    	"editId":hidEditId  },
                    	success: function(resp){
                    		if(resp > 0){
								$("#existsChk_textbox2").removeClass("display_none");
								return false;
                    		}else{
                    			if(hidEditId!=""){
                    				$.ajax({
                    					type: 'POST',
				                    	url: 'updateOtherMailProcess',
				                    	data: {"mailId": textbox2,
			                    				"editId":hidEditId,
			                    				"other_name" : textbox1 },
                    				success: function(data){
                    				var cData = '<input type="checkbox" name="other[]" id="other[]" value="'+textbox1+'$'+hidEditId+'$'+textbox2+'" class="'+hidEditId+'selid">';
                    					$("#"+hidEditId+"checkChange").html(cData);
                    					
                    					$("#"+hidEditId+"othername").html(textbox1);
                    					$("#"+hidEditId+"othermail").html(textbox2);
                    					var edtClr = ' <a href="#demo" onclick="fneditdata(\''+textbox1+'\',\''+textbox2+'\',\''+hidEditId+'\')"> Edit </a> <a href="#demo"  onclick="fneditcleardata()"> Clear </a> '	;
										$("#"+hidEditId+"editClear").html(edtClr);
										fneditcleardata();
                    				},
                    				error: function(data){
	                    		
                    				}
                    				});
                    			}else{
                    				$("#existsChk_textbox2").addClass("display_none");
									$("<span id='tomail'>"+ textbox2 +"</span><br>").appendTo(".othermailidLabel");
									var sel = $("#tomailDetails").val();
									var toname = $("#tomailName").val();
									if(sel.length>0 && toname.length>0){
									document.getElementById("tomailDetails").value = sel + ";"+textbox2;
									document.getElementById("tomailName").value = toname + ";"+textbox1;
									}
									else{
									document.getElementById("tomailDetails").value = textbox2;
									document.getElementById("tomailName").value = textbox1;
									}
									$('.selectinchargegroup').click();
								/*	$('#customerSelect').empty();
									$('#customerSelect').modal('toggle');*/
                    			}
                    			
                    		}
                    	},
                    	error: function(resp){
	                    		
                    	}
					});
					
				}		
			});
	check();
	});
	function check(){
		if ($('#hidincharge').val() != "") {
			var getcusId = $('#hidincharge').val().slice(0,-1);
	       	var strarray = getcusId.split(';');
			for (var i = 0; i < strarray.length; i++) {
				jQuery("."+strarray[i]).prop("checked", true);
			}
		}
		if ($('#hidmailSelectedid').val() != "") {
			var getcusId = $('#hidmailSelectedid').val();
	       	var strarray = getcusId.split(';');
			for (var i = 0; i < strarray.length; i++) {
				jQuery("."+strarray[i]+"selid").prop("checked", true);
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
function fneditdata(name,email,id){
	$('#textbox2').val(email);
	$('#textbox1').val(name);
	$('#hidEditId').val(id);
	$("#edit_hide").removeClass("dis_none");
	$("#add_hide").addClass("dis_none");
}	
function fneditcleardata(){
	$('#textbox2').val("");
	$('#textbox1').val("");
	$('#hidEditId').val("");
	$("#add_hide").removeClass("dis_none");
	$("#edit_hide").addClass("dis_none");
}
</script>

{{ Form::hidden('mainmenu', $request->mainmenu, array('id' => 'mainmenu')) }}
{{ Form::hidden('hcusId', $request->customerId, array('id' => 'hcusId')) }}
{{ Form::hidden('hName', '', array('id' => 'hName')) }}
{{ Form::hidden('hidEditId','', array('id'=>'hidEditId')) }}
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
					<col width="45%">
					<col width="41%">
					<col width="">
				</colgroup>
				<thead class="CMN_tbltheadcolor">
					<th class="tac">{{ trans('messages.lbl_sno') }}</th>
					<th class="tac"></th>
					<th class="tac">{{ trans('messages.lbl_custname') }}</th>
					<th class="tac">{{ trans('messages.lbl_incharge_mail') }}</th>
				</thead>
				<tbody id="search" class="staff">
					<?php $i=0; ?>
					@forelse($getdetails as $key => $groupvalue)
						<tr class="h25" onclick="fnSclkTrInc('<?php echo $groupvalue->id; ?>','<?php echo $groupvalue->incharge_name; ?>');">
							<td class="tac"  >
								{{ ++$key }}
							</td>
							<td class="tac">
							<input type="checkbox" name="incharge[]" id="incharge[]"
							class="<?php echo $groupvalue->id; ?>" 
								value="<?php  echo $groupvalue->incharge_name."$".$groupvalue->id."$".$groupvalue->incharge_email_id; ?>"
								onclick="fnSclkTrInc('<?php echo $groupvalue->id; ?>','<?php echo $groupvalue->incharge_name; ?>');">
							</td>
							<td class="pl5 tal">
								@if($groupvalue->incharge_name  != "")
								 {{ $groupvalue->incharge_name }}
								@endif
							</td>
							<td class="tac"  >
								@if($groupvalue->incharge_email_id  != "")
								 {{ $groupvalue->incharge_email_id }}
								@endif
							</td>
						</tr>
					<?php $i++; ?>
					@empty
						<tr>
							<td class="text-center" colspan="5" style="color: red;">
							{{ trans('messages.lbl_nodatafound') }}</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		<div class="box100per mb5">
			Other Mails
			<fieldset class="h50 mr7 ml7">
				<div class="mt10" style="<?php echo $overflow;?>;<?php echo $height;?>;<?php echo $tableWidth;?>">
					<table id="data" class="tablealter  table-bordered table-striped mt10" width="99.95%" style="table-layout: fixed;">
				<colgroup>
					<col width="6%">
					<col width="8%">
					<col width="30%">
					<col width="35%">
					<col width="21%">
					<col width="">
				</colgroup>
				<thead class="CMN_tbltheadcolor" >
					<th class="tac">{{ trans('messages.lbl_sno') }}</th>
					<th class="tac"></th>
					<th class="tac">{{ trans('messages.lbl_custname') }}</th>
					<th class="tac">{{ trans('messages.lbl_incharge_mail') }}</th>
					<th class="tac"></th>
				</thead>
				<tbody id="search" class="staff">
					<?php $i=0; ?>
					@forelse($othermail as $key => $otherlist)
						<tr>
							<td class="tac"  >
								{{ ++$key }}
							</td>
							<td class="tac" id="<?php echo $otherlist->id.'checkChange'; ?>">
							<input type="checkbox" name="other[]" id="other[]" class=" <?php echo $otherlist->id.'selid'; ?>"
								value="<?php  echo $otherlist->other_name."$".$otherlist->id."$".$otherlist->other_mailid; ?>"
								>
							</td>
							<td class="pl5 tal" id="<?php echo $otherlist->id.'othername'; ?>">
								@if($otherlist->other_name  != "")
								 {{ $otherlist->other_name }}
								@endif
							</td>
							<td class="tac" id="<?php echo $otherlist->id.'othermail'; ?>" >
								@if($otherlist->other_mailid  != "")
								 {{ $otherlist->other_mailid }}
								@endif
							</td>
							<td class="tac" id="<?php echo $otherlist->id.'editClear'; ?>"> <a href="#demo"  onclick="fneditdata('{{ $otherlist->other_name }}','{{ $otherlist->other_mailid }}','{{ $otherlist->id }}')" > Edit </a> 
								<a href="#demo"  onclick="fneditcleardata()"> Clear </a>
							</td>
						</tr>
					<?php $i++; ?>
					@empty
						<tr>
							<td class="text-center" colspan="5" style="color: red;">
							{{ trans('messages.lbl_nodatafound') }}</td>
						</tr>
					@endforelse
				</tbody>
			</table>
				</div>	
			</fieldset>
		</div>
		<div class="box100per">
				<fieldset class="h50 mr7 ml7">
					<div class="dispinline col-md-12 mt10 mb5 ml17 text1">
						<div class="pull-left text-right clr_blue fwb mt5 labeltexttwos ml50">
							{{ trans('messages.lbl_custname') }}
							<span style="color:red;"> * 
							</span>
						</div>
						<div class="dispinline ml15 mb5 pull-left box30per">
							{{ Form::text('textbox1','',array('id'=>'textbox1', 
											'name' => 'textbox1',
											'class'=>'textbox1 form-control ime_mode_disable regdestwo',
											'maxlength' => 100,
											'onkeypress' =>'return blockSpecialChar(event)',
											'onblur'=>'this.value=jQuery.trim(this.value);')) }}
						</div>
							<label id="empty_textbox1" class="display_none mt6 change">
								This Field is required.
							</label>
							<label id="existsChk_textbox1" class="display_none mt6 change">
								This Value is already exists.
							</label>
					</div>  
					<div class="dispinline col-md-12 mt5 mb5 ml2 text2">
						<div class="pull-left text-right clr_blue fwb mt5 labeltexttwo ml50">
							{{ trans('messages.lbl_incharge_mail') }}
							<span style="color:red;"> * 
							</span>
						</div>
						<div class="dispinline ml15 mb5 pull-left box30per">
							{{ Form::text('textbox2','',array('id'=>'textbox2', 
											'name' => 'textbox2',
											'class'=>'textbox2 form-control ime_mode_disable regdestwo',
											'maxlength' => 100,
											'onblur'=>'this.value=jQuery.trim(this.value);')) }}
						</div>
							<label id="empty_textbox2" class="display_none mt6 change">
								This Field is required.
							</label>
							<label id="existsChk_textbox2" class="display_none mt6 change">
								This Value is already exists.
							</label>
					</div>  
				</fieldset>
			</div>
	<div class="modal-footer bg-info mt10">
	  <center>
	  	<button id="edit_hide" class="dis_none btn edit btn-warning CMN_display_block box100 addmail">
			<i class="fa fa-edit" aria-hidden="true"></i>
			   {{ trans('messages.lbl_update') }}
		 </button>
	  	 <button id="add_hide" class="btn btn-success CMN_display_block box100 addmail">
			<i class="fa fa-plus" aria-hidden="true"></i>
			   {{ trans('messages.lbl_addmail') }}
		 </button>
		 <button id="add" class="btn btn-success CMN_display_block box100 selectinchargegroup">
			<i class="fa fa-plus" aria-hidden="true"></i>
			   {{ trans('messages.lbl_select') }}
		 </button>
		 <button data-dismiss="modal" onclick="javascript:fnclose();" class="btn btn-danger CMN_display_block box100">
			<i class="fa fa-times" aria-hidden="true"></i>
			   {{ trans('messages.lbl_cancel') }}
		 </button>
		 <!-- onclick="javascript:return cancelpopupclick();" -->
	  </center>
	</div>
</div>

   </div>
   </div>
  