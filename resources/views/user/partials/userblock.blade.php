<div class="media">
	<a class="pull-left" href="{{ route('profile.index', ['username' => $user->username]) }}">
		<img class="media-object" alt="{{ $user->getNameOrUsername() }}" src="{{ $user->getAvatarUrl() }}">
	</a>
	<div class="media-body">
		<h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $user->username]) }}" style="color: {{ $user->colorizeByParty($user) }}">{{ $user->username }}</a> (<a href="{{ route('profile.index', ['username' => $user->username]) }}" style="color: {{ $user->colorizeByParty($user) }}">{{ $user->getNameOrUsername() }}</a>)</h4>
		@if ($user->party)
			<p>{{ $user->party }}</p>
		@endif
		@if ($user->location)
			<p>{{ $user->location }}</p>
		@endif
	</div>
</div>