@extends('templates.default')

@section('content')
	<h3>Sign Up</h3>
	<div class="row">
		<div class="col-lg-6">
			<form class="form-vertical" role="form" method="post" action="{{ route('auth.signup') }}">
				<div class="form-group">
					<label for="party" class="control-label">Choose a political party</label>
					<select name="party" class="form-control" id="party" value="{{ Request::old('party') ?: '' }}">
						<option value="other">–</option>
						<option value="democrat" style="color:#0015BC">Democrat</option>
						<option value="republican" style="color:#FF0000">Republican</option>
					</select>
				</div>
				<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
					<label for="username" class="control-label">Choose a username</label>
					<input type="text" name="username" class="form-control" id="username" value="{{ Request::old('username') ?: '' }}">
					@if ($errors->has('username'))
						<span class="help-block">{{ $errors->first('username') }}</span>
					@endif
				</div>
				<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
					<label for="first_name" class="control-label">First name</label>
					<input type="text" name="first_name" class="form-control" id="first_name" value="{{ Request::old('first_name') ?: '' }}">
					@if ($errors->has('first_name'))
						<span class="help-block">{{ $errors->first('first_name') }}</span>
					@endif
				</div>
				<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
					<label for="last_name" class="control-label">Last name</label>
					<input type="text" name="last_name" class="form-control" id="last_name" value="{{ Request::old('last_name') ?: '' }}">
					@if ($errors->has('last_name'))
						<span class="help-block">{{ $errors->first('last_name') }}</span>
					@endif
				</div>
				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					<label for="email" class="control-label">Your email address</label>
					<input type="text" name="email" class="form-control" id="email" value="{{ Request::old('email') ?: '' }}">
					@if ($errors->has('email'))
						<span class="help-block">{{ $errors->first('email') }}</span>
					@endif
				</div>
				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
					<label for="password" class="control-label" id="password">Choose a password</label>
					<input type="password" name="password" class="form-control" id="password">
					@if ($errors->has('password'))
						<span class="help-block">{{ $errors->first('password') }}</span>
					@endif
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-default">Sign Up</button>
				</div>
				<input type="hidden" name="_token" value="{{ Session::token() }}">
			</form>
		</div>
	</div>
@stop