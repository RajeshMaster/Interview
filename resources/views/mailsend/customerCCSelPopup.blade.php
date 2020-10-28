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
.block{
	filter: blur(1px);
    pointer-events: none;
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
		checkradio();
	});

	function checkradio(){
		if($('#customerId').val() !=""){
			var getcusId = $('#customerId').val();
			jQuery("#"+getcusId).prop("checked", false);
			jQuery("#"+getcusId+"cus").addClass("block");
		}
		if ($('#cusId').val() != "") {
			var getcusId = $('#cusId').val();
			jQuery("#"+getcusId).prop("checked", true);
		} 
		if ($('#hidccid').val() != "") {
			var getcusId = $('#hidccid').val();
			var strarray = getcusId.split(';');
			for (var i = 0; i < strarray.length; i++) {
				jQuery("#"+strarray[i]).prop("checked", true);
			}
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
					<col width="15%">
					<col width="">
					<col width="">
				</colgroup>
				<thead class="CMN_tbltheadcolor" >
					<th class="tac"></th>
					<th class="tac">{{ trans('messages.lbl_sno') }}</th>
					<th class="tac">{{ trans('messages.lbl_CustId') }}</th>
					<th class="tac">{{ trans('messages.lbl_cusname') }}</th>
					<th class="tac">{{ trans('messages.lbl_kananame') }}</th>
				</thead>
				<tbody id="search" class="staff">
					<?php $i=0; ?>
					@forelse($custDtl as $key => $value)
						<tr id="<?php echo $value->customer_id."cus"; ?>">
							<td align="center">
							<input  type="checkbox" id="<?php echo $value->customer_id; ?>" name="cusId[]" value="<?php echo $value->customer_id."$".$value->customer_name; ?>">
							
							</td>
							<td align="center">
								{{ $i + 1 }}
							</td>
							<td align="center">
								{{ $value->customer_id }}
							</td>
							<td>
								{{ $value->customer_name }}
							</td>
							<td>
								{{ $value->romaji }}
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
		 <button id="add" onclick="fnCCselect();" class="btn btn-success CMN_display_block box100">
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