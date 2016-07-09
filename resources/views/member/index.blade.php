@extends('layout.layout')

@section('content')

	<div class="container">
		<h2>Members</h2>

		<div class="spacer"></div>

		<div class="alert alert-warning" role="alert">
			<p><strong>Information :</strong></p>
			<ul>
				<li>When creating or  'Password Reset' a temp password will be displayed at the top of the page. Give this temp password to a new member</li>
				<li>The temp password can be changed later on by the member from the 'Settings' page.</li>
				<li>'Show All' will display all registered members</li>
				<li>To create a report, click 'Show All', filter and export</li>
				<li>The bigger data set, the longer it will take to export</li>
			</ul>
		</div>

		{!! Form::open(['url' => '/member_search']) !!}
			<div class="input-group">
				<span class="input-group-btn">
					<a href="{{ url('member/create') }}" class="btn btn-success">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Memeber</a>
					{{--<a href="{{ url('member_show_all') }}" class="btn btn-info">--}}
						{{--<span class="glyphicon glyphicon-list" aria-hidden="true"></span> Show All</a>--}}
				</span>
				{!! Form::text('search_text_doc_id', $search_text_doc_id, ['class' => 'form-control', 'placeholder' => 'Search by request isbn, title or author ...']) !!}
				<span class="input-group-btn">
					{!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
				</span>
			</div>
		{!! Form::close() !!}

		<div class="spacer"></div>

		@if (count($users) > 0)
			<table class="table table-responsive table-bordered" id="table-result">
				<thead>
					<th>Document Id</th>
					<th>Full Name</th>
					<th>Email</th>
					<th>Date Of Birth</th>
					<th>Registered Date</th>
					<th class="col-md-3">Action</th>
				</thead>
				<tbody>
					@foreach($users as $user)
						<tr>
							<td>{{ $user->doc_id }}</td>
							<td>{{ $user->first_name }}, {{ $user->last_name }}</td>
							<td>{{ $user->email }}</td>
							<td>{{ $user->date_of_birth->toDateString() }}</td>
							<td>{{ $user->created_at->toDateString() }}</td>
							<td>
								@if(Auth::user()->id !== $user->id)
								{!! Form::open(['url' => '/member_password_reset/'.$user->id]) !!}
									<button type="submit" class="btn btn-sm btn-info">
										<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Password Reset</button>
									<a href="{{ url('member/'.$user->id.'/edit') }}" class="btn btn-sm btn-warning">
										<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>
									<a href="#" class="btn btn-sm btn-danger delete" id="{{ $user->id }}">
										<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
								{!! Form::close() !!}
								@endif
							</td>ngo
						</tr>
					@endforeach
				</tbody>
			</table>
		@endif

	</div>
@endsection

@section('script')
	<script>
		$(function() {
			setDataTableSettings('#table-result');

			$('.delete').click(function(event) {
				var book_id = event.target.id;
				$.ajax({
					url: '/member/' + book_id,
					type: 'DELETE',
					success: function() {
						window.location.href = '/member';
					}
				});
			});

		});
	</script>
@endsection