<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ trans('messages.lbl_interviewsys') }}</title>
	<link rel="icon" type="image/gif/png" href="{{ URL::asset('public/images/MB2.png') }}">
	{{ HTML::script(asset('public/js/jquery.min.js')) }}
	{{ HTML::script(asset('public/js/jquery.plugin.js')) }}
	{{ HTML::style(asset('public/css/paddingmargin.css')) }}
	{{ HTML::style(asset('public/css/decoration.css')) }}
	{{ HTML::style(asset('public/css/hoe.css')) }}
	{{ HTML::style(asset('public/css/common.css')) }}
	{{ HTML::style(asset('public/css/widthbox.css')) }}
	{{ HTML::style(asset('public/css/font-awesome.min.css')) }}
	{{ HTML::script(asset('public/js/bootstrap.min.js')) }}
	{{ HTML::style(asset('public/css/bootstrap.min.css')) }}
	{{ HTML::style(asset('public/css/style.css')) }}
	{{ HTML::style(asset('public/css/menu.css')) }}
	{{ HTML::style(asset('public/css/leftmenu.css')) }}
	{{ HTML::script(asset('public/js/common.js')) }}
	{{ HTML::script(asset('public/js/sweetalert.js')) }}
	{{ HTML::style(asset('public/css/sweetalert.css')) }}
	{{ HTML::script(asset('public/js/hoe.js')) }}
	{{ HTML::script(asset('public/js/jquery.form-validator.min.js')) }}
	{{ HTML::script(asset('public/js/header.js')) }}
	{{ HTML::style(asset('public/css/extra.css')) }}
	@if (Session::get('languageval') == 'en')
		{{ HTML::script(asset('public/js/english.js')) }}
	@elseif(empty(Session::get('languageval')))
		{{ HTML::script(asset('public/js/japanese.js')) }}
	@else
		{{ HTML::script(asset('public/js/japanese.js')) }}
	@endif
<script type="text/javascript">
	var datetime = <?php echo date('Ymdhis'); ?>;
	$(document).ready(function(){
		var menuselect = <?php echo json_encode((isset($request->mainmenu)?$request->mainmenu:'menu_admin')); ?>;
		$("#"+menuselect).addClass("active");
		$('.section').on('click', 'li a', function (e) {
			// e.preventDefault();
			$(this).closest('li').find('ul').slideToggle();
			$(this).closest('ul').siblings('.section').find('ul').slideUp();
		});
	});
	$(".leftsidenav a").click(function(){
	   $("a.active").removeClass("active");
	   $(this).addClass("active");
	});
	function alertindex() {
		alert("Under Construction");
	}
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	function openNav() {
		document.getElementById("mySidenav").style.width = "100px";
	}
	function closeNav() {
		document.getElementById("mySidenav").style.width = "0";
	}
	$(document).ready(function () {
		var trigger = $('.hamburger'),
			overlay = $('.overlay'),
			isClosed = false;
			trigger.click(function () {
			hamburger_cross();      
		});
		function hamburger_cross() {
			if (isClosed == true) {
				overlay.hide();
				trigger.removeClass('is-open');
				trigger.addClass('is-closed');
				isClosed = false;
			} else {   
				overlay.show();
				trigger.removeClass('is-closed');
				trigger.addClass('is-open');
				isClosed = true;
			}
		}
		$('[data-toggle="offcanvas"]').click(function () {
			$('#wrapper').toggleClass('toggled');
		});  
	});
</script>
<style>
.hamburger{
	display: none;
}
@media(max-width: 1200px){
	.main-menu{display: none;}
	#CMN_gmenu{display: none;}
	.sub_menu_size{display: none;}
		.hamburger {
		display: inline;
	}
}
.btmtotop{
	-webkit-animation: bar .3s linear;
	-o-animation: bar .3s linear;
	animation: bar .3s linear; 
}
@keyframes bar
{
  0% {
    top: 100%;
  }
  100% {
    top: 40%;
  }
}
.btmtotop1{
    -webkit-animation: bar .3s linear;
    -o-animation: bar .3s linear;
    animation: bar .3s linear;
}
@keyframes bar
{
  0% {
    top: 100%;
  }
  100% {
    top: 60%;
  }
}
.btn-default:hover{color:#00B2FF;background-color:#F8F8F8;border-color:#8c8c8c}
.btn-default.active,.btn-default:active,.open>.dropdown-toggle.btn-default{color:#00A2FF;background-color:#F0F0F0;border-bottom:2px solid #33AFFF !important;}
.btn-default.active.focus,.btn-default.active:focus,.btn-default.active:hover,.btn-default:active.focus,
.btn-default:active:focus,.btn-default:active:hover,
.open>.dropdown-toggle.btn-default.focus,
.open>.dropdown-toggle.btn-default:focus,
.open>.dropdown-toggle
.btn-default:hover{color:#00B2FF;background-color:#F8F8F8;border-color:#8c8c8c}
.dropdown-submenu {
	position: relative;
}
.stretch_body{min-width: 800px;}
.dropdown-submenu .dropdown-menu {
	top: 0;
	left: 100%;
	margin-top: -1px;
}
.loadinggif {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url({{ URL::asset('public/images/loader.gif') }}) center no-repeat;
	background-size: 10%;
	background-color: rgba(255, 255, 255, .5);
}
/* Start Toggle Button Hide / Show in Fraction Of Seconds Added By Bazith*/
#sidebar-wrapper {
    z-index: 999;
    left: 180px;
    width: 0;
    height: 100%;
    margin-left: -180px;
    overflow-y: auto;
    /*overflow-x: hidden;*/
    background: #D3D3D3;
    transition: width -7s;
}
#wrapper.toggled #sidebar-wrapper {
    width: 160px;
    transition: width -7s;
}
#wrapper.toggled {
    padding-left: 140px;
    transition: width -7s;
}
#wrapper {
    padding-left: 0;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: width -7s;
    /*ADDED BY Easa*/
    overflow-x: hidden;
}
@media (min-width:1200px) {
	nav button {
		border: none !important;
		border-radius: 0px !important;
		width: 100px !important;
	}
	nav a {
		border: none !important;
		/*text-align: right !important;*/
		text-decoration: none;
	}
	nav .btn_height{height: 73px !important;width: 90px!important;}
}
@media (min-width: 992px) {
	nav button {
		border: none !important;
	}   
	nav a {
		border: none !important;
	}
	nav .btn_height{height: 73px !important;width: 90px!important;}
}
@media (min-width: 768px) {
	nav button {
		border: none !important;
	}
	nav a {
		border: none !important;
	}
	nav .btn_height{height: 73px !important;width: 90px!important;}
}
html {
	/*display: table;*/
	margin: auto;
	padding: 0px;
}
body {
	/*display: table-cell;*/
	overflow-y: scroll;
	/*overflow-x: auto;*/
	vertical-align: middle;
	margin: auto;
	padding-right: 0px !important;
}
.whitespace_lr {
	width: 100%;
	border: 1px solid white;
}
.leftsidenav {
	height: 100%;
	width: 0;
	position: fixed;
	z-index: 1;
	top: 0;
	left: 0;
	background-color: #E6EEF2;
	border-right: 2px solid #5EC7BD;
	/*overflow-x: hidden;*/
	padding-top: 60px;
}
.leftsidenav a {
	padding: 8px 8px 8px 10px;
	text-decoration: none;
	font-size: 14px;
	/*background-color: #E6EEF2;*/
	color: black;
	display: block;
}
.hoverenable a:hover {
	/*border-bottom: 2px solid #33AFFF;*/
	color: #33AFFF;
	background-color: #E6EEF2;
	text-decoration: none !important;
}
/*.leftsidenav ul li {background-color: #5EC7BD;}*/
.leftsidenav .closebtn {
	position: absolute;
	top: 0;
	right: 5px;
	font-size: 26px;
	margin-left: 50px;
}
/*@media screen and (max-height: 450px) {
	.leftsidenav {padding-top: 15px;}
	.leftsidenav a {font-size: 18px;}
}*/
/*lap top double side width space  by Rajesh*/
/*@media (min-width: 1290px) {
	.whitespace_lr {
		width: 1270px;
		min-height: 200px !important ;
		border: 1px solid white;
		max-width: 1350px !important
	}
}*/
@media (max-width: 1000px) {
	.whitespace_lr {
		/*width: 1270px;*/
		min-height: 200px !important ;
		border: 1px solid white;
		max-width: 1350px !important
	}
}
.secondul{background-color: #E6EEF2 !important;}
.BB1{border-bottom: 1px solid #5fa4c6;}
.BT1{border-top: 1px solid #5fa4c6;}
#mybutton {
	position: fixed;
	bottom: 30px;
	right: 60px;
}
.badge-notify{
	background:red;
	position:absolute;
	top:0px;
	left: 50px;
}

/*ADDED BY Easa*/
#mySidenav .sidebar-nav li > a:hover{
	background-color:white;
}
#mySidenav .sidebar-nav li.active > a { 
	background-color: #3caadef0;
	color: black; 
} 
#mySidenav .dropdown-menu li.active > a { 
	background-color: #03a9f44f;  
	color: black;
} 
</style>
</head>
<body class="whitespace_lr pm0">
	<div class="CMN_menu_stretch" id="wrapper" style="padding: 0% 2% 0% 2% !important;">
		<!-- Header -->
		<header id="header" style="border-bottom: 1px solid #ddd !important;height:79px;margin-bottom: 10px;background-color: white;">
			<div class="container">
				@if(!empty(Auth::user()))
					<div class="navbar-header ml15">
				@else
					<div class="ml15">
				@endif
					<div class="loadinggif"></div>
					@if(!empty(Auth::user()))
						@if(Auth::user()->userType == 1)
						@endif
					@endif
					<!-- Logo -->
					<div class="navbar-brand" style="display: inline-block;">
						@if(!empty(Auth::user()))
							@if(Auth::user()->userType == 1)
								<a class="" href="{{ url('menu/index?mainmenu=home&time='.date('Ymdhis')) }}" style="text-decoration: none !important;">
									<img class="vam pl25 mt20 box80per" 
									src="{{ URL::asset('public/images/Microbit_logo.jpg') }}" />
								</a>
							@else
								 <a class="" href="{{ url('menu/index?mainmenu=home&time='.date('Ymdhis')) }}">
									<img class="vam mt20 box80per pl10" 
										src="{{ URL::asset('public/images/Microbit_logo.jpg') }}" />
								</a>
							@endif
						@else
							<a class="" style="cursor: default;">
								<img class="vam pl15 mt20 box90per" 
									src="{{ URL::asset('public/images/Microbit_logo.jpg') }}" />
							</a>
						@endif
					</div>
				</div>
				@if(Auth::user() != "")
				<div id="mySidenav" class="leftsidenav">
					<div class="overlay"></div>
					<a href="javascript:void(0)" class="closebtn secondul" style="color: red;" 
						onclick="closeNav()">&times;</a>
					<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" 
							role="navigation">
						<ul class="nav sidebar-nav">
							<li class="sidebar-brand">
								<a href="#" style="font-size: 25px;text-decoration: none !important;">
								  {{ trans('messages.lbl_interview') }}
								</a>
							</li>
							<li @if(isset($request->mainmenu) && 
									$request->mainmenu == "home") 
									class="dropdown active" 
								@endif>
								<a class="pageload" href="{{ url('menu/index?mainmenu=home&time='.date('Ymdhis')) }}" style="text-decoration: none !important;">
									{{ trans('messages.lbl_home') }}
								</a>
							</li>
							<li @if(isset($request->mainmenu) && 
									$request->mainmenu == "menu_employee") 
									class="dropdown active" 
								@endif>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" 
									style="text-decoration: none !important;">
									{{ trans('messages.lbl_employee') }}
									<span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li class="dropdown-header">&nbsp;&nbsp;{{ trans('messages.lbl_dropdown') }}</li>
									<li @if(isset($request->mainmenu) && 
											$request->mainmenu == "menu_employee") 
											class="active" 
										@endif>
										<a class="pageload" href="{{ url('Employee/index?mainmenu=menu_employee&time='.date('Ymdhis')) }}" 
										style="text-decoration: none !important;">&nbsp;&nbsp;
											{{ trans('messages.lbl_employee') }}</a>
									</li>
									<li @if(isset($request->mainmenu) && 
											$request->mainmenu == "menu_nonemployee") 
											class="active" 
										@endif>
										<a class="pageload" href="{{ url('NonEmployee/index?mainmenu=menu_nonemployee&time='.date('Ymdhis')) }}" style="text-decoration: none !important;">&nbsp;&nbsp;
											{{ trans('messages.lbl_nonEmployee') }}</a>
									</li>
									<li @if(isset($request->mainmenu) && 
											$request->mainmenu == "menu_yetTopay") 
											class="active" 
										@endif>
										<a class="pageload" href="{{ url('Employee/index?mainmenu=menu_employee&time='.date('Ymdhis')) }}" style="text-decoration: none !important;">&nbsp;&nbsp;
											{{ trans('messages.lbl_emphistory') }}</a>
									</li>
								</ul>
							</li>
							<li @if(isset($request->mainmenu) && 
									$request->mainmenu == "menu_mail" || $request->mainmenu == "menu_mailsignature" || $request->mainmenu == "menu_mailstatus" || $request->mainmenu == "menu_mailsend"  ) 
									class="dropdown active" 
								@endif>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" 
									style="text-decoration: none !important;">
									{{ trans('messages.lbl_mail') }}
									<span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li @if(isset($request->mainmenu) && 
											$request->mainmenu == "menu_mailsend") 
											class="active" 
										@endif>
										<a class="pageload" href="{{ url('MailSend/index?mainmenu=menu_mailsend&time='.date('Ymdhis')) }}"
										style="text-decoration: none !important;">&nbsp;&nbsp;
										{{ trans('messages.lbl_sendMail') }}</a>
									</li>
									<li @if(isset($request->mainmenu) && 
											$request->mainmenu == "menu_mailstatus") 
											class="active" 
										@endif>
										<a class="pageload" href="{{ url('MailStatus/index?mainmenu=menu_mailstatus&time='.date('Ymdhis')) }}"
										style="text-decoration: none !important;">&nbsp;&nbsp;
										{{ trans('messages.lbl_mailstatus') }}</a>
									</li>
									<li class="dropdown-header">&nbsp;&nbsp;{{ trans('messages.lbl_dropdown') }}</li>
									<li @if(isset($request->mainmenu) && 
											$request->mainmenu == "menu_mail") 
											class="active" 
										@endif>
										<a class="pageload" href="{{ url('Mail/index?mainmenu=menu_mail&time='.date('Ymdhis')) }}" style="text-decoration: none !important;">&nbsp;&nbsp;
										{{ trans('messages.lbl_mailcontent') }}</a>
									</li>
									<li @if(isset($request->mainmenu) && 
											$request->mainmenu == "menu_mailsignature") 
											class="active" 
										@endif>
										<a class="pageload" href="{{ url('MailSignature/index?mainmenu=menu_mailsignature&time='.date('Ymdhis')) }}" style="text-decoration: none !important;">&nbsp;&nbsp;
										{{ trans('messages.lbl_mailsignature') }}</a>
									</li>
								</ul>
							</li>
							<li @if(isset($request->mainmenu) && 
									$request->mainmenu == "menu_customer") 
									class="dropdown active" 
								@endif>
								<a href="{{ url('Customer/index?mainmenu=menu_customer&time='.date('Ymdhis')) }}" class="dropdown-toggle" data-toggle="dropdown" 
									style="text-decoration: none !important;">
									{{ trans('messages.lbl_customer') }}
									<span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li class="dropdown-header">&nbsp;&nbsp;{{ trans('messages.lbl_dropdown') }}</li>
									<li @if(isset($request->mainmenu) && 
											$request->mainmenu == "menu_customer") 
											class="active" 
										@endif>
										<a class="pageload" href="{{ url('Customer/index?mainmenu=menu_customer&time='.date('Ymdhis')) }}"
										style="text-decoration: none !important;">&nbsp;&nbsp;{{ trans('messages.lbl_customer') }}</a>
									</li>
									<li @if(isset($request->mainmenu) && 
											$request->mainmenu == "menu_agent") 
											class="active" 
										@endif>
										<a class="pageload" href="{{ url('Agent/index?mainmenu=menu_agent&time='.date('Ymdhis')) }}"
										style="text-decoration: none !important;">&nbsp;&nbsp;{{ trans('messages.lbl_agent') }}</a>
									</li>
									<li @if(isset($request->mainmenu) && 
											$request->mainmenu == "menu_oldcustomer") 
											class="active" 
										@endif>
										<a class="pageload" href="{{ url('OldCustomer/index?mainmenu=menu_oldcustomer&time='.date('Ymdhis')) }}"
										style="text-decoration: none !important;">&nbsp;&nbsp;{{ trans('messages.lbl_old_customer') }}</a>
									</li>
								</ul>
							</li>
							<li @if(isset($request->mainmenu) && 
									$request->mainmenu == "menu_setting" || $request->mainmenu == "menu_users" || $request->mainmenu == "menu_ourDetail") 
									class="dropdown active" 
								@endif>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-decoration: none !important;">{{ trans('messages.lbl_settings') }}<span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li class="dropdown-header">&nbsp;&nbsp;{{ trans('messages.lbl_dropdown') }}</li>
									<li @if(isset($request->mainmenu) && 
											$request->mainmenu == "menu_setting") 
											class="active" 
										@endif>
										<a class="pageload" href="{{ url('setting/index?mainmenu=menu_setting&time='.date('Ymdhis')) }}" style="text-decoration: none !important;">&nbsp;&nbsp;{{ trans('messages.lbl_settings') }}</a>
									</li>
									<li @if(isset($request->mainmenu) && 
											$request->mainmenu == "menu_users") 
											class="active" 
										@endif>
										<a class="pageload" href="{{ url('user/index?mainmenu=menu_users&time='.date('Ymdhis')) }}" style="text-decoration: none !important;">&nbsp;&nbsp;{{ trans('messages.lbl_user') }}</a>
									</li>
									<li @if(isset($request->mainmenu) && 
											$request->mainmenu == "menu_mailstatus") 
											class="active" 
										@endif>
										<a class="pageload" href="{{ url('OurDetail/index?mainmenu=menu_ourDetail&time='.date('Ymdhis')) }}" style="text-decoration: none !important;">&nbsp;&nbsp;{{ trans('messages.lbl_ourdetails') }}</a>
									</li>
									<li @if(isset($request->mainmenu) && 
											$request->mainmenu == "menu_mailstatus") 
											class="active" 
										@endif>
										<a class="pageload" href="{{ url('setting/index?mainmenu=menu_setting&time='.date('Ymdhis')) }}" style="text-decoration: none !important;">&nbsp;&nbsp;{{ trans('messages.lbl_japanese_skills') }}</a>
									</li>
								</ul>
							</li>
							<li @if(isset($request->mainmenu) && 
									$request->mainmenu == "menu_users1") 
									class="active dropdown"
								@endif>
								<a href="#" style="text-decoration: none !important;" class="dropdown-toggle" data-toggle="dropdown" style="text-decoration: none !important;">
									@if(strlen(session('FirstName')) > 10)
										<span style="font-size: 11px;"> {{ session('FirstName') }} </span>
									@else
										{{ session('FirstName') }}
									@endif
									<span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li class="dropdown-header">&nbsp;&nbsp;
										{{ trans('messages.lbl_dropdown') }}</li>
								 	<li class="pull-right">
									{{ Form::hidden('langvalue', Session::get('setlanguageval'), array('id' => 'langvalue')) }}
									@if (Session::get('setlanguageval') == 'en')
										<a name="Database" style="text-decoration: none !important;" id="Database"
										onclick="javascript:changelanguage();">
											&nbsp;&nbsp;{{ trans('messages.lbl_english') }}
										</a>
									@elseif(empty(Session::get('setlanguageval')))
										<a style="text-decoration: none !important;"　name="Database" id="Database"
											onclick="javascript:changelanguage();">
											&nbsp;&nbsp;{{ trans('messages.lbl_japanese') }}
										</a>
									 @else
										<a style="text-decoration: none !important;"　
											name="Database" id="Database"
											onclick="javascript:changelanguage();">
											&nbsp;&nbsp;{{ trans('messages.lbl_japanese') }}
										</a>
									@endif
									</li>
									<li>
										<a class="pageload" style="text-decoration: none !important;" href="{{ url('logout') }}">
										   &nbsp;&nbsp;{{ trans('messages.lbl_logout') }}
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</nav>
				</div>
				<!-- Navigation -->
				<nav id="nav">
					<ul class="main-menu nav navbar-nav navbar-right mr30 mt5 mb5">
						<li class="menu_btn_space">
							<div class="dropdown">
								<button id="menu_user" 
										class="btn btn-default btn_height dropdown-toggle box70per" 
										style="background-color: white;" 
										type="button" 
										data-toggle="dropdown">
								<img class="imgheight mt10" src="../public/images/logout.png" />
								<br>
								@if(strlen(session('FirstName')) > 10)
									<span style="font-size: 11px;"> {{ session('FirstName') }} </span>
								@else
									{{ session('FirstName') }}
								@endif
							</button>
							<ul class="dropdown-menu mob_border">
								<li class="mob_underline pull-right" 
									style = "text-align: right !important;text-decoration: none !important;">
									<a class = "btn btn-default mob_line pageload" 
										href = "{{ url('logout') }}">
									   {{ trans('messages.lbl_logout') }}
									</a>
								</li>
							</ul>
						</div>
						</li>
					</ul>
				</nav>
				<!-- main_tab -->
				<div class="CMN_header_wrap_wrap">
					<div class="CMN_header_wrap">
						<nav id="CMN_gmenu">
							<ul class="" style="padding: 0px;">
								<li class="btn_home jop_btn" style="">
									<a class="pageload" href="{{ url('menu/index?mainmenu=home&time='.date('Ymdhis')) }}" 
									style="text-decoration: none !important;">
									{{ trans('messages.lbl_home') }}</a>
								</li>
								<li class="btn_employee jop_btn" style="">
									<a class="pageload" href="{{ url('Employee/index?mainmenu=menu_employee&time='.date('Ymdhis')) }}" 
									style="text-decoration: none !important;">
									{{ trans('messages.lbl_employee') }}</a>
								</li>
								<li class="btn_mail jop_btn" style="">
									<a class="pageload" href="{{ url('MailSend/index?mainmenu=menu_mailsend&time='.date('Ymdhis')) }}" 
									style="text-decoration: none !important;">
									{{ trans('messages.lbl_mail') }}</a>
								</li>
								<li class="btn_customer jop_btn">
									<a class=""  href="{{ url('Customer/index?mainmenu=menu_customer&time='.date('Ymdhis')) }}"
										style="text-decoration: none !important;">
										{{ trans('messages.lbl_customer') }}
									</a>
								</li>
								<li class="btn_settings jop_btn">
									<a class="pageload" href="{{ url('setting/index?mainmenu=menu_setting&time='.date('Ymdhis')) }}"
										style="text-decoration: none !important;">
										{{ trans('messages.lbl_settings') }}
									</a>
								</li>
							</ul>
						</nav>
					</div>
					<!-- end_main_tab -->
					<!-- sub_tab -->
					<div class="sub_menu_size" style="font-weight: normal;">
						<!-- language_icon -->
						<div class="langIcon mt3" style="">
							{{ Form::hidden('langvalue', Session::get('setlanguageval'), array('id' => 'langvalue')) }}
							@if (Session::get('setlanguageval') == 'en')
								{!! Form::image('public/images/languageiconen.png', '', 
									array('class' => 'pull-right search box2per pr5 langimg11', 
										'onclick' => 'javascript:changelanguage()','style'=>'min-width:35px;cursor:pointer;')) !!}
							@elseif(empty(Session::get('setlanguageval')))
								{!! Form::image('public/images/languageiconjp.png', '', 
									array('class' => 'pull-right search box2per pr5 langimg11', 
									'onclick' => 'javascript:changelanguage();','style'=>'min-width:35px;cursor:pointer;')) !!}
							 @else
								{!! Form::image('public/images/languageiconjp.png', '', 
									array('class' => 'pull-right search box2per pr5 langimg11', 
										'onclick' => 'javascript:changelanguage()','style'=>'min-width:35px;cursor:pointer;')) !!}
							@endif
						</div>
						<div id="AssetDiv" class="CMN_sub_gmenu">
							@if(isset($request->mainmenu) && $request->mainmenu == "home")
								<div id="home_sub_1">
									<a class="pageload" href="{{ url('menu/index?mainmenu=home&time='.date('Ymdhis')) }}">
									{{ trans('messages.lbl_home') }}</a>
								</div>
							@endif
							@if(isset($request->mainmenu) && ($request->mainmenu == "menu_employee" || $request->mainmenu == "menu_nonemployee"))
								<div id="emp_sub_1">
									<a class="pageload" href="{{ url('Employee/index?mainmenu=menu_employee&time='.date('Ymdhis')) }}">
									{{ trans('messages.lbl_employee') }}</a>
								</div>
								<div id="emp_sub_2">
									<a class="" href="{{ url('NonEmployee/index?mainmenu=menu_nonemployee&time='.date('Ymdhis')) }}">
									{{ trans('messages.lbl_nonEmployee') }}</a>
								</div>
								<div id="emp_sub_3">
									<a class="" href="#">
									{{ trans('messages.lbl_emphistory') }}</a>
								</div>
							@endif
							@if(isset($request->mainmenu) && ($request->mainmenu == "menu_mail" || $request->mainmenu == "menu_mailsignature" || $request->mainmenu == "menu_mailstatus" || $request->mainmenu == "menu_mailsend"))
								<div id="mail_sub_4">
									<a class="pageload" href="{{ url('MailSend/index?mainmenu=menu_mailsend&time='.date('Ymdhis')) }}">
									{{ trans('messages.lbl_sendMail') }}</a>
								</div>
								<div id="mail_sub_3">
									<a class="pageload" href="{{ url('MailStatus/index?mainmenu=menu_mailstatus&time='.date('Ymdhis')) }}">
									{{ trans('messages.lbl_mailstatus') }}</a>
								</div>
								<div id="mail_sub_1">
									<a class="pageload" href="{{ url('Mail/index?mainmenu=menu_mail&time='.date('Ymdhis')) }}">
									{{ trans('messages.lbl_mailcontent') }}</a>
								</div>
								<div id="mail_sub_2">
									<a class="pageload" href="{{ url('MailSignature/index?mainmenu=menu_mailsignature&time='.date('Ymdhis')) }}">
									{{ trans('messages.lbl_mailsignature') }}</a>
								</div>
							@endif
							@if(isset($request->mainmenu) && ($request->mainmenu == "menu_customer" || $request->mainmenu == "menu_oldcustomer" || $request->mainmenu == "menu_agent"))
							<div id="cus_sub_1">
								<a class="pageload" href="{{ url('Customer/index?mainmenu=menu_customer&time='.date('Ymdhis')) }}">
								{{ trans('messages.lbl_customer') }}</a>
							</div>
							<div id="cus_sub_2">
								<a class="pageload" href="{{ url('Agent/index?mainmenu=menu_agent&time='.date('Ymdhis')) }}">
								{{ trans('messages.lbl_agent') }}</a>
							</div>
							<div id="cus_sub_3">
								<a  href="{{ url('OldCustomer/index?mainmenu=menu_oldcustomer&time='.date('Ymdhis')) }}">
								{{ trans('messages.lbl_old_customer') }}</a>
							</div>
							@endif
							@if(isset($request->mainmenu) && 
								$request->mainmenu == "menu_userlist")
								<div id="userlist_sub_1">
									<a class="pageload" href="{{ url('User/index?mainmenu=menu_userlist&time='.date('Ymdhis')) }}" 
										style="text-decoration: none !important;">
									{{ trans('messages.lbl_user') }}</a>
								</div>
							@endif
							@if(isset($request->mainmenu) && 
								$request->mainmenu == "menu_setting" || $request->mainmenu == "menu_users" || $request->mainmenu == "menu_ourDetail")
								<div id="setting_sub_1">
									<a class="pageload" href="{{ url('setting/index?mainmenu=menu_setting&time='.date('Ymdhis')) }}" 
										style="text-decoration: none !important;">
									{{ trans('messages.lbl_settings') }}</a>
								</div>
								<div id="setting_sub_2">
									<a class="pageload" href="{{ url('user/index?mainmenu=menu_users&time='.date('Ymdhis')) }}" 
										style="text-decoration: none !important;">
									{{ trans('messages.lbl_user') }}</a>
								</div>
								<div id="setting_sub_3">
									<a class="pageload" href="{{ url('OurDetail/index?mainmenu=menu_ourDetail&time='.date('Ymdhis')) }}" 
										style="text-decoration: none !important;">
									{{ trans('messages.lbl_ourdetails') }}</a>
								</div>
								<div id="setting_sub_1">
									<a class="pageload" href="{{ url('setting/index?mainmenu=menu_setting&time='.date('Ymdhis')) }}" 
										style="text-decoration: none !important;">
									{{ trans('messages.lbl_japanese_skills') }}</a>
								</div>
							@endif
						</div>
					</div>
				</div>
				@endif
				<!-- /Navigation -->
			</div>
		</header>
		{{ HTML::script(asset('public/js/main.js')) }}
		<div class="col-xs-12">
			@if(!empty(Auth::user()))
				<button type="button" class="hamburger is-closed" data-toggle="offcanvas">
					<span class="hamb-top"></span>
					<span class="hamb-middle"></span>
					<span class="hamb-bottom"></span>
				</button>
			@endif
			@yield('content')
		</div>
	</div>
</body>
</html>
<style type="text/css">
</style>