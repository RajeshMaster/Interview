@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/user.js')) }}
<style type="text/css">
	.estStatusDIV_New_1 {
		color: #a1a1a1;
		text-align: center;
		-moz-border-radius: 2;
		-webkit-border-radius: 3px;
		font-size: 10px;
		margin-top: 3px;
		letter-spacing: .025em;
		font-family: verdana;
		text-transform: lowercase;
		font-weight: bold;
	}
	.colred {
		color: red;
	}
	/* Start Laptop screen Setting index page design */


	@media all and (max-width: 1200px) {
		.regdes{
			width:128%!important;
		}
		.h2cnt {
			font-size: 150%!important;
			margin-top: 3%!important;
		}
		.buttondes {
			font-size: 80%!important;
		}
		.col-xs-3 {
			 width:50%;
			 font-size:80%;
			 margin-left:-10%;
		}
		.col-xs-9 {
			width:50%;
		}
		.dispMainMobile {
			width:100%;
		}
		.dispSubMobile {
			width:100%;
		}
		
		.firstpre{
			width: 30%;
		}
	}
	/*End Mobile layout*/

	@media all and (min-width:1205px) {
		.settingdesign{
			margin-left: 15%!important;
		}
		.settingsubdesignfamily{
			margin-left: 21%!important;
		}
		.settingdesignright{
			margin-left: 7%!important;
		}
		.settingsubdesignright{
			margin-left: 13%!important;
		}
		.firstpre{
			width: 10%;
		}
	}
	/*End Laptop screen Setting index page design */
</style>
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
	function underconst() {
		alert("Under Construction");
	}
</script>
{{ Form::open(array('name'=>'frmuserindex',
		'id'=>'frmuserindex',
		'url' => 'user/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
		'files'=>true,
		'method' => 'POST')) }}
		{{ Form::hidden('editflg', '', array('id' => 'editflg')) }}
		{{ Form::hidden('filterval', $request->filterval, array('id' => 'filterval')) }}
		{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
		{{ Form::hidden('page', $request->page , array('id' => 'page')) }}
		{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
		{{ Form::hidden('id', '', array('id' => 'id')) }}
		{{ Form::hidden('sortOptn',$request->usersort , array('id' => 'sortOptn')) }}
		{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
		{{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
		{{ Form::hidden('viewid', '', array('id' => 'viewid')) }}
		{{ Form::hidden('userid', '', array('id' => 'userid')) }}
		{{ Form::hidden('delflag', '', array('id' => 'delflag')) }}
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="settings" class="DEC_flex_wrapper" data-category="settings setting_sub_2">
	<fieldset class="pm0 mt20">
		<div class="header">
			<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/employee.png')  }}">
			<h2 class="h2cnt">@if(Session::get('userclassification') == "4"){{ trans('messages.lbl_alluserlist') }}@else User Details
@endif</h2>
		</div>
	</fieldset>
	<div class="col-xs-12 pm0 pull-left mt5 mt13">
		<div class="pull-left">
			<button type="button" onclick="addedit();"
					class="button button-green pull-right">
				<span class="fa fa-plus"></span> {{ trans('messages.lbl_register')}}
			</button>
		</div>
		<div class="pull-left input-group mt6 filtermail">
			{{ Form::button(
							trans('messages.lbl_all'),
							array('class'=>'pageload btn btn-link '.$disabledall,
							'type'=>'button',
							'onclick' => 'javascript:return filter(1)')) 
			}}
			<span class = "filmail">|</span>
			{{ Form::button(
							trans('messages.lbl_unused'),
							array('class'=>'pageload btn btn-link '.$disabledunused,
							'type'=>'button',
							'onclick' => 'javascript:return filter(2)')) 
			}}
			<span class = "filmail">|</span>
			{{ Form::button(
							trans('messages.lbl_staff'),
							array('class'=>'pageload btn btn-link '.$disabledstaff,
							'type'=>'button',
							'onclick' => 'javascript:return filter(3)')) 
			}}
			<span class = "filmail">|</span>
			{{ Form::button(
							trans('messages.lbl_conEmployee'),
							array('class'=>'pageload btn btn-link '.$disabledcontract,
							'type'=>'button',
							'onclick' => 'javascript:return filter(4)')) 
			}}
			<span class = "filmail">|</span>
			{{ Form::button(
							trans('messages.lbl_subEmployee'),
							array('class'=>'pageload btn btn-link '.$disabledsubcontract,
							'type'=>'button',
							'onclick' => 'javascript:return filter(5)')) 
			}}
			<span class = "filmail">|</span>
			{{ Form::button(
							trans('messages.lbl_pvtPerson'),
							array('class'=>'pageload btn btn-link '.$disabledprivate,
							'type'=>'button',
							'onclick' => 'javascript:return filter(6)')) 
			}}
		</div>
	</div>
	<div class="box100per tableShrink pt10 mnheight mb0">
			<table class="table-striped table footable table-bordered mt10 mb10">
				<colgroup>
					<col class="firstpre" >
					<col width="">
				</colgroup>
				<thead class="CMN_tbltheadcolor" >
					<tr class="CMN_tbltheadcolor">
						<th class="tac fs10 sno">
							{{ trans('messages.lbl_usercode') }}
						</th>
						<th class="tac fs10">
							{{ trans('messages.lbl_Details') }}
						</th>
					</tr>
				</thead>
				<tbody class="tablealternateclr">
					@forelse ($userdetails as $count => $data)
						<tr>
							<td class="text-center vam">
								<div class="">
									@if($data->delflg == 0)
										<label class="pm0 vam colbl">
											{{ $data->usercode }}
										</label>
									@else
										<label class="pm0 vam colred">
											{{ $data->usercode }}
										</label>
									@endif
								</div>
								<div>
									<span class="estStatusDIV_New_1">
										@if($data->userclassification==0 && $data->delflg==0)
											{{trans('messages.lbl_staff')}} 
										@elseif($data->userclassification==1 && $data->delflg==0)
											{{trans('messages.lbl_conEmployee')}}
										@elseif($data->userclassification==2 && $data->delflg==0)
											{{trans('messages.lbl_subEmployee')}} 
										@elseif($data->userclassification==3 && $data->delflg==0)
											{{trans('messages.lbl_pvtPerson')}} 	
										@elseif($data->userclassification==4 && $data->delflg==0)
											{{trans('messages.lbl_superadmin')}} 
										@else
											{{trans('messages.lbl_unused')}} 
										@endif
									</span>
								</div>
							</td>
							<td>
								<div class="ml5 pt5 pb8">
									<div class="mb8">
										<b>{{$data->username}}@if(!empty($data->nickName)) ({{ $data->nickName }}) @endif</b>
									</div>
									<div class="f12 vam label_gray boxhei24">
										<span class="f12"> 
											{{ trans('messages.lbl_gender') }} :
										</span>
										<span class="f12">
											@if($data->gender == 1)
												{{ trans('messages.lbl_male') }}
											@else 
												{{ trans('messages.lbl_female')  }} 
											@endif
										</span>
										<span class="f12 ml20">
											{{ trans('messages.lbl_Creater') }} :
										</span>
										<span class="f12">
											{{ (!empty($data->UpdatedBy) ?  $data->UpdatedBy : "Nill")  }}
										</span>
									</div>
								</div>
								<div class="ml5 mb8 smallBlue CMN_display_block">
									<div class="CMN_display_block ml3">
										<a href="javascript:userview('{{ $data->id }}');" class="pageload">{{ trans('messages.lbl_Details') }}</a>&nbsp;@if(Session::get('userclassification') == "4")<span class="ml3">|</span>
									</div>
									<div class="CMN_display_block ml3">
										@if($data->delflg==1)
											<a href="javascript:fnchangeflag('{{ $data->id }}','{{ $data->delflg }}');" class="colbl">
												{{ trans('messages.lbl_use') }}
											</a>
										@else
											<a href="javascript:fnchangeflag('{{ $data->id }}','{{ $data->delflg }}');" class="colred">		{{trans('messages.lbl_notuse') }}
											</a> 
										@endif
									</div>
										@endif
								</div>
							</td>
						</tr>
					@empty
						<tr class="nodata">
							<th class="text-center red nodatades" colspan="2">
								{{ trans('messages.lbl_nodatafound') }}
							</th>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	@if($userdetails->total())
		<div class="text-center col-xs-12 pm0 pagealign">
			@if(!empty($userdetails->total()))
				<span class="pull-left mt24 pagination1">{{ $userdetails->firstItem() }}
					<span class="mt5 pagination2">～</span>
					{{ $userdetails->lastItem() }} / {{ $userdetails->total() }}
				</span>
			　@endif 
			<span class ="pagintion2">
			{{ $userdetails->links() }}
			</span>
			<span class="pull-right pagination mt0">
				{{ $userdetails->linkspagelimit() }}
			</span>
		</div>
	@endif 
	{{ Form::close() }}
</article>
</div>
@endsection