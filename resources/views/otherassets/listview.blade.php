@extends('layouts.app')
@section('content')
@php use App\Http\Helpers @endphp
{{ HTML::script(asset('public/js/otherassets.js')) }}
<style type="text/css">
	.pm0{padding: 0px;margin: 0px;}
	/* Set height of the grid so .sidenav can be 100% (adjust if needed) */
	.row.content {height: 500px}
	/* Set gray background color and 100% height */
	.sidenav {
		background-color: #fcfcfc;
		height: auto;
		min-height: 100%;
		border-radius: 3px;
		border: 1px solid #DDDDDD;
	}
	/* Set black background color, white text and some padding */
	footer {
		background-color: #555;
		color: white;
		padding: 15px;
	}
	
	.disabled {
		cursor: none;
		pointer-events: none;
		color: black;
		text-decoration: none;
	}
	.rowdiv{
		margin-right:-45px;
		margin-left:-29px;
	}
	.image1 {
		margin: 5% !important;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}
	.textDecNone:hover {
		text-decoration: none !important;
		color: white !important;
	}

</style>
<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
</script>

<div class="" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="balsheet" class="DEC_flex_wrapper" data-category="balsheet balsheet_sub_3">

	{{ Form::open(array('name'=>'OtherAssetslistview',
			'id'=>'OtherAssetslistview',
			'url' => 'OtherAssets/listview?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
			'method' => 'POST')) }}
	{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
	{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
	{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
	{{ Form::hidden('filval', $request->filval , array('id' => 'filval')) }}
	{{ Form::hidden('pageview', $request->pageview , array('id' => 'pageview')) }}
	{{ Form::hidden('userId', $request->userId , array('id' => 'userId')) }}
    {{ Form::hidden('selYear', $request->selYear , array('id' => 'selYear')) }}
	{{ Form::hidden('selMonth', $request->selMonth , array('id' => 'selMonth')) }}
    {{ Form::hidden('editChk', $request->editChk , array('id' => 'editChk')) }}
	{{ Form::hidden('userId', $request->userId , array('id' => 'userId')) }}
	{{ Form::hidden('otherAssetsId', '' , array('id' => 'otherAssetsId')) }}
	<fieldset class="pm0 mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/loan.png')  }}">
			<h2 class="h2cnt">{{ trans('messages.lbl_otherassets') }}</h2>
		</div>
	</fieldset>

	<div class="mt20 mb10">
		@if($request->filval == 2)
			{{ Helpers::displayYear_Month($prev_yrs,$cur_year,$cur_month,$total_yrs,$curtime) }}
		@else
			{{ Helpers::displayYear($prev_yrs,$cur_year,$total_yrs,$curtime) }}
		@endif
	</div>
	
	@if (session('danger'))
		<div class="col-xs-12 mt10" align="center">
			<span class="alert-danger">{{ session('danger') }}</span>
		</div>
	@elseif (session('message'))
		<div class="col-xs-12 mt10" align="center">
			<span class="alert-success">{{ session('message') }}</span>
		</div>
	@endif

	<div class="col-xs-12 pm0 pull-left mb10" style="padding: 0px !important;">
		<a href="javascript:otherAssetsRegister();" 
			class="button button-green textDecNone">
			<span class="fa fa-plus"></span> {{ trans('messages.lbl_register') }}
		</a>
		@if($request->filval == 2)
			@if(count($getCurrMnthRec) != 0)
			<a href="javascript:nxtMnthRec();" class="button button-blue"
				style="text-decoration: none !important;">
				{{ trans('messages.lbl_getnxtmonth') }}
			</a>
			@endif
		@endif
	</div>
	<div>
		<div class="pull-left mt5 mb10">
			<a href="javascript:otherAssetsfilter('1');" style="text-decoration: none !important;"
				class = {{ $disabledyear }} >
				{{ trans('messages.lbl_yearwise') }}
			</a>&nbsp;|&nbsp;
			<a href="javascript:otherAssetsfilter('2');" style="text-decoration: none !important;"
				class = {{ $disabledmonth }} >
				{{ trans('messages.lbl_monthwise') }}
			</a>
		</div>
		<div class="pull-right mt5 mb10">
			<label>単位：万円</label>
		</div>
	</div>
	<div class="mt50">
		<ul class="list-group pm0 rowlist">
			@if($request->filval == 2)
				<table class="table tablealter table-bordered table-striped">
					<colgroup>
						<col width="5%">
						<col width="10%">
						<col width="20%">
						<col width="15%">
						<col width="10%">
						<col width="35%">
						<col width="5%">
					</colgroup>
					<thead class="CMN_tbltheadcolor">
						<th>{{ trans('messages.lbl_sno') }}</th>
						<th>{{ trans('messages.lbl_date') }}</th>
						<th>{{ trans('messages.lbl_assetstypes') }}</th>
						<th>{{ trans('messages.lbl_main') }}</th>
						<th>{{ trans('messages.lbl_amount') }}</th>
						<th>{{ trans('messages.lbl_remarks') }}</th>
						<th></th>
					</thead>
					<tbody>
						@php $tempMnthBelongsTo = ''; @endphp
						@if(count($otherAssetsdtls) > 0 )
							@for ($i = 0; $i < count($otherAssetsdtls); $i++)
								@if($tempMnthBelongsTo != $otherAssetsdtls[$i]['belongsTo'])
									<tr>
										<td colspan="4" style="background-color: #c7e1f7;">
											@php $tempMnthBelongsTo = $otherAssetsdtls[$i]['belongsTo']; @endphp
											{{ $otherAssetsdtls[$i]['familyName'] }}
										</td>
										<td class="text-right" style="background-color: #c7e1f7;">
											{{ number_format((float)$otherAssetsMnthWiseTotal[$request->selMonth][$tempMnthBelongsTo], 1) }}
										</td>
										<td colspan="2" style="background-color: #c7e1f7;"></td>
									</tr>
								@endif
								<tr style = "<?php if ($otherAssetsdtls[$i]['editFlg'] == 1) { ?> color: red !important; <?php } ?> ">
									<td class="text-center">
										{{ $i + $userOtherAssetsDtls->firstItem() }}
									</td>
									<td class="text-left">
										@php 
											$datejp = date("d",strtotime($otherAssetsdtls[$i]['registerDate'])). "日" ; 
											$monthjp = date("m",strtotime($otherAssetsdtls[$i]['registerDate'])). "月" ; 
										@endphp
										{{$monthjp}}{{$datejp}}
									</td>
									<td class="text-left">
										{{ $otherAssetsdtls[$i]['assetsTypes']  }}
									</td>
									<td class="text-left">
										{{ $otherAssetsdtls[$i]['mainSubject']  }}
									</td>
									<td class="text-right">
										{{ number_format((float)$otherAssetsdtls[$i]['otherAssetsAmount'], 1)  }}
									</td>
									<td class="text-left">
										{{ $otherAssetsdtls[$i]['remarks']  }}
									</td>
									<td class="text-center">
										@php
											$month = date('m');
											$year = date('Y');
										@endphp
										<a href="javascript:fnEditOtherAssets('{{ $otherAssetsdtls[$i]['userId'] }}','{{ $request->selMonth }}','{{ $otherAssetsdtls[$i]['id'] }}');">
										<img title="{{ trans('messages.lbl_edit') }}" class=" box15" src="{{ URL::asset('public/images/Edit_new.png')}}"></a>
									</td>
								</tr>
							@endfor
							<tr style="background-color:#D3D3D3 !important;">
								<td colspan="3"></td>
								<td class="text-left">
									{{ trans('messages.lbl_tot') }}
								</td>
								<td class="fwb text-right">
									@php $totamount = $grantTotal[0]->SUM; @endphp
									@if($totamount != 0.0)
										{{ number_format((float)$totamount, 1) }}
									@endif
								</td>
								<td colspan="2"></td>
							</tr>
						@else
							<tr>
								<td class="text-center fr" colspan="7">
									{{ trans('messages.lbl_nodatafound') }}
								</td>
							</tr> 
						@endif
					</tbody>
				</table>
			@else
			<table class="table tablealter table-bordered table-striped">
				<colgroup>
					<col width="4%">
					<col width="4%">
					<col width="10%">
					<col width="10%">
					<col width="6%">
					<col width="6%">
					<col width="6%">
					<col width="6%">
					<col width="6%">
					<col width="6%">
					<col width="6%">
					<col width="6%">
					<col width="6%">
					<col width="6%">
					<col width="6%">
					<col width="6%">
				</colgroup>
				<thead class="CMN_tbltheadcolor">
					<th>{{ trans('messages.lbl_sno') }}</th>
					<th>{{ trans('messages.lbl_date') }}</th>
					<th>{{ trans('messages.lbl_assets') }}</th>
					<th>{{ trans('messages.lbl_main') }}</th>
					<th>1月</th>
					<th>2月</th>
					<th>3月</th>
					<th>4月</th>
					<th>5月</th>
					<th>6月</th>
					<th>7月</th>
					<th>8月</th>
					<th>9月</th>
					<th>10月</th>
					<th>11月</th>
					<th>12月</th>
				</thead>
				<tbody>
					@php $tempBelongsTo = ''; @endphp
					@php $tempMainBelongsTo = ''; @endphp
					@if(count($otherAssetsdtls) > 0 )
						@for ($i = 0; $i < count($otherAssetsdtls); $i++)
							@if($tempBelongsTo != $otherAssetsdtls[$i]['belongsTo'])
								<tr>
									<td colspan="4" style="background-color: #c7e1f7;">
										@php $tempBelongsTo = $otherAssetsdtls[$i]['belongsTo']; @endphp
										{{ $otherAssetsdtls[$i]['familyName'] }}
									</td>
									@for ($j = 1; $j <= count($otherAssetsMnth); $j++)
										<td class="fwb text-right" style="background-color: #c7e1f7;">
											@if($otherAssetsMnth[$j][$tempBelongsTo]['monthSUM'] != 0.0)
												{{ number_format((float)$otherAssetsMnth[$j][$tempBelongsTo]['monthSUM'], 1) }}
											@endif
										</td>
									@endfor
								</tr>
							@endif
							<tr>
								<td class="text-center" >
									{{ $i + $userOtherAssetsDtls->firstItem() }}
								</td>
								<td class="text-left">
									@php 
										$datejp = date("d",strtotime($otherAssetsdtls[$i]['registerDate'])). "日" ; 
									@endphp
									{{$datejp}}
								</td>
								<td class="text-left">
									{{ $otherAssetsdtls[$i]['assetsTypes']  }}
								</td>
								<td class="text-left">
									{{ $otherAssetsdtls[$i]['mainSubject']  }}
								</td>
								@for ($l = 1; $l <= 12; $l++)
									<td class="fwb text-right">
										@php
											$month = date('m');
											$year = date('Y');
										@endphp
										<span style = "<?php if ($otherAssetsdtls[$i][$l]['editFlg'] == 1) { ?> color: red !important; <?php } ?> ">
											@if($otherAssetsdtls[$i][$l]['monthSubSUM'] != 0.0)
												{{ number_format((float)$otherAssetsdtls[$i][$l]['monthSubSUM'], 1) }}
											@else
												{{ $otherAssetsdtls[$i][$l]['monthSubSUM'] }}
											@endif
										</span>
									</td>
								@endfor
							</tr>
						@endfor
						<tr style="background-color:#D3D3D3 !important;">
							<td></td>
							<td colspan="3" class="text-right">
								{{ trans('messages.lbl_tot') }}
							</td>
							@for ($j = 1; $j <= count($otherAssetsMnth); $j++)
								<td class="fwb text-right">
									@if($otherAssetsMnth[$j]['monthSUM'] != 0.0)
										{{ number_format((float)$otherAssetsMnth[$j]['monthSUM'], 1) }}
									@endif
								</td>
							@endfor
						</tr>
					@else
						<tr>
							<td class="text-center fr" colspan="16">
								{{ trans('messages.lbl_nodatafound') }}
							</td>
						</tr> 
					@endif
				</tbody>
			</table>
			@endif
		</ul>
	</div>

	{{ Form::close() }}

	@if($userOtherAssetsDtls->total())
		<div class="text-center col-xs-12 pm0　mt50">
			@if(!empty($userOtherAssetsDtls->total()))
				<span class="pull-left mt24">{{ $userOtherAssetsDtls->firstItem() }}
					<span class="mt5">～</span>
					{{ $userOtherAssetsDtls->lastItem() }} / {{ $userOtherAssetsDtls->total() }}
				</span>
			　@endif 
			{{ $userOtherAssetsDtls->links() }}
			<span class="pull-right">
				{{ $userOtherAssetsDtls->linkspagelimit() }}
			</span>
		</div>
	@endif 

	</article>
</div>
@endsection