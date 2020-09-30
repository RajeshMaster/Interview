@extends('layouts.app')
@section('content')
{{ HTML::script(asset('public/js/bootstrap-show-password.min.js')) }}
<style type="text/css">
@media all and (max-width: 1200px) {
	.col-xs-8{
		width: 98%;
	}
	.col-xs-offset-2{
		 margin-left:1.33333333%
	}
	.col-xs-4{
		width:25%;
		font-size:80%;
	}
	.col-xs-6{
		width:75%;
	}
	.pwds{
		width:180px!important;
	}
}
</style>
<script>
	var mainmenu = '@php echo $request->menuid; @endphp';
	var datetime = '@php echo date("Ymdhis") @endphp';
</script>
<div class="" id="main_contents">
<!-- article to select the main&sub menu -->
<article id="profile" class="DEC_flex_wrapper" data-category="profile profile_sub_2">
<div class="container mwc" style="margin-top: 20px;">
	<div class="row">
		<div class="col-xs-8 col-xs-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading fwb fs22">{{ trans('messages.lbl_changePassword') }}</div>
					<div class="panel-body">
					@if (session('error'))
						<div class="alert alert-danger">
							{{ session('error') }}
						</div>
					@endif
						@if (session('success'))
							<div class="alert alert-success">
								{{ session('success') }}
							</div>
						@endif
						{{ Form::open(array('name'=>'resetForm', 'id'=>'resetForm', 'class'=>'focusFields',
									'url' => 'Auth/changePasswordprocess','method' => 'POST')) }}
						{{ csrf_field() }}
						<div class="col-xs-12">
							<label for="new-password" class="text-right col-xs-4 control-label clr_black">{{ trans('messages.lbl_currentpassword') }}</label>
							<div class="col-xs-6">
								<input type="password" id="current-password" name="current-password" class="form-control pwds" data-toggle="password" placeholder="Enter Current Password here" style="position: static;">
 								@if ($errors->has('current-password'))
									<span class="help-block" style="color: red;">
										<strong>{{ $errors->first('current-password') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="col-xs-12 mt10">
							<label for="new-password" class="col-xs-4 control-label text-right clr_black">{{ trans('messages.lbl_newpassword') }}</label>
 							<div class="col-xs-6">
								<input type="password" id="new-password" name="new-password" class="form-control pwds" data-toggle="password" placeholder="Enter New Password here" style="position: static;">
 								@if ($errors->has('new-password'))
									<span class="help-block" style="color: red;">
										<strong>{{ $errors->first('new-password') }}</strong>
									</span>
								@endif
							</div>
						</div>
 						<div class="col-xs-12 mt10">
							<label for="new-password-confirm" class="col-xs-4 control-label text-right clr_black">{{ trans('messages.lbl_confirmnewpassword') }}</label>
 							<div class="col-xs-6">
								<input type="password" id="new-password-confirm" name="new-password_confirmation" class="form-control pwds" data-toggle="password" placeholder="Enter Confirmed Password here" style="position: static;">
							</div>
						</div>
 						<div class="col-xs-12 mt10">
							<div class="col-xs-6 col-xs-offset-4">
								<button type="submit" class="btn btn-primary">
									{{ trans('messages.lbl_changePassword') }}
								</button>
							</div>
						</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>
</article>
</div>
@endsection