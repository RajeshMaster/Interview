@extends('layouts.app')

@section('content')
{{ HTML::style(asset('public/css/password.css')) }}
{{ HTML::script(asset('public/js/bootstrap-show-password.min.js')) }}
<div class="form-gap"></div>
<div class="container mw">
	<div class="row">
		<div class="col-xs-5 col-xs-offset-3">
			<div class="panel panel-default mt60">
				<div class="panel-body">
					<div class="text-center">
						<h3><img style="height: 90px;" src="{{ URL::asset('public/images/password.png') }}" /></h3>
						<h2 class="text-center">{{ trans('messages.lbl_resetpassword')}}?</h2>
						<p>{{ trans('messages.lbl_passhere')}}</p>
						<div class="panel-body">
							{{ Form::open(array('name'=>'resetForm', 'id'=>'resetForm', 
							'url' => 'password/reset','method' => 'POST')) }}
								{{ csrf_field() }}
								{{ Form::hidden('token', $token, array('class' => 'form-control')) }}

							<div class="form-group">
								<div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
									<input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="Email Address">
									<span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
								</div>
								@if ($errors->has('email'))
									<span class="help-block" style="color: #a94442">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
							</div>
							<div class="form-group">
								<div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
									<input type="password" id="password" name="password" class="form-control pwds" data-toggle="password" placeholder="Password">
								</div>
								@if ($errors->has('password'))
									<span class="help-block" style="color: #a94442">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif
							</div>
							<div class="form-group">
								<div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
									<input type="password" id="password-confirm" name="password_confirmation" class="form-control pwds" data-toggle="password" placeholder="Password Confirm here">
								</div>
								@if ($errors->has('password_confirmation'))
									<span class="help-block" style="color: #a94442">
										<strong>{{ $errors->first('password_confirmation') }}</strong>
									</span>
								@endif
							</div>
							<div class="form-group mt20">
								<button type="submit" class="btn btn-primary resetpass">
									{{ trans('messages.lbl_resetpassword')}}
								</button>
							</div>
							{{ Form::close() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#password").password('toggle');
	$("#password-confirm").password('toggle');
</script>
</body>
</html>
@endsection