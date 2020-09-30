{{ HTML::script('public/js/setting.js') }}
{{ HTML::script('public/js/common.js') }}
{{ HTML::style(asset('public/css/settinglayout.css')) }}
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
	var data = {};
	$(document).on("click", "#swaptable1 tr", function(e) {
		if (event.target.nodeName != "SPAN") {
			$(this).find('td input:radio').prop('checked', true);
			$(this).find('td input:radio').prop('checked', true);
			document.getElementById("edit").disabled = false;
			$("#edit").css("background-color","#FF8C00");
			$('#selectbox1').val('');
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
<style>
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
{{ Form::open(array('name'=>'settingform', 'class'=>'focusFields',
					'method'=>'POST',
					'files'=>true,
					'id' => 'settingform')) 
}}
{{ Form::hidden('tablename', $request->tablename , array('id' => 'tablename')) }}
{{ Form::hidden('tableselect', $request->tableselect, array('id' => 'tableselect')) }}
{{ Form::hidden('type', '1', array('id' => 'type')) }}
{{ Form::hidden('process', '1', array('id' => 'process')) }}
{{ Form::hidden('hid_txtval', '', array('id' => 'hid_txtval')) }}
{{ Form::hidden('hid_selectval', '', array('id' => 'hid_selectval')) }}
{{ Form::hidden('confirmflg', '', array('id' => 'confirmflg')) }}
{{ Form::hidden('flag', '', array('id' => 'flag')) }}
{{ Form::hidden('flashmessage', '', array('id' => 'flashmessage')) }}
{{ Form::hidden('hdnprocessid', '', array('id' => 'hdnprocessid')) }}
{{ Form::hidden('connectto', $request->connectto, array('id' => 'connectto')) }}
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
				<div align="center" class="alertboxalign mt7 messagedisplay" id="popupsessionexist" style="display: none;">
					<p class="alert alert-danger">
						{{ $field2lbl }} Already Exist!
					</p>
				</div>
				<div align="center" class="alertboxalign mr80 messagedisplay" id="popupsessioncommit" style="display: none;">
					<p class="alert alert-success">
						Commited Successfully!
					</p>
				</div>
			</div>

		<div class="pull-right mr30 designchange">
			<button type="button" name="edit" style="background-color: #bbb5b5;" id="edit" class="pull-left btn edit  mt10 mb10"  disabled="disabled" onclick="return fneditcheckforselecttext();">
				<i class="glyphicon glyphicon-edit"></i> {{ trans('messages.lbl_edit') }} 
			</button>
			<div class="mt13 mr5 ml5 pull-left" style="padding: 0px;">
					<button type="button" id="dwnArrow" class="fa fa-arrow-down" disabled="disabled"  style="" onclick="getdowndata()">
					</button>
					<button type="button" id="upArrow" class="fa fa-arrow-up" disabled="disabled"  style="" onclick="getupdata()">
					</button>
			</div>
			<button type="button" style="background-color: #bbb5b5;" class="btn add mt10 mb10" id="commit_button" disabled="disabled" onclick="getcommitCheck('{{ $request->tablename }}','{{ $request->screen_name }}','{{$request->tableselect}}');">
				<i class="glyphicon glyphicon-check"></i> {{ trans('messages.lbl_commit') }} 
			</button>
		</div>

		</div>
		<div class="box100per pr5 pt15 pl10">
			<table class="tablealter  table-bordered table-striped" width="96.95%" style="table-layout: fixed;">
				<colgroup>
					<col class="selectselect" width="10%">
					<col class="snoselect" width="10%">
					<col class="categoryselect" width="30%">
					<col class="subselect" width="30%">
					<col class="useselect" width="18%">
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
					<th class="fs14 pb3 CMN_tbltheadcolor">
						{{ $field2lbl }}
					</th>
					<th class="fs14 pb3  CMN_tbltheadcolor">
						{{ trans('messages.lbl_use') }}/{{ trans('messages.lbl_notuse') }}
					</th>
					</tr>
				</thead>
			</table>
			{{--*/ $overflow = 'overflow-y: scroll;' /*--}}
			{{--*/ $tableWidth = 'width:99.4%;' /*--}}
			{{--*/ $height = 'height:235px;' /*--}}
			<div id="scrolloption" style="<?php echo $overflow;?>;<?php echo $height;?>;<?php echo $tableWidth;?>" >
				<table id="swaptable1" 
							class="table-striped table table-bordered tablealter" 
							width="<?php echo $tableWidth;?>" 
							style="table-layout: fixed;">
					<colgroup>
						<col class="selectselect" width="10%">
						<col class="snoselect" width="10%">
						<col class="categoryselect" width="30%">
						<col class="subselect" width="30%">
						<col class="useselect" width="18%">
					</colgroup>
					<tbody class="box100per setcolor">
					{{ Form::hidden('rdoid','',array('id' => 'rdoid')) }}  
					{{--*/ $idOrder="" /*--}}
					@php ($i = 1)
					@forelse($getdetails as $count => $data)
					{{--*/ $j = $count /*--}}
					{{--*/ $id = $data->$getTableFields[$request->tablename]['displayfields'][0] /*--}}
					{{--*/ $orderid = $data->$getTableFields[$request->tablename]['displayfields'][5] /*--}}
					{{--*/ $delflg = $data->$getTableFields[$request->tablename]['displayfields'][4] /*--}}
						<tr class="h37" id="rowcolor{{ $data->$selectfiled['0'] }}" 
								>
							<td class="text-center" title="Select">
								<input type="radio" 
										name="rdoedit" 
										id="rdoedit{{ $data->$selectfiled['0'] }}" 
										class="h13 w13 rdoedit"  
										onclick="fnrdocheckforselecttext(
										'{{ $data->$selectfiled['1'] }}',
										'{{ $data->selectfield }}',
										'{{ $data->$selectfiled['0'] }}',
										'<?php echo count($getdetails);?>',
										'<?php echo $j;?>');">
								
								{{ Form::hidden('id', $id , array('id' => 'id')) }}
							</td>
							<td class="text-center vam">{{ $i++ }}</td>
							<td class="pl5 vam" id="datanametd2{{$data->$selectfiled['0']}}">
									{{ $data->$selectfiled['2'] }}
									<input type="hidden" name="hiddenselectvalue"  id="dataname1{{$data->$selectfiled['0']}}" value="{{ $data->selectfield }}">
							</td>
							<td class="pl5 vam" id="dataname2{{$data->$selectfiled['0']}}">
									{{ $data->$selectfiled['1'] }}
							</td>
							<td class="tac vam" title="Use/Not Use">
								<a id="usenotuseanchor{{$i}}" 
										href="javascript:useNotuse('{{ $data->$selectfiled['0'] }}',
										'{{$i}}');" 
										class="btn-link anchorstyle" 
										style="color:blue;cursor: pointer;">
									@if ($data->$selectfiled['4'] != 1) 
										<span class="btn-link" 
												id="usenotuselabel{{$i}}" 
												data-type="{{ $data->$selectfiled['4'] }}" style="color:blue;cursor: pointer;">{{ trans('messages.lbl_use') }}
										</span>
									@else 
										<span class="btn-link" 
												id="usenotuselabel{{$i}}" 
												data-type="{{ $data->$selectfiled['4'] }}" style="color:red;cursor: pointer;">
												{{ trans('messages.lbl_notuse') }}
										</span>
									@endif
									<input type="hidden" name="hdnNewOrderid" 
													id="hdnNewOrderid_<?php echo $j;?>" value="<?php echo $j;?>"/>
								</a>
								{{ Form::hidden('curtFlg'.$i, $data->$selectfiled['4'] , array('id' => 'curtFlg'.$i)) }} 
								{{ Form::hidden('editid'.$i, $data->$selectfiled['0'], array('id' => 'editid'.$i)) }} 
							</td>
						</tr>
						{{--*/ $idOrder .= $data->$getTableFields[$request->tablename]['displayfields'][5]."," /*--}}
					@empty
						<tr class="nodata">
							<td class="text-center red" colspan="5">
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
				<fieldset class="mr7">
					<div class="dispinline col-md-12 mt10 ml50">
						<div class="pull-left text-right clr_blue fwb labeltextselects ml60">
							{{ $field1lbl }}
							<span style="color:red;"> * 
							</span>
						</div>
						<div class="dispinline ml15 pull-left box70per mb5">
							{{ Form::select('selectbox1',[null=>''] + $selectboxval, '',
								array('id' => 'selectbox1',
								'class' => 'widthauto input-sm form-control regdesselects',
								'style' => 'background-color: white;',
								'onblur'=>'this.value=jQuery.trim(this.value);')) }}
						</div>
					</div>
					<div class="dispinline col-md-12 mt5 mb5 ml50">
						<div class="pull-left text-right clr_blue fwb labeltextselect ml70">
							{{ $field2lbl }}
							<span style="color:red;"> * 
							</span>
						</div>
						<div class="ml15 pull-left box30per mb5">
							{{ Form::text('textbox1','',array('id'=>'textbox1', 
											'name' => 'textbox1',
											'class'=>'box65per form-control ime_mode_disable regdesselect',
											'maxlength' => 40,
											'style' => 'text-transform: capitalize;',
											'onkeypress' =>'return blockSpecialChar(event);onlyLetter(this)',
											'onblur'=>'this.value=jQuery.trim(this.value);')) }}
							<label id="empty_textbox1" class="registernamecolor display_none" style="color: red;display: none;">
								This Field is required.
							</label>
						</div>
					</div>  
				</fieldset>
			</div>
			<fieldset class="mt10 mb10 mr7 footerbg" >
				<center>
					<div class="box100per text-center mt5 mb5" id="">
						<div class="CMN_display_block" id="add_var">
							<button type="button"
								class="btn btn-success box80 text-center btnsize" onclick="return fnaddeditselecttextfield('{{ $request->tablename }}','{{ 1 }}');">
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
								onclick="return fnaddeditselecttextfield('{{ $request->tablename }}',
								'{{ 2 }}');" 
								class="btn btn-success CMN_display_block box80 btn add btn-warning btnsize">
								<i class="fa fa-edit" id="plusicon"></i>{{ trans('messages.lbl_update') }}
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
	