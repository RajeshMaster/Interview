{{ HTML::script(asset('public/js/setting.js')) }}
{{ HTML::script(asset('public/js/common.js')) }}
{{ HTML::style(asset('public/css/settinglayout.css')) }}
<style type="text/css">
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
	.width_160 {
		width: 160% !important;
	}
}
</style>
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	$(document).on("click", "#swaptable1 tr", function(e) {
		if (event.target.nodeName != "SPAN") {
			$(this).find('td input:radio').prop('checked', true);
			document.getElementById("edit").disabled = false;
			$("#edit").css("background-color","#FF8C00");
			$('#textbox1').val('');
		}
		$('#swaptable1').delegate('tr', 'click' , function(){
			if (event.target.type !== 'radio') {
				if (event.target.nodeName != "SPAN") {
					$(this).find('input[type=radio]').prop('checked', true).trigger("click");
				}
			}
		});
	});
</script>
{{ Form::open(array('name'=>'settingform','class'=>'focusFields',
					'method'=>'POST',
					'files'=>true,
					'id' => 'settingform')) 
}}
{{ Form::hidden('groupId', '' , array('id' => 'groupId')) }}
{{ Form::hidden('process', '1', array('id' => 'process')) }}
{{ Form::hidden('mainmenu', '' , array('id' => 'mainmenu')) }}
{{ Form::hidden('flag', '', array('id' => 'flag')) }}
{{ Form::hidden('hid_txtval', '', array('id' => 'hid_txtval')) }}
<div class="popupstyle popupsize">
	<div class="modal-content">
		<div class="modal-header" style="padding-bottom:1px;padding-top:8px;">
			<a onclick="javascript:return divpopupclose_grp();"
					class="close mt2" 
					style="color: red;" 
					aria-hidden="true">
				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			</a>
			<h2 class="pull-left pl5 mt2 heading">{{ trans('messages.lbl_group') }}</h2>
		</div>
		<input type="hidden" name="nameval" id="nameval">
		<input type="hidden" name="bid" id="bid">
		<div class="col-xs-12 pm0">
			<div class="box98per mt5">
				<div align="center" class="alertboxalign mr80 messagedisplay" id="grppopupsessionreg" style="display: none;">
					<p class="alert alert-success">
						Inserted Successfully!
					</p>
				</div>
				<div align="center" class="alertboxalign mr80 messagedisplay" id="grppopupsessionupd" style="display: none;">
					<p class="alert alert-success">
						Updated Successfully!
					</p>
				</div>
				<div align="center" class="alertboxalign mr80 messagedisplay" id="popupsessionuse" style="display: none;">
					<p class="alert alert-success">
						Value Use Successfully!
					</p>
				</div>
				<div align="center" class="alertboxalign mr80 messagedisplay" id="popupsessionnotuse" style="display: none;">
					<p class="alert alert-success">
						Value Not Use Successfully!
					</p>
				</div>
			</div>
		<div class="pull-right mr30 designchange">
			<button id="editlbl" data-dismiss="modal" onclick = "return editgroupcheck();" 
					class="btn CMN_display_block box100"
					disabled = "disabled" style= "background-color: orange;margin-left: 650px;">
				<i class="fa fa-edit"></i>{{ trans('messages.lbl_edit') }}
			</button>
		</div>
		</div>
		<div class="box100per pr5 pt15 pl10 mt10">
			<table class="tablealter table-bordered table-striped" width="96.95%" 
				style="table-layout: fixed;">
				<colgroup>
					<col class="select" width="10%">
					<col class="sno" width="10%">
					<col class="category" width="25%">
					<col class="category" width="20%">
					<col class="category" width="20%">
					<col class="use" width="18%">
				</colgroup>
				<thead class="CMN_tbltheadcolor" >
					<tr class="" style="height: 30px !important;">
						<th class="fs14 pb3 CMN_tbltheadcolor">
							{{ trans('messages.lbl_select') }}
						</th>
						<th class="fs14 pb3 CMN_tbltheadcolor">
							{{ trans('messages.lbl_sno') }}
						</th>
						<th class="fs14 pb3 CMN_tbltheadcolor">
							{{ trans('messages.lbl_group') }}
						</th>
						<th class="fs14 pb3 CMN_tbltheadcolor">
							{{ trans('messages.lbl_groupName') }}
						</th>
						<th class="fs14 pb3 CMN_tbltheadcolor">
							{{ trans('messages.lbl_custname') }}
						</th>
						<th class="fs14 pb3  CMN_tbltheadcolor">
							{{ trans('messages.lbl_use') }}/{{ trans('messages.lbl_notuse') }}
						</th>
					</tr>
				</thead>
			</table>
			{{--*/ $overflow = 'overflow-y: scroll;' /*--}}
			{{--*/ $tableWidth = 'width:99.5%;' /*--}}
			{{--*/ $height = 'height:235px;' /*--}}
			<div id="scrolloption" style="<?php echo $overflow;?>;<?php echo $height;?>;<?php echo $tableWidth;?>" >
				<table id="swaptable1" 
						class="table-striped table table-bordered tablealter" 
						width="<?php echo $tableWidth;?>" 
						style="table-layout: fixed;">
					<colgroup>
						<col class="select" width="10%">
						<col class="sno" width="10%">
						<col class="category" width="25%">
						<col class="category" width="20%">
						<col class="category" width="20%">
						<col class="use" width="18%">
					</colgroup>
					<tbody class="box100per setcolor">
						<?php $i=0; ?>
						@if(count($Selgroupname) != "")
				   		@for ($i = 0; $i < count($Selgroupname); $i++)
							<tr class="h37" onclick="groupcheck('{{ $Selgroupname[$i]['groupName'] }}','{{ $Selgroupname[$i]['id'] }}')">
								<td class="text-center" title="Select">
									<input type="radio" name="rdoedit" id="rdoedit{{ $Selgroupname[$i]['id'] }}"  class="h13 w13"  
										onclick="groupcheck('{{ $Selgroupname[$i]['groupName'] }}','{{ $Selgroupname[$i]['id'] }}');" value="<?php echo $Selgroupname[$i]['groupId']; ?>">
									{{ Form::hidden('radioid', $Selgroupname[$i]['id'] , array('id' => 'radioid')) }}
								</td>
								<td class="">{{ $i + 1 }}</td>
								<td class="">{{ $Selgroupname[$i]['groupId'] }}</td>
								<td class="" id="datavar<?php echo $Selgroupname[$i]['id']; ?>">
									{{ $Selgroupname[$i]['groupName'] }}</td>
								<td class="pl5 pt7" id="">
									@if(isset($Selgroupname[$i]['customer']))
									@foreach($Selgroupname[$i]['customer'] as $key => $value)
										{{ $value['cusName'] }}<br>
									@endforeach
									@endif
								</td>
								<td class="tac pt7" title="Use/Not Use">
									<a href="javascript:useNotuses('{{$i}}');" class="btn-link anchorstyle" style="color:blue;cursor: pointer;">
										@if ($Selgroupname[$i]['delFlg'] != 1) 
											<span class="btn-link" id="usenotuselabel{{$i}}" 
													data-type="{{ $Selgroupname[$i]['delFlg'] }}" style="color:blue;cursor: pointer;">
												{{ trans('messages.lbl_use') }}
											</span>
										@else
											<span class="btn-link" id="usenotuselabel{{$i}}" 
													data-type="{{ $Selgroupname[$i]['delFlg'] }}" style="color:red;cursor: pointer;"> 
												{{ trans('messages.lbl_notuse') }}
											</span>
										@endif
									</a>
									{{ Form::hidden('editid'.$i, $Selgroupname[$i]['id'], array('id' => 'editid'.$i)) }}
								</td>
							</tr>
						@endfor
						@else
							<tr class="nodata">
								<td class="text-center red" colspan="9">
									{{ trans('messages.lbl_nodatafound') }}
								</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
			<div class="box100per mt10">
				<fieldset class="h50 mr7 ml7">
					<div class="dispinline col-md-12 mt10 mb5 ml50">
						<div class="pull-left text-right clr_blue fwb mt5 labeltext ml40">
							{{ trans('messages.lbl_groupName') }}  
							<span style="color:red;"> * 
							</span>
						</div>
						<div class="dispinline ml15 mb5 pull-left box30per">
							{{ Form::text('grpName','',array('id'=>'grpName', 
								'name' => 'grpName','class'=>'box70per width_160 form-control ime_mode_active','maxlength' => 40,
								'onkeypress' =>'return blockSpecialChar(event)',
								'onblur'=>'this.value=jQuery.trim(this.value);'
							)) }}
						</div>
						<label id="empty_textbox1" class="display_none mt6 change">
							This Field is required.
						</label>
					</div>  
				</fieldset>
			</div>
			<fieldset class="mt10 mr7 ml7 footerbg" >
				<center>
					<div class="box100per text-center mt10">
						<div class="CMN_display_block" id="add_vargrp">
							<button  id="btnadd" type="button" onclick="return checkvalidate('register');" 
								class="btn btn-success CMN_display_block box100 addeditprocess" >
								<i class="fa fa-plus" id="plusicon"></i>
								{{ trans('messages.lbl_add') }}
							</button>
							<button type="button" onclick="return divpopupclose_grp();" 
								class="btn btn-danger CMN_display_block box110 button" >
								<i class="fa fa-remove" aria-hidden="true"></i> 
								{{ trans('messages.lbl_cancel') }}
							</button>
						</div>
						<div class="CMN_display_block" id="update_vargrp" style="display: none;">
							<button  id="btnadd" type="button" onclick="return checkvalidate('edit');"
									class="CMN_display_block box100 btn add btn-warning">
								<i class="fa fa-edit" id="plusicon"></i>
								{{ trans('messages.lbl_update') }}
							</button> 
							<button type="button" onclick="return divpopupclose_grp();"  
									class="btn btn-danger CMN_display_block box110 button" >
								<i class="fa fa-remove" aria-hidden="true"></i> 
								{{ trans('messages.lbl_cancel') }}
							</button>
						</div>
					</div>
				</center>
			</fieldset>
			<br>
		</div>
	</div>
</div>
{{ Form::close() }}
