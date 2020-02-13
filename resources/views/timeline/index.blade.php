@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-6">
			<form role="form" action="{{ route('status.post') }}" method="post">
				<div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
					<textarea placeholder="What do you want to talk about, {{ Auth::user()->getFirstNameOrUsername() }}?" name="status" class="form-control" rows="2"></textarea>
					@if ($errors->has('status'))
						<span class="help-block">{{ $errors->first('status') }}
					@endif
				</div>
				<button type="submit" class="btn btn-default" style="color:black; background-color:{{ Auth::user()->colorizeBlockByParty(Auth::user()) }}">Share with the Gugump Community</button>
				<input type="hidden" name="_token" value="{{ Session::token() }}">
			</form>
			<hr>			
		</div>
	</div>

	<div class="row">
		<div class="col-lg-5">
			<div><p>View by: <a href="{{ route('home') }}">Popular</a> / <a href="{{ route('home') }}">Recent</a> <span style="color:#e7e7e7">(doesn't work yet)</span></p></div>
			<br>
			@if (!$statuses->count())
				<p>There's nothing in your Feed yet.</p>
			@else
				@foreach ($statuses as $status)
					<div class="media">
						<a class="pull-left" href="{{ route('profile.index', ['username' => $status->user->username]) }}">
							<img class="media-object" alt="{{ $status->user->getFirstNameOrUsername() }}" src="{{ $status->user->getAvatarUrl() }}">
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
									<li><p></p></li>
								@endif
								<li>@if ($status->likes->count() - $status->unlikes->count() > 0)+@endif{{ $status->likes->count() - $status->unlikes->count() }}</li>
								@if ($status->user->party === Auth::user()->party)
									@if ($status->user->id !== Auth::user()->id)
										@if (!Auth::user()->hasUnlikedStatus($status))
											<li><a href="{{ route('status.unlike', ['statusId' => $status->id]) }}">▼</a></li>
										@else
											<li><p>ᐁ</p></li>
										@endif
									@else
										<li><p></p></li>
									@endif
								@endif
							</ul>
							<input type="hidden" name="type" value="<?= $lastReplier = $status->user ?>" >
		
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
												<li><p></p></li>
											@endif
											<li>@if ($reply->likes->count() - $reply->unlikes->count() > 0)+@endif{{ $reply->likes->count() - $reply->unlikes->count() }}</li>
											@if ($reply->user->party === Auth::user()->party)
												@if ($reply->user->id !== Auth::user()->id)
													@if (!Auth::user()->hasUnlikedStatus($reply))
														<li><a href="{{ route('status.unlike', ['statusId' => $reply->id]) }}">▼</a></li>
													@else
														<li><p>ᐁ</p></li>
													@endif
												@else
													<li><p></p></li>
												@endif
											@endif
										</ul>
									</div>
								</div>
								<input type="hidden" name="type" value="<?= $lastReplier = $reply->user ?>" >
							

							@endforeach

							@if ($lastReplier->party !== Auth::user()->party)
							<form role="form" action="{{ route('status.reply', ['statusId' => $status->id]) }}" method="post">
								<div class="form-group{{ $errors->has("reply-{$status->id}") ? ' has-error' : '' }}">
									<textarea name="reply-{{ $status->id }}" class="form-control" rows="2" placeholder="Reply to this member of the opposite party"></textarea>
									@if ($errors->has("reply-{$status->id}"))
										<span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
									@endif
								</div>
								<input type="submit" value="Reply" class="btn btn-default btn-sm">
								<input type="hidden" name="_token" value="{{ Session::token() }}">
							</form>
							@else
							<p style="color:#CCCCCC"><i>You can only respond to members of the other party.</i></p>
							@endif


							<!-- For recursive commenting: -->
							<!-- end for each -- used to be here -->
						</div>
					</div>
				@endforeach

				{!! $statuses->render() !!}

			@endif
		</div>
	</div>
@stop