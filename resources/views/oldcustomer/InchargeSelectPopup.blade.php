{{ HTML::script(asset('public/js/oldcustomer.js')) }}

<style>
	.modal {
		position: fixed;
		top: 50% !important;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	.popF_color {
		background-color: #ccf2ff;
		margin-left: 0px;
		width: 100%;
		border-radius: 0px;
	}
</style>
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
	<div class="modal-content">
		<div class="modal-header">
			<div class="fwb">
				<button type="button" data-dismiss="modal" class="close red" aria-hidden="true">&#10006; </button>
				<h2 style="font-size:30px;" class="modal-title custom_align">Select Incharge</h2>
				<hr></hr>
			</div>
			<div id="errorForexistCus" align="center" class="box100per pt5"></div>
			<fieldset style="width:100%;" id="outerdiv">
				<div class="CMN_display_block box100per" style="min-height: 300px;">
					<table class="tablealternate box99per ml5 mt5" id="">
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
						<tbody>
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
			</fieldset>
			<div class="modal-footer bg-info">
			  	<center>
					<button type="button" name ="selectgrp" id="selectInc" 
							class="btn btn-success btn box15per selectIncharge">
						<i class="fa fa-edit"></i>
					  	{{ trans('messages.lbl_select') }}
					</button>
					<button type="button" onclick="divGroupSelPopClosess();" 
						  class="btn btn-danger CMN_display_block box18per button" >
						<i class="fa fa-remove" aria-hidden="true"></i> 
						{{ trans('messages.lbl_cancel') }}
					</button>
				</center>
			</div>
		</div>
	</div>

{{ Form::close() }}