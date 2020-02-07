<nav class="navbar navbar-default" role="navigation" style="background-color:@if (!Auth::user()) #f5f5f5 @else {{ Auth::user()->colorizeBlockByParty(Auth::user()) }} @endif">
	<div class="container">
		<div class="navbar-header">
			<!-- HOW IT SHOULD BE DONE: -->
			<!-- route('home', ['mode' => 'popular']) -->
			<a class="navbar-brand" href="{{ route('home') }}">Gugump</a>
		</div>
		<div class="collapse navbar-collapse">
			@if (Auth::check())
				<ul class="nav navbar-nav">
					<li><a href="{{ route('home') }}">Feed</a></li>
					<li><a href="{{ route('friend.index') }}">Following</a></li>
				</ul>
				<form class="navbar-form navbar-left" role="search" action="{{ route('search.results') }}">
					<div class="form-group">
						<input type="text" name="query" class="form-control" placeholder="Find people">
					</div>
					<button type="submit" class="btn btn-default">Search</button>
				</form>
			@endif
			<ul class="nav navbar-nav navbar-right">
				@if (Auth::check())
					<li><a href="{{ route('profile.index', ['username' => Auth::user()->username]) }}" style="color:{{ Auth::user()->colorizeByParty(Auth::user()) }}">{{ Auth::user()->username }}</a></li>
					<!-- <li><a href="{{ route('profile.edit') }}">Settings</a></li> -->
					<li><a href="{{ route('auth.signout') }}">Sign Out</a></li>
				@else
					<li><a href="{{ route('auth.signup') }}">Sign Up</a></li>
					<li><a href="{{ route('auth.signin') }}">Sign In</a></li>
				@endif
			</ul>
		</div>
	</div>
</nav>
