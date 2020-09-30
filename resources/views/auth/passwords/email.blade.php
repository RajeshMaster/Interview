@extends('layouts.app')
<!-- Main Content -->
@section('content')
{{ HTML::style(asset('public/css/password.css')) }}
<div class="form-gap"></div>
<div class="container mw">
	<div class="row">
		<div class="col-xs-5 col-xs-offset-3">
			<div class="panel panel-default mt60">
				<div class="panel-body">
					<div class="col-xs-12">
						@if (session('status'))
							<div class="alert alert-success" align="center">
								{{ session('status') }}
							</div>
						@endif
					</div>
					<div class="text-center">
						<h3><img style="height: 90px;" src="{{ URL::asset('public/images/password.png') }}" /></h3>
						<h2 class="text-center">{{ trans('messages.lbl_forgotpassword')}}?</h2>
						<p>{{ trans('messages.lbl_passhere')}}</p>
						<div class="panel-body">
							<form class="form-horizontal" role="form" method="POST" action="{{ url('/Login/forgetprocess') }}" name = "forgetprocess" 
								id ="forgetprocess">
								{{ csrf_field() }}

								<div class="form-group">
									<div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
										<span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
										<input id="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address">
									</div>
									@if ($errors->has('email'))
										<span class="help-block" style="color: #a94442">
											<strong>{{ $errors->first('email') }}</strong>
										</span>
									@endif
								</div>
								<div class="form-group mt20">
									<button name="recover-submit" type="submit" class="btn btn-primary" value="Reset Password">{{ trans('messages.lbl_sendpwdlink')}}
									</button>
									<a onclick="javascript:return fncancelcheck('{{ url('/') }}','forgetprocess');" class="btn btn-danger box100" 
										style="text-decoration: none !important;">{{ trans('messages.lbl_cancel')}}</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection