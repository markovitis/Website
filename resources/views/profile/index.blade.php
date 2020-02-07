@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-5">
			@include('user.partials.userblock')
			<hr>

			@if (!$statuses->count())
				<p>There's nothing in {{ $user->username }}'s Feed yet.</p>
			@else
				@foreach ($statuses as $status)
					<div class="media">
						<a class="pull-left" href="{{ route('profile.index', ['username' => $status->user->username]) }}">
							<img class="media-object" alt="{{ $status->user->username }}" src="{{ $status->user->getAvatarUrl() }}">
						</a>
						<div class="media-body">
							<h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $status->user->username]) }}" style="color: {{ $status->user->colorizeByParty($status->user) }}">{{ $status->user->username }}</a> / {{ $status->user->party }}</h4>
							<p style="color: {{ $status->user->colorizeByParty($status->user) }}">{{ $status->body }}</p>
							<ul class="list-inline">
								<li>{{ $status->created_at->diffForHumans() }}</li>
								@if ($status->user->id !== Auth::user()->id)
									@if (!Auth::user()->hasLikedStatus($status))
										<li><a href="{{ route('status.like', ['statusId' => $status->id]) }}">▲</a></li>
									@else
										<li><p>ᐃ</p></li>
									@endif
								@else
									<li><p>ᐃ</p></li>
								@endif
								<li>@if ($status->likes->count() > 0)+@elseif ($status->likes->count() < 0)-@endif{{ $status->likes->count() }}</li>
								@if ($status->user->id !== Auth::user()->id)
									@if (!Auth::user()->hasUnlikedStatus($status))
										<li><a href="{{ route('status.unlike', ['statusId' => $status->id]) }}">▼</a></li>
									@else
										<li><p>ᐁ</p></li>
									@endif
								@else
									<li><p>ᐁ</p></li>
								@endif
							</ul>
							@foreach ($status->replies as $reply)
								<div class="media">
									<a class="pull-left" href="{{ route('profile.index', ['username' => $reply->user->username]) }}">
										<img class="media-object" alt="{{ $reply->user->username }}" src="{{ $reply->user->getAvatarUrl() }}">
									</a>
									<div class="media-body">
										<h5 class="media-heading"><a href="{{ route('profile.index', ['username' => $reply->user->username]) }}" style="color: {{ $reply->user->colorizeByParty($reply->user) }}">{{ $reply->user->username }}</a> / {{ $reply->user->party }}</h5>
										<p style="color: {{ $reply->user->colorizeByParty($reply->user) }}">{{ $reply->body }}</p>
										<ul class="list-inline">
											<li>{{ $reply->created_at->diffForHumans() }}</li>
											@if ($reply->user->id !== Auth::user()->id)
												@if (!Auth::user()->hasLikedStatus($reply))
													<li><a href="{{ route('status.like', ['statusId' => $reply->id]) }}">▲</a></li>
												@else
													<li><p>ᐃ</p></li>
												@endif
											@else
												<li><p>ᐃ</p></li>
											@endif
											<li>@if ($reply->likes->count() > 0)+@elseif ($reply->likes->count() < 0)-@endif{{ $reply->likes->count() }}</li>
											@if ($reply->user->id !== Auth::user()->id)
												@if (!Auth::user()->hasUnlikedStatus($reply))
													<li><a href="{{ route('status.unlike', ['statusId' => $reply->id]) }}">▼</a></li>
												@else
													<li><p>ᐁ</p></li>
												@endif
											@else
												<li><p>ᐁ</p></li>
											@endif
										</ul>
									</div>
								</div>
							@endforeach

							<!-- This limits responses only to friends. Turn off for Gugump build -->
							@if ($authUserIsFriend || Auth::user()->id === $status->user->id)
								<form role="form" action="{{ route('status.reply', ['statusId' => $status->id]) }}" method="post">
									<div class="form-group{{ $errors->has("reply-{$status->id}") ? ' has-error' : '' }}">
										<textarea name="reply-{{ $status->id }}" class="form-control" rows="2" placeholder="Reply to this status"></textarea>
										@if ($errors->has("reply-{$status->id}"))
											<span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
										@endif
									</div>
									<input type="submit" value="Reply" class="btn btn-default btn-sm">
									<input type="hidden" name="_token" value="{{ Session::token() }}">
								</form>
							@endif
						</div>
					</div>
				@endforeach
			@endif

		</div>
		<div class="col-lg-4 col-lg-offset-3">
			@if (Auth::user()->hasFriendRequestPending($user))
				<p>Waiting for {{ $user->username }} to accept your follow request</p>
			@elseif (Auth::user()->hasFriendRequestReceived($user))
				<a href="{{ route('friend.accept', ['username' => $user->username]) }}" class="btn btn-primary">Accept follow request</a>
			@elseif (Auth::user()->isFriendsWith($user))
				<p>You and {{ $user->username }} are following each other</p>

				<form action="{{ route('friend.delete', ['username'=> $user->username]) }}" method="post">
					<input type="submit" value="Unfollow" class="btn btn-primary">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				</form>

			@elseif (Auth::user()->id === $user->id)
				<p>This is your profile</p>
			@else
				<a href="{{ route('friend.add', ['username' => $user->username]) }}" class="btn btn-primary">Follow</a>
			@endif

			<h4>{{ $user->username }}'s followers</h4>

			@if (!$user->friends()->count())
				<p>{{ $user->username }} has no followers</p>
			@else
				@foreach ($user->friends() as $user)
					@include('user/partials/userblock')
				@endforeach
			@endif
		</div>
	</div>
@stop