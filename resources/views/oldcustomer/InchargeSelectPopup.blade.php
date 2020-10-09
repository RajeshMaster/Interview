{{ HTML::script(asset('public/js/setting.js')) }}
{{ HTML::script(asset('public/js/oldcustomer.js')) }}
{{ HTML::script(asset('public/js/common.js')) }}
{{ HTML::style(asset('public/css/settinglayout.css')) }}
<script type="text/javascript">
	var datetime = '@php echo date('Ymdhis') @endphp';
	var mainmenu = '@php echo $request->mainmenu @endphp';
	$(document).ready(function() {
		fncheckalreadyCheck();
	});
	
</script>
	{{ Form::open(array('name'=>'frmInchargesel', 'id'=>'frmInchargesel', 
					  'url' => 'OldCustomer/InchargeSelect?mainmenu='.$request->mainmenu.
					  '&time='.date('YmdHis'),
					  'files'=>true,
					  'method' => 'POST')) }}
	{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
<div class="popupstyle popupsize">	
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" style="color: red;" aria-hidden="true">&#10006;</button>
			<h3 class="modal-title custom_align"><B>SELECT Incharge</B></h3>
		</div>
	
		<div class="modal-body" style="height: 310px;overflow-y: scroll;width: 100%;">
			<table class="tablealternate box99per table-striped ml5 mt5" id="grouptable">
					<colgroup>
						<col width="5%">
						<col width="5%">
						<col width="20%">
						<col width="20%">
						<col width="20%">
					</colgroup>
					<thead class="CMN_tbltheadcolor">
						<tr class="h25">
							<th class="box6per"><?php echo "S.No"; ?></th>
							<th class="box5per"><?php echo ""; ?></th>
							<th class="pl5 box25per"><?php echo "Incharge Name"; ?></th>
							<th class="pl5 box25per"><?php echo "Incharge Name Romanji"; ?></th>
							<th class="pl5 box25per"><?php echo "Incharge Mail"; ?></th>
						</tr>
					</thead>
				<tbody id="search">

					@if(count($getAllInchargeDtl) != 0)
						@foreach($getAllInchargeDtl as $key => $inchargeValue)
							<tr class="h25" style="" onclick="trclick('{{ $inchargeValue->id }}')">
								<td class="tac" style="" >
									{{ $key+1 }}
								</td>
								<td class="tac" style="">
									<input type="checkbox" name="incharge[]" id="incharge[]"  onclick="trclick('{{ $inchargeValue->id }}')"
										class="<?php echo $inchargeValue->id; ?>" 
										value="<?php  echo $inchargeValue->id."$".$inchargeValue->incharge_name."$".$inchargeValue->incharge_email_id; ?>">
								</td>
								<td class="pl5 tal">
									{{ $inchargeValue->incharge_name }}
								</td>
								<td class="pl5 tal">
									{{ $inchargeValue->incharge_name }}
								</td>
								<td class="pl5 tal">
									{{ $inchargeValue->incharge_email_id }}
								</td>
							</tr>
						@endforeach
					@else
						<td class="tac" colspan="5">
							No Data Found
						</td>
					@endif

				</tbody>
			</table>
		</div>
		<div class="modal-footer bg-info">
			<center>
				<button type="button" name ="selectgrp" id="selectInc" 
							class="btn btn-success btn btnlengthset selectIncharge">
						<i class="fa fa-edit"></i>
						{{ trans('messages.lbl_select') }}
				</button>
				<button type="button" onclick="divGroupSelPopClosess();" 
						class="btn btn-danger CMN_display_block btnlengthset button" style="margin-bottom: 5px!important;">
					<i class="fa fa-remove" aria-hidden="true"></i> 
					{{ trans('messages.lbl_cancel') }}
				</button>
			</center>
		</div>
	</div>
</div>	
{{ Form::close() }}