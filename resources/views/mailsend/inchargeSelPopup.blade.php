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

	$('.selectinchargegroup').click(function(){
		document.getElementById("inchargeDetails").value = "";
		document.getElementById("hidincharge").value = "";
		document.getElementById("inchargemailDetails").value = "";
		$('span[id^="junk"]').remove();
		
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
			$("<span id='junk' style='word-wrap:break-word;'>"+ mail +"</span>").appendTo(".mailidLabel");
			$("body div").removeClass("modalOverlay");
			$('#customerSelect').empty();
			$('#customerSelect').modal('toggle');
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

{{ Form::hidden('mainmenu', $request->mainmenu, array('id' => 'mainmenu')) }}
{{ Form::hidden('hcusId', $request->customerId, array('id' => 'hcusId')) }}
{{ Form::hidden('hName', '', array('id' => 'hName')) }}

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
				<thead class="CMN_tbltheadcolor" >
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

	<div class="modal-footer bg-info mt10">
	  <center>
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
   <script>
	$('.footable').footable({
	  calculateWidthOverride: function() {
		return { width: $(window).width() };
	  }
	}); 
  </script>