@if (Session::has('info'))
	<div class="alert alert-info" role="alert" style="background-color: #FFF8A7">
		{{ Session::get('info') }}
	</div>
@endif