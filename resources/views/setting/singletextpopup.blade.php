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
{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
{{ Form::hidden('location', $request->location , array('id' => 'location')) }}
{{ Form::hidden('tablename', $request->tablename , array('id' => 'tablename')) }}
{{ Form::hidden('type', '1', array('id' => 'type')) }}
{{ Form::hidden('process', '1', array('id' => 'process')) }}
{{ Form::hidden('hid_txtval', '', array('id' => 'hid_txtval')) }}
{{ Form::hidden('confirmflg', '', array('id' => 'confirmflg')) }}
{{ Form::hidden('flag', '', array('id' => 'flag')) }}
{{ Form::hidden('flashmessage', '', array('id' => 'flashmessage')) }}
{{ Form::hidden('hdnprocessid', '', array('id' => 'hdnprocessid')) }}
<div class="popupstyle popupsize">
	<div class="modal-content">
		<div class="modal-header" style="padding-bottom:1px;padding-top:8px;">
			<a onclick="javascript:return divpopupclose();"
					class="close mt2" 
					style="color: red;" 
					aria-hidden="true">
				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			</a>
			<h2 class="pull-left pl5 mt2 heading">{{ $headinglbl }}</h2>
		</div>
		<input type="hidden" name="nameval" id="nameval">
		<input type="hidden" name="bid" id="bid">
		<div class="col-xs-12 pm0">
			<div class="box98per mt5">
				<div align="center" class="alertboxalign mr80 messagedisplay" id="popupsessionreg" style="display: none;">
					<p class="alert alert-success">
						Inserted Successfully!
					</p>
				</div>
				<div align="center" class="alertboxalign mr80 messagedisplay" id="popupsessionupd" style="display: none;">
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
				<div align="center" class="alertboxalign mr80 messagedisplay" id="popupsessioncommit" style="display: none;">
					<p class="alert alert-success">
						Commited Successfully!
					</p>
				</div>
			</div>
		<div class="pull-right mr30 designchange">
			<button type="button" name="edit" style="background-color: #bbb5b5;" id="edit" class="pull-left btn edit  mt10 mb10"  disabled="disabled" onclick="return fneditcheck();">
				<i class="glyphicon glyphicon-edit"></i> {{ trans('messages.lbl_edit') }} 
			</button>
			<div class="mt13 mr5 ml5 pull-left" style="padding: 0px;">
					<button type="button" id="dwnArrow" class="fa fa-arrow-down" disabled="disabled"  style="" onclick="getdowndata()">
					</button>
					<button type="button" id="upArrow" class="fa fa-arrow-up" disabled="disabled"  style="" onclick="getupdata()">
					</button>
			</div>
			<button type="button" style="background-color: #bbb5b5;" class="btn add mt10 mb10" id="commit_button" disabled="disabled" onclick="getcommitCheck('{{ $request->tablename }}','{{ $request->screen_name }}','');">
				<i class="glyphicon glyphicon-check"></i> {{ trans('messages.lbl_commit') }} 
			</button>
		</div>
		</div>
		<div class="box100per pr5 pt15 pl10 mt10">
			<table class="tablealter table-bordered table-striped" width="96.95%" 
				style="table-layout: fixed;">
				<colgroup>
					<col class="select" width="10%">
					<col class="sno" width="10%">
					<col class="category" width="65%">
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
							{{ $field1lbl }}
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
						<col class="category" width="65%">
						<col class="use" width="18%">
					</colgroup>
					<tbody class="box100per setcolor">
						{{ Form::hidden('rdoid','',array('id' => 'rdoid')) }}
						{{--*/ $idOrder="" /*--}}
						@php ($i = 1)
						@forelse($getdetails as $count => $data)
						{{--*/ $j = $count /*--}}
						{{--*/ $id = $data->$getTableFields[$request->tablename]['displayfields'][0] /*--}}
						{{--*/ $orderid = $data->$getTableFields[$request->tablename]['displayfields'][4] /*--}}
						{{--*/ $delflg = $data->$getTableFields[$request->tablename]['displayfields'][3] /*--}}
							<tr>
								<td class="text-center" title="Select">
									<input type="radio" 
											name="rdoedit" 
											id="rdoedit{{ $data->$selectfiled['0'] }}" 
											class="h13 w13 rdoedit" 
											value="{{ $data->$selectfiled['0'] }}" 
											onclick="fnrdocheck(
													'{{ $data->$selectfiled['1'] }}',
													'{{ $data->$selectfiled['0'] }}',
													'<?php echo count($getdetails);?>',
													'<?php echo $j;?>')">
									{{ Form::hidden('id', $id , array('id' => 'id')) }}	
								</td>
								<td class="text-center vam">{{ $i++ }}</td>
								<td class="pl5 vam" id="dataname{{$data->$selectfiled['0']}}">
									{{ $data->$selectfiled['1'] }}		
								</td>
								<td class="tac vam">
									<a href="javascript:useNotuse('{{ $data->$selectfiled['0'] }}','{{$i}}');" 
											class="btn-link anchorstyle" 
											style="color:blue;cursor: pointer;">
										@if ($data->$selectfiled['3'] != 1) 
											<span class="btn-link" 
													id="usenotuselabel{{$i}}"  title="Use/Not Use"
													data-type="{{ $data->$selectfiled['3'] }}" style="color:blue;cursor: pointer;">{{ trans('messages.lbl_use') }}
											</span>
										 @else 
											<span class="btn-link" 
													id="usenotuselabel{{$i}}" title="Use/Not Use"
													data-type="{{ $data->$selectfiled['3'] }}" style="color:red;cursor: pointer;">
													{{ trans('messages.lbl_notuse') }}
											</span>
										 @endif
										 <input type="hidden" name="hdnNewOrderid" 
													id="hdnNewOrderid_<?php echo $j;?>" value="<?php echo $j;?>"/>
									</a>
									 {{ Form::hidden('curtFlg'.$i, $data->$selectfiled['3'] , array('id' => 'curtFlg'.$i)) }} 
									{{ Form::hidden('editid'.$i, $data->$selectfiled['0'], array('id' => 'editid'.$i)) }} 
								</td>
							</tr>
								{{--*/ $idOrder .= $data->$getTableFields[$request->tablename]['displayfields'][4]."," /*--}}
							@empty
							<tr class="nodata">
								<td class="text-center red" colspan="4">
									{{ trans('messages.lbl_nodatafound') }}
								</td>
							</tr>	
						@endforelse
						{{--*/ $idOrder = rtrim($idOrder, ",") /*--}}
					</tbody>
				</table>
			</div>
			{{ Form::hidden('idOriginalOrder', $idOrder, array('id' => 'idOriginalOrder')) }}
			<div class="box100per mt10">
				<fieldset class="h50 mr7 ml7">
					<div class="dispinline col-md-12 mt10 mb5 ml50">
						<div class="pull-left text-right clr_blue fwb mt5 labeltext ml40">
							{{ $field1lbl }}
							<span style="color:red;"> * 
							</span>
						</div>
						<div class="dispinline ml15 mb5 pull-left box30per">
							{{ Form::text('textbox1','',array('id'=>'textbox1', 
											'name' => 'textbox1',
											'class'=>'textbox1 form-control ime_mode_disable regdes',
											'maxlength' => 100,
											'onkeypress' =>'return blockSpecialChar(event)',
											'onblur'=>'this.value=jQuery.trim(this.value);')) }}
						</div>
						<label id="empty_textbox1" class="display_none mt6 change">
							This Field is required.
						</label>
						<label id="existsChk_textbox1" class="registernamecolor display_none mt6 change">
							This Value is already exists.
						</label>
					</div>  
				</fieldset>
			</div>
			<fieldset class="mt10 mr7 ml7 footerbg" >
				<center>
					<div class="box100per text-center mt10">
						<div class="CMN_display_block" id="add_var">
							<button type="button"
								class="btn btn-success box80 text-center btnsize" onclick="return fnaddeditsinglefield('{{ $request->location  }}',
															'{{ $request->mainmenu }}',
															'{{ $request->tablename }}',
															'{{ 1 }}','{{ 1 }}');">
								<i class="fa fa-plus" id="plusicon"></i>
									{{ trans('messages.lbl_add') }}
							</button>
							<a onclick="javascript:return divpopupclose();" class="btn btn-danger btnsize" 
							style="color:white;text-decoration:none!important;">
								<span class="fa fa-remove"></span>
								{{ trans('messages.lbl_cancel')}}
							</a>
						</div>
						<div class="CMN_display_block" id="update_var" style="display: none;">
							<button  id="btnadd" type="button" 
								onclick="return fnaddeditsinglefield('{{ $request->location  }}',
																		'{{ $request->mainmenu }}',
																		'{{ $request->tablename }}',
																		'{{ 2 }}','{{ 2 }}');" 
								class="btn btn-success CMN_display_block box92 btn add btn-warning btnsize">
								<i class="fa fa-edit" id="plusicon"></i> {{ trans('messages.lbl_update') }}
							</button> 
							<a onclick="javascript:return divpopupclose();" class="btn btn-danger btnsize" 
							style="color:white;text-decoration:none!important;">
								<span class="fa fa-remove"></span>
								{{ trans('messages.lbl_cancel')}}
							</a>
						</div>
					</div>
				</center>
			</fieldset>
			<br>
		</div>
	</div>
</div>
{{ Form::close() }}
	