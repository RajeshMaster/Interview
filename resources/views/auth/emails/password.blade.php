<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.button {
		    border-radius: 3px;
		    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
		    color: #FFF;
		    display: inline-block;
		    text-decoration: none;
		    -webkit-text-size-adjust: none;
		}

		.button-blue {
		    background-color: #3097D1;
		    border-top: 10px solid #3097D1;
		    border-right: 18px solid #3097D1;
		    border-bottom: 10px solid #3097D1;
		    border-left: 18px solid #3097D1;
		}
		/* Subcopy */

		.subcopy {
		    border-top: 1px solid #EDEFF2;
		    margin-top: 25px;
		    padding-top: 25px;
		}

		.subcopy p {
		    font-size: 12px;
		}
	</style>
</head>
<body>
	<div style="height: 80px !important;width: auto;background-color: #D6E6F5;">
		<h1 style="vertical-align: middle;padding-left: 330px !important;padding-top: 25px !important;">Asset MANAGEMENT SYSTEM</h1>
	</div>
	<div style="height: 50px !important;">
		<h2 style="padding-left: 300px !important;">
			Hello !
		</h2>
	</div>
	</n>
	</n>
	<div style="height: 50px !important;">
		<span style="padding-left: 300px !important;">
			You are receiving this email because we received a password reset </n> request for your account.
		</span>
	</div>
	</n>
	</n>
	</n>
	<div style="height: 70px !important;">
		<span style="padding-left: 400px !important;">
			<a class="button button-blue" href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">Reset Password</a>
		</span>
	</div>
	</n>
	</n>
	</n>
	<div style="height: 50px !important;">
		<span style="padding-left: 300px !important;">
			If you did not request a password reset, no further action is required.
		</span>
	</div>
	</n>
	<div style="height: 20px !important;">
		<span style="padding-left: 300px !important;">
			Regards,
		</span>
	</div>
	</n>
	<div style="height: 20px !important;">
		<span style="padding-left: 300px !important;">
			Admin
		</span>
	</div>
	</n>
	</br>
	<div class="subcopy">
		
	</div>
	<div style="height: 40px !important;">
		<span>
			If you’re having trouble clicking the "Reset Password" button, copy and paste </n> the URL below into your web browser: <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
		</span>
	</div>
	</n>
	</n>
	</n>
	</n>
	<div style="height: 80px !important;width: auto;background-color: #D6E6F5;">
		<h5 style="vertical-align: middle;padding-left: 450px !important;padding-top: 30px !important;">© 2018 Microbit.Pvt.Ltd. All rights reserved.</h5>
	</div>
</body>
</html>