@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-6">
			<h3>Your followers</h3>
			@if (!$friends->count())
				<p>You are not following anyone</p>
			@else
				@foreach ($friends as $user)
					@include('user/partials/userblock')
				@endforeach
			@endif
		</div>
		<div class="col-lg-6">
			<h4>Follow requests</h4>

			@if (!$requests->count())
				<p>You have no follow requests</p>
			@else
				@foreach ($requests as $user)
					@include('user.partials.userblock')
				@endforeach
			@endif

		</div>
	</div>
@stop