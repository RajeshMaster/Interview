@extends('layouts.layout')
@section('content')
{{ HTML::style(asset('public/css/layout.css')) }}
{{ HTML::style(asset('public/css/bootstrap.min.css')) }}
{{ HTML::style(asset('public/css/font-awesome.min.css')) }}
{{ HTML::style(asset('public/css/paddingmargin.css')) }}
{{ HTML::script(asset('public/js/bootstrap.min.js')) }}
{{ HTML::style(asset('public/css/common.css')) }}
{{ HTML::script(asset('public/js/user.js')) }}
{{ HTML::script(asset('public/js/common.js')) }}
<style type="text/css">
	#slideshow .one {
		background-image: url('public/images/dots.png');
		background-repeat: no-repeat;
		background-position: 0% 50%;
	}
	#slideshow .two {
		background-image: url("public/images/gears.png");
		background-repeat: no-repeat;
		background-position: 0% 50%;
	}
</style>
<script type="text/javascript">
	var datetime = '@php echo date("Ymdhis") @endphp';
	var mainmenu = '@php echo $request->mainmenu @endphp';
	// To set Default focus
	window.onload = function() {
		if ($("#userId").val() == "") {
			$("#userId").focus();
		} else if ($("#password").val() == "") {
			 $("#password").focus();
		}
		$('#slideshow > div:gt(0)').hide();
		setInterval(function() {
			$('#slideshow > div:first')
			.fadeOut(1000)
			.next()
			.fadeIn(1000)
			.end()
			.appendTo('#slideshow');
		}, 3850);
	};
	$(document).ready(function() {
		var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        $('#timezone').val(timezone);
	});
</script>
<!-- LOGIN MODULE -->
<div class="login">
	<div class="wrap">
		<!-- TOGGLE -->
		<div id="toggle-wrap">
			<div id="toggle-terms">
				<div id="cross">
					<span></span>
					<span></span>
				</div>
			</div>
		</div>
		<!-- SLIDER -->
		<div class="content">
			<!-- LOGO -->
			<div class="logo" style="width: 10%;">
				<a href="{{ url('/login') }}"><img src="public/images/MB.png"></a>
			</div>
			<!-- SLIDESHOW -->
			<div id="slideshow">
				<div class="one">
					<h2><span>About us</span></h2>
					<p>Microbit Pvt Ltd is a Japan based software company, which has skills and expertise to facilitate complex business solutions.</p>
				</div>
				<div class="two">
					<h2><span>Contact</span></h2>
					<p>
						株式会社 Microbit
						大阪市淀川区西中島5丁目6-3-305号
						Tel: 06-6305-1251Fax: 06-6305-1250
					</p>
				</div>
			</div>
		</div>
		<!-- LOGIN FORM -->
		<div class="user">
			<div class="form-wrap">
				@if(Session::has('message'))
					<div class="col-xs-12" align="center">
						<span class="{{ Session::get('alert', Session::get('type') ) }}">
						{{ session('message') }}</span>
					</div>
				@endif
				@php Session::forget('message'); @endphp
				<!-- TABS -->
				<div class="tabs">
					<h3 class="login-tab"><span>Login<span></h3>
				</div>
				<!-- TABS CONTENT -->
				<div class="tabs-content">
					<!-- TABS CONTENT LOGIN -->
					<div id="login-tab-content" class="active">
						<form class="form-horizontal" id="loginForm" name="loginForm" role="form" method="POST" action="{{ url('/login') }}">
							{{ csrf_field() }}
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="timezone" id="timezone" value="">
							<input type="text" class="input" name="userid" id="userid" 
							placeholder = "Email / User Id" value="{{ old('userid') }}">
							@if ($errors->has('userid'))
								<span class="help-block" style="color: red;">
									<strong>{{ $errors->first('userid') }}</strong>
								</span>
							@endif
							<input type="password" class="input" name="password" id="password" placeholder="Password">
							@if ($errors->has('password'))
								<span class="help-block" style="color: red;">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
							<div class="mt5">
								<label>
									{{ Form::checkbox('remember',null, null, ['class' => 'field']) }} 
									 Remember me
								</label>
							</div>
							<div class="help-action pm0">
								<p><i class="fa fa-arrow-left" aria-hidden="true"></i><a class="" href="{{ url('/Login/forgetpassword?time='.date('YmdHis')) }}">
								Forgot your password?</a></p>
							</div>
							<button type="submit" class="button" style="font-size: 15px;padding-bottom: 0px;">
								Login
							</button>
						</form>
						<!-- Session msg -->
						@if(Session::has('error'))
						<div align="center" class="" style="color: red;height: 50px;">
							<p class="alert {{ Session::get('alert', Session::get('error') ) }}">
							  {{ Session::get('error') }}
							</p>
						</div>
						@endif
						<!-- Session msg -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	/* LOGIN - MAIN.JS - dp 2017 */
	// LOGIN TABS
	$(function() {
		var tab = $('.tabs h3 a');
		tab.on('click', function(event) {
			event.preventDefault();
			tab.removeClass('active');
			$(this).addClass('active');
			tab_content = $(this).attr('href');
			$('div[id$="tab-content"]').removeClass('active');
			$(tab_content).addClass('active');
		});
	});
	// SLIDESHOW
	$(function() {
		$('#slideshow > div:gt(0)').hide();
		setInterval(function() {
			$('#slideshow > div:first')
			.fadeOut(1000)
			.next()
			.fadeIn(1000)
			.end()
			.appendTo('#slideshow');
		}, 3850);
	});
	// CUSTOM JQUERY FUNCTION FOR SWAPPING CLASSES
	(function($) {
		'use strict';
		$.fn.swapClass = function(remove, add) {
			this.removeClass(remove).addClass(add);
			return this;
		};
	}(jQuery));
	// SHOW/HIDE PANEL ROUTINE (needs better methods)
	// I'll optimize when time permits.
	$(function() {
		$('.agree,.forgot, #toggle-terms, .log-in, .sign-up').on('click', function(event) {
			event.preventDefault();
			var terms = $('.terms'),
			recovery = $('.recovery'),
			close = $('#toggle-terms'),
			arrow = $('.tabs-content .fa');
			if ($(this).hasClass('agree') || $(this).hasClass('log-in') || ($(this).is('#toggle-terms')) && terms.hasClass('open')) {
				if (terms.hasClass('open')) {
					terms.swapClass('open', 'closed');
					close.swapClass('open', 'closed');
					arrow.swapClass('active', 'inactive');
				} else {
					if ($(this).hasClass('log-in')) {
						return;
					}
					terms.swapClass('closed', 'open').scrollTop(0);
					close.swapClass('closed', 'open');
					arrow.swapClass('inactive', 'active');
				}
			}
			else if ($(this).hasClass('forgot') || $(this).hasClass('sign-up') || $(this).is('#toggle-terms')) {
				if (recovery.hasClass('open')) {
					recovery.swapClass('open', 'closed');
					close.swapClass('open', 'closed');
					arrow.swapClass('active', 'inactive');
				} else {
					if ($(this).hasClass('sign-up')) {
						return;
					}
					recovery.swapClass('closed', 'open');
					close.swapClass('closed', 'open');
					arrow.swapClass('inactive', 'active');
				}
			}
		});
	});
	// DISPLAY MSSG
	$(function() {
		$('.recovery .button').on('click', function(event) {
			event.preventDefault();
			$('.recovery .mssg').addClass('animate');
			setTimeout(function() {
				$('.recovery').swapClass('open', 'closed');
				$('#toggle-terms').swapClass('open', 'closed');
				$('.tabs-content .fa').swapClass('active', 'inactive');
				$('.recovery .mssg').removeClass('animate');
			}, 2500);
		});
	});
	// FOR After Logout Not go back...
	var e = location.pathname.split("/").pop();
	history.pushState(null, null, e);
	window.addEventListener('popstate', function(event) {
		history.pushState(null, null, e);
	});
</script>
@endsection