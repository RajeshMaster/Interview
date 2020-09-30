@extends('layouts.app')
@section('content')
@php use App\Http\Helpers @endphp
{{ HTML::script(asset('public/js/assets.js')) }}
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
	/* On small screens, set height to 'auto' for sidenav and grid */
	/*	@media screen and (max-width: 767px) {
		.sidenav {
			height: auto;
			padding: 15px;
		}
		.row.content {height: auto;} 
	}*/
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

	table { border-bottom: 1px solid #ddd ! important }
	table tbody tr { background-color: white !important; }
	.alternatebg_fam_color{background: #e5f4f9 !important;}
	.bor_rightbot_none {
		border-bottom: none ! important;
		border-top: none ! important;
	}
	.bor_none {border:none ! important; border-right: 1px solid #ddd ! important;}
	.vam {
		vertical-align: middle !important;
	}

</style>

<script type="text/javascript">
	var datetime = '<?php echo date('Ymdhis'); ?>';
</script>

<div class="" id="main_contents">
	<!-- article to select the main&sub menu -->
	<article id="balsheet" class="DEC_flex_wrapper" data-category="balsheet balsheet_sub_2">

	{{ Form::open(array('name'=>'Assetslistview',
			'id'=>'Assetslistview',
			'url' => 'Assets/listview?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
			'method' => 'POST')) }}
	{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
	{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
	{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
	{{ Form::hidden('pageview', $request->pageview , array('id' => 'pageview')) }}
	{{ Form::hidden('userId', $request->userId , array('id' => 'userId')) }}
	{{ Form::hidden('selMonth', $request->selMonth , array('id' => 'selMonth')) }}
    {{ Form::hidden('selYear', $request->selYear , array('id' => 'selYear')) }}
    {{ Form::hidden('editChk', $request->editChk , array('id' => 'editChk')) }}
	{{ Form::hidden('userId', $request->userId , array('id' => 'userId')) }}
	{{ Form::hidden('houseId', $request->houseId , array('id' => 'houseId')) }}
	{{ Form::hidden('monthSel', '' , array('id' => 'monthSel')) }}
	{{ Form::hidden('assetsId', '' , array('id' => 'assetsId')) }}
	<fieldset class="pm0 mt20">
		<div class="header">
			<img class="headerimg box40 mr10 imgviewheight" src="{{ URL::asset('public/images/loan.png')  }}">
			<h2 class="h2cnt">{{ trans('messages.lbl_assets') }}</h2>
		</div>
	</fieldset>

	<div class="mt20 mb10">
		{{ Helpers::displayYear($prev_yrs,$cur_year,$total_yrs,$curtime) }}
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
		<a href="javascript:assetsRegister();" 
			class="button button-green textDecNone">
			<span class="fa fa-plus"></span> {{ trans('messages.lbl_register') }}
		</a>
	</div>

	<div class="mt50">
		<ul class="list-group pm0 rowlist">
			<table class="table tablealter table-bordered">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="7%">
					<col width="7%">
					<col width="7%">
					<col width="7%">
					<col width="7%">
					<col width="7%">
					<col width="7%">
					<col width="7%">
					<col width="7%">
					<col width="7%">
					<col width="7%">
					<col width="7%">
				</colgroup>
				<thead class="CMN_tbltheadcolor">
					<th>{{ trans('messages.lbl_sno') }}</th>
					<th>{{ trans('messages.lbl_housename') }}</th>
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
					@php $tempHouse = ''; @endphp
					@php $tempMainHouse = ''; @endphp
					{{--*/ $mainSubtmp = '0' /*--}}
					{{--*/ $k = '0' /*--}}
					@if(count($assetsdtls) > 0 )
						@for ($i = 0; $i < count($assetsdtls); $i++)
							@if($mainSubtmp != $assetsdtls[$i]['belongsTo'])
								<tr>
									<td colspan="14" style="background-color: #c7e1f7;">
										@php $mainSubtmp = $assetsdtls[$i]['belongsTo']; @endphp
										{{ $assetsdtls[$i]['familyName'] }}
									</td>
								</tr>
							@endif
							@if($mainSubtmp != $assetsdtls[$i]['belongsTo'] || $tempMainHouse != $assetsdtls[$i]['houseId']) 
								@if($k == 0) 
									{{--*/ $style_tr = 'background-color: #FFFFFF !important;' /*--}}
									{{--*/ $k = 1 /*--}}
								@else
									{{--*/ $style_tr = 'background-color: #fff0e7e8 !important;' /*--}}
									{{--*/ $k = 0 /*--}}
								@endif
								{{--*/ $style_td = 'border-bottom: none;' /*--}}
								{{--*/ $disp_main_sub = $assetsdtls[$i]['houseName'] /*--}}
							@else
								{{--*/ $style_td = 'border-top: none;border-bottom: none;'/*--}}
								{{--*/ $disp_main_sub = $assetsdtls[$i]['houseName'] /*--}}
							@endif
							<tr style="{{ $style_tr }}">
								<td class="text-center" >
									{{ $i + $userPayAssetsDtls->firstItem() }}
								</td>
								<td style="{{$style_td}}">
									{{ $disp_main_sub }}
									{{--*/ $mainSubtmp = $assetsdtls[$i]['belongsTo'] /*--}}
									{{--*/ $tempMainHouse = $assetsdtls[$i]['houseId'] /*--}}
								</td>
								@for ($l = 1; $l <= 12; $l++)
									<td class="fwb text-right">
										@if($assetsdtls[$i][$l]['monthSubSUM'] != "")
											<a href="javascript:fnEditAssets('{{ $assetsdtls[$i]['userId'] }}','{{ $assetsdtls[$i]['houseId'] }}','{{ $l }}','{{ $assetsdtls[$i][$l]['assetsId'] }}');">
												{{ number_format($assetsdtls[$i][$l]['monthSubSUM']) }}
											</a>
										@endif
									</td>
								@endfor
							</tr>
						@endfor
						<tr style="background-color:#D3D3D3 !important;">
							<td class="fwb text-right">
							</td>
							<td colspan="1" class="text-center">
								{{ trans('messages.lbl_tot') }}
							</td>
							@for ($j = 1; $j <= count($assetsMnth); $j++)
								<td class="fwb text-right">
									{{ number_format($assetsMnth[$j]['monthSUM']) }}
								</td>
							@endfor
						</tr>
					@else
						<tr>
							<td class="text-center fr" colspan="14">
								{{ trans('messages.lbl_nodatafound') }}
							</td>
						</tr> 
					@endif
				</tbody>
			</table>
		</ul>
	</div>

	{{ Form::close() }}

	@if($userPayAssetsDtls->total())
		<div class="text-center col-xs-12 pm0　mt50">
			@if(!empty($userPayAssetsDtls->total()))
				<span class="pull-left mt24">{{ $userPayAssetsDtls->firstItem() }}
					<span class="mt5">～</span>
					{{ $userPayAssetsDtls->lastItem() }} / {{ $userPayAssetsDtls->total() }}
				</span>
			　@endif 
			{{ $userPayAssetsDtls->links() }}
			<span class="pull-right">
				{{ $userPayAssetsDtls->linkspagelimit() }}
			</span>
		</div>
	@endif 

	</article>
</div>

@endsection