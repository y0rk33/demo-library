<nav id="top-nav" class="navbar navbar-default navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i> Library</a>
		</div>

		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><a href="{{ url('/') }}">Home</a></li>

				{{-- Only Available for Admin --}}
				@if(Auth::user()->is_admin())
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
						   aria-haspopup="true" aria-expanded="false">Counter Service <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="{{ url('pending_request') }}">Pending Request</a></li>
							<li><a href="{{ url('book_return') }}">Book Return / On Loan</a></li>
							<li><a href="{{ url('book') }}">Book Management</a></li>
							<li><a href="{{ url('member') }}">Member Management</a></li>
						</ul>
					</li>
				@endif

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
					   aria-haspopup="true" aria-expanded="false">My Books <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="{{ url('book_request') }}">My Book Requests</a></li>
						<li><a href="{{ url('book_on_loan') }}">My Books On Loan</a></li>
					</ul>
				</li>

			</ul>

			<ul class="nav navbar-nav navbar-right">
				{{-- display the seasrch box if not at the home page --}}
				@if(!Request::is('/'))
					{!! Form::open(['url' => 'book_search', 'class' => 'navbar-form navbar-left']) !!}
					@if (empty($search_text))
						{!! $search_text = '' !!}
					@endif

					<div class="input-group">
						{!! Form::text('search_text', $search_text,
							['class' => 'form-control', 'placeholder' => 'Search ...']) !!}
						<span class="input-group-btn">
							{!! Form::submit('Search', ['class' => 'btn btn-default']) !!}
						</span>
					</div>
					{!! Form::close() !!}
				@endif

				<li class="dropdown">
					<a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-user" aria-hidden="true"></i> {{ Auth::user()->first_name }}<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ url('my_profile/settings') }}">
								<span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Settings</a></li>
						<li><a href="{{ url('auth/logout') }}">
								<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a></li>
					</ul>
				</li>

			</ul>
		</div>
	</div>
</nav>