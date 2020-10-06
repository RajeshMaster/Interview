{{ HTML::script(asset('public/js/setting.js')) }}
{{ HTML::script(asset('public/js/common.js')) }}
{{ HTML::style(asset('public/css/settinglayout.css')) }}
<script type="text/javascript">
	var datetime = '@php echo date('Ymdhis') @endphp';
	var mainmenu = '@php echo $request->mainmenu @endphp';
	$(document).ready(function() {  
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
		$('.selectgroup').click(function(){
			 if ($('input[name="grpId"]:checked').length == 0) {
				alert("Please select atleast one Group");
				return false;
			} else {
				var radioValue = $("input[name='grpId']:checked").val();
				var confirmgroup = confirm("Do You Want To Select Group?");
				if(confirmgroup) {
					$('#groupId').val(radioValue);
					pageload();
					form.submit();
					return true;
					$("body div").removeClass("modalOverlay");
					$('#inchargenamepopup').empty();
					$('#inchargenamepopup').modal('toggle');
				} else {
					return false;
				}
			}
		});
	});
</script>
	{{ Form::open(array('name'=>'frmgroupsel', 'id'=>'frmgroupsel', 
					  'url' => 'Customer/groupselpopup?mainmenu='.$request->mainmenu.
					  '&time='.date('YmdHis'),
					  'files'=>true,
					  'method' => 'POST')) }}
	{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
	{{ Form::hidden('customerId', $request->custId , array('id' => 'customerId')) }}
	{{ Form::hidden('groupId', '' , array('id' => 'groupId')) }}
	{{ Form::hidden('groupName', '' , array('id' => 'groupName')) }}
<div class="popupstyle popupsize">	
	<div class="modal-content">
		<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" style="color: red;" aria-hidden="true">&#10006;</button>
			<h3 class="modal-title custom_align"><B>SELECT GROUP</B></h3>
    	</div>
		<div>
			<div style="display: inline-block;float: right;margin-top: 5px;">
				{!! Form::text('staffsearch', $request->staffsearch,
					array('','class'=>' form-control box85per pull-left','style'=>'height:30px;','id'=>'staffsearch','placeholder'=>'Search')) !!}
			</div>
		</div>
	    <div class="modal-body" style="height: 310px;overflow-y: scroll;width: 100%;">
			<table class="tablealternate box99per table-striped ml5 mt5" id="grouptable">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="20%">
					<col width="20%">
				</colgroup>
				<thead class="CMN_tbltheadcolor">
					<tr class="h25">
						<th class="box5per"><?php echo ""; ?></th>
						<th class="box6per"><?php echo "S.No"; ?></th>
						
						<th class="pl5 box25per"><?php echo "Group Id"; ?></th>
						<th class="pl5 box25per"><?php echo "Group Name"; ?></th>
					</tr>
				</thead>
				<tbody id="search">
					<?php $i=0; ?>
					@forelse($getallGroup as $key => $value)
						<tr>
							<td align="center">
								<input  type="radio" value="<?php echo $value->groupId; ?>" 
									id = "grpId" name="grpId">
							</td>
							<td align="center">
								{{ $i + 1 }}
							</td>
							<td align="center">
								{{ $value->groupId }}
							</td>
							<td align="center">
								{{ $value->groupName }}
							</td>
						</tr>
						<?php $i++; ?>
					@empty
						<tr>
							<td class="text-center" colspan="4" style="color: red;">
							{{ trans('messages.lbl_nodatafound') }}</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		<div class="modal-footer bg-info">
			<center>
				<button type="submit" name ="selectgrp" id="selectgrp" 
						class="btn btn-success btn box15per selectgroup">
					<i class="fa fa-edit"></i>
				  	{{ trans('messages.lbl_select') }}
				</button>
				<button type="button" onclick="divGroupSelPopClose();" 
					  class="btn btn-danger CMN_display_block box18per button" >
					<i class="fa fa-remove" aria-hidden="true"></i> 
					{{ trans('messages.lbl_cancel') }}
				</button>
			</center>
		</div>
	</div>
</div>	
{{ Form::close() }}