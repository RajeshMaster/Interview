@extends('layouts.app')
@section('content')
{{ HTML::style(asset('public/css/settinglayout.css')) }}
{{ HTML::style(asset('public/css/designtable.css')) }}
{{ HTML::style(asset('public/css/footable.core.css')) }}
{{ HTML::style(asset('public/css/tableviewlayout.css')) }}
{{ HTML::script(asset('public/js/footable.js')) }}
{{ HTML::script(asset('public/js/mailstatus.js')) }}
<style type="text/css">
/* Start Laptop screen Setting index page design */
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
}
/*End Laptop screen Setting index page design */
</style>
<script type="text/javascript">
	var mainmenu = '@php echo $request->mainmenu; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
	function pageClick(pageval) {
		$('#page').val(pageval);
		$('#mailSendfrm').attr('action', '../MailStatus/index'+'?mainmenu=menu_mail&time='+datetime);
		$("#mailSendfrm").submit();
	}
	function pageLimitClick(pagelimitval) {
		$('#page').val('');
		$('#plimit').val(pagelimitval);
		$('#mailSendfrm').attr('action', '../MailStatus/index'+'?mainmenu=menu_mail&time='+datetime);
		$("#mailSendfrm").submit();
	}

	function showbtn() {
		var array = []; 
		$("input:checked").each(function() { 
			array.push($(this).val()); 
		}); 
		if (array !="") {
			$('#postBtn').removeAttr("disabled")
		} else {
			$("#postBtn").attr('disabled','disabled');
		}
	}

	function postsendmail(datetime) {
		var array = []; 
		$("input:checked").each(function() {
			array.push($(this).val()); 
		}); 
		$('#selSendMail').val(array);
		if (array !="") {
			$('#mailSendfrm').attr('action', 'sendMailPost?mainmenu='+mainmenu+'&time='+datetime);
			$("#mailSendfrm").submit();
		} 
	}
</script>


{{ Form::open(array('name'=>'mailSendfrm',
		'id'=>'mailSendfrm',
		'url' => 'MailSend/index?mainmenu='.$request->mainmenu.'&time='.date('YmdHis'), 
		'method' => 'POST')) }}
	{{ Form::hidden('mainmenu', $request->mainmenu , array('id' => 'mainmenu')) }}
	{{ Form::hidden('filter', $request->filter, array('id' => 'filter')) }}
	{{ Form::hidden('clientFlg', '' , array('id' => 'clientFlg')) }}
	{{ Form::hidden('sorting', '' , array('id' => 'sorting')) }}
    {{ Form::hidden('sortOptn',$request->staffsort , array('id' => 'sortOptn')) }}
	{{ Form::hidden('sortOrder', $request->sortOrder , array('id' => 'sortOrder')) }}
	{{ Form::hidden('searchmethod', $request->searchmethod, array('id' => 'searchmethod')) }}
	{{ Form::hidden('editflg', '' , array('id' => 'editflg')) }}
	{{ Form::hidden('empId', '' , array('id' => 'empId')) }}
	{{ Form::hidden('interviewId', '' , array('id' => 'interviewId')) }}
	{{ Form::hidden('plimit', $request->plimit , array('id' => 'plimit')) }}
    {{ Form::hidden('page', $request->page , array('id' => 'page')) }}
    {{ Form::hidden('selSendMail', '', array('id' => 'selSendMail')) }}
<div class="" id="main_contents">
	<article id="mail" class="DEC_flex_wrapper" data-category="mail mail_sub_4">
		<!-- Start Heading -->
		<fieldset class="pm0 mt20">
			<div class="header">
				<img class="headerimg box40 imgviewheight" src="{{ URL::asset('public/images/sentmail.png')  }}">
				<h2 class="pull-left pl5 mt10">{{ trans('messages.lbl_sendMail') }}</h2>
				</h2>
			</div>
		</fieldset>

		@if (session('danger'))
			<div class="col-xs-12 mt10" align="center">
				<span class="alert-danger">{{ session('danger') }}</span>
			</div>
		@endif

		<!-- End Heading -->
		<a disabled="disabled" class="btn btn-success box70 mt10" id="postBtn" href="javascript:postsendmail(datetime);" style="float: right;" class="pl10 pb5">Post</a>

		<div class="box100per tableShrink pt10 mnheight mb0">
		<table class="table-striped table footable table-bordered mt10 mb10" >
			<colgroup>
				<col width="4%">
				<col width="10%">
				<col width="70%">
			</colgroup>
			<thead class="CMN_tbltheadcolor" >
				<tr class="CMN_tbltheadcolor">
					<th class="tac fs10 sno">
						{{ trans('messages.lbl_sno') }}
					</th>
					<th class="tac fs10">
						{{ trans('messages.lbl_empid') }}
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_empdetails') }}
					</th>
					<th data-hide="phone" class="tac fs10">
					</th>
					<th data-hide="phone" class="tac fs10">
						{{ trans('messages.lbl_doj') }}
					</th>
				</tr>
			</thead>
			<tbody class="tablealternateclr">
				@if(count($empdetailsdet)!="")
					@for ($i = 0; $i < count($empdetailsdet); $i++)
					<tr>
						<td class="text-center vam">
							<Input type = 'Checkbox' onchange="showbtn()" Name = '<?php echo $empdetailsdet[$i]['Emp_ID']; ?>' id='<?php echo $empdetailsdet[$i]['Emp_ID']; ?>' value ='<?php echo $empdetailsdet[$i]['Emp_ID']; ?>'>
						</td>
						<td>
							<div class="tac">
								<label>
									<a href="javascript:employeeview('{{ $empdetailsdet[$i]['Emp_ID'] }}');" style="color:blue;" class="vam ml18">
										{{ $empdetailsdet[$i]['Emp_ID'] }}
									</a>
								<br>
								{{--*/ $file_exist = "../../uploads/profile/original/" . $empdetailsdet[$i]['Picture']; /*--}}
								{{--*/ $filename = $disPath . $empdetailsdet[$i]['Picture']; /*--}}
								@if (!file_exists($filename))
									{{--*/ $empdetailsdet[$i]['Picture'] = ""; /*--}}
								@endif

								@if($empdetailsdet[$i]['Picture'] != "")
									{{--*/ $src = $file_exist; /*--}}
								@else
									@if($empdetailsdet[$i]['Gender'] == 1)
										{{--*/ $src = $noimage . '/no-prof-male.JPG'; /*--}}
									@else
										{{--*/ $src = $noimage . '/no-prof-female.jpg'; /*--}}
									@endif
								@endif
								<!-- <div style="border: 2px solid red;text-align: center;"> -->
									<img class="pull-left box70 ml20 tac" src="{{ $src }}" width="90" height = "70"></img>
								<!-- </div> -->
								</label>
							</div>
						</td>

						<td>
							<div class="ml5">
								<div>　
									<span class="fll">
										{{ $empdetailsdet[$i]['FirstName'] }}
									</span>
									<span class="fwb" style="margin-left: -10px">
										{{ $empdetailsdet[$i]['LastName'] }}
									</span>
									<span class="">
										@if($empdetailsdet[$i]['nickname'] != "" )
											({{ $empdetailsdet[$i]['nickname'] }} )
										@endif
									</span>
									<span class="" style="float: right">

									</span>
									@if($empdetailsdet[$i]['KanaFirstName'] != "" && $empdetailsdet[$i]['KanaLastName'] != "")
										<div>　
											<span class="fll">
												{{ $empdetailsdet[$i]['KanaFirstName'] }}
											</span>
											<span class="fwb" style="margin-left: -10px">
												{{ $empdetailsdet[$i]['KanaLastName'] }}
											</span>
										</div>
									@endif

									<div>
										<span class="f28 clr_blue"> 
											{{ trans('messages.lbl_dob') }} :
										</span>
										<span class="f12"> 
											{{ $empdetailsdet[$i]['DOB'] }} <b>
											@if(!empty($empdetailsdet[$i]['DOB']))({{ birthday($empdetailsdet[$i]['DOB']) }})@endif</b>
										</span>
										<span class="f28 clr_blue">
											{{ trans('messages.lbl_mobileno') }} :
										</span>
										<span class="f12"> 
											{{ (!empty($empdetailsdet[$i]['Mobile1']) ?  $empdetailsdet[$i]['Mobile1'] : "Nill")  }}
										</span>
										<span class="f18 clr_blue">
											{{ trans('messages.lbl_email') }} :
										</span>
										<span class="f12"> 
											{{ $empdetailsdet[$i]['Emailpersonal'] }}
										</span>
									</div>

									<div>
										<span class="clr_blue">{{ trans('messages.lbl_streetaddress') }}</span> :
										<span class="f12"> 
											{{ (!empty($empdetailsdet[$i]['Address1']) ?  $empdetailsdet[$i]['Address1'] : "Nill")  }}
										</span>
									</div>

									<div>
										<span class="clr_blue">{{ trans('messages.lbl_customer') }}</span> :
										<span class="f12"> 
										{{ (!empty($empdetailsdet[$i]['customer_name']) ?  $empdetailsdet[$i]['customer_name'] : "Nill")  }}
										</span>
									</div>

								<!-- 	<div class="mb4 CMN_display_block mt4">
										<div class="CMN_display_block">
											<a style="color:blue;" href="javascript:cushistory('{{ $empdetailsdet[$i]['Emp_ID'] }}','{{ $empdetailsdet[$i]['LastName'] }}');">{{ trans('messages.lbl_customer') }}</a>
										</div>
										&nbsp;|
										<div class="CMN_display_block">
											@if($empdetailsdet[$i]['clientStatus'] == 0 )
												<a style="color:blue;" href="javascript:workend('{{ $empdetailsdet[$i]['Emp_ID'] }}','{{ $empdetailsdet[$i]['LastName'] }}');">{{ trans('messages.lbl_work_date') }}</a>&nbsp;|
											@else
												{{ trans('messages.lbl_work_date') }}&nbsp;|
											@endif
										</div>

										<div class="CMN_display_block">
											<a style="color:blue;" href="javascript:uploadResume('{{ $empdetailsdet[$i]['Emp_ID'] }}','{{ $empdetailsdet[$i]['LastName'] }}');">{{ trans('messages.lbl_upResume') }}</a>&nbsp;|
										</div>

										<div class="CMN_display_block">
											<a style="color:blue;" href="javascript:resumeHistory('{{ $empdetailsdet[$i]['Emp_ID'] }}')">{{ trans('messages.lbl_cvHist') }}</a>
											
										</div>
									</div> -->

								</div>
							</div>
						</td>

						<td>
							@if($empdetailsdet[$i]['presentResume'] == 1 )
								{{--*/ $src = $noimage . '/pdf.png'; /*--}}
								<a href="javascript:downloadResume()" ><img class="pull-left box30 mr5  ml20" src="{{ $src }}" width="30" height = "30"></img>

								</a>
							@else
								{{--*/ $src = $noimage . '/nopdf.png'; /*--}}
								<img class="pull-left box30 mr5  ml20" src="{{ $src }}" width="30" height = "30"></img>
							@endif

						</td>

						<td class="tac">
							<div class="45px">
								<span>{{ $empdetailsdet[$i]['DOJ'] }}</span>
							</div>
							<div class="mt55">
								<span class="clr_blue">
									@if($empdetailsdet[$i]['experience'] > 1 )
										{{ $empdetailsdet[$i]['experience'] }} Yrs
									@elseif($empdetailsdet[$i]['experience'] <= 1 )
										{{ $empdetailsdet[$i]['experience'] }} Yr
									@else
										{{ 0 }} Yr
									@endif		
								</span>
							</div>
						</td>
					</tr>
					@endfor
				@else
				<tr class="nodata">
					<td class="text-center red nodatades1" colspan="5">
						{{ trans('messages.lbl_nodatafound') }}
					</td>
				</tr>
				@endif
			</tbody>
		</table>
	</div>
	
	</article>
</div>
{{ Form::close() }}
<script>
	$('.footable').footable({
		calculateWidthOverride: function() {
			return { width: $(window).width() };
		}
	}); 
</script>
@endsection