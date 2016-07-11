@extends('layout.layout')

@section('content')
	<div class="container">
		<h1>My Book Requests</h1>

		<div class="alert alert-info" role="alert">
			<p><strong>Information / Tips :</strong></p>
			<ul>
				<li>All pending requests will be canceled on the next day</li>
				<li>You may provide the request number(s) for a faster procedure at the counter</li>
				<li>Please provide your Document Id at the counter when borrowing a book</li>
			</ul>
		</div>
		<div class="alert alert-info" role="alert">
			<p><strong>Dev Note :</strong></p>
			<ul>
				<li>All pending request are cancelled at 00:00, this is assuming the library is not working 24/7</li>
			</ul>
		</div>

		@if (count($borrow_transactions) <= 0)
			<div class="alert alert-warning" role="alert">
				<p>You have not requested any books</p>
			</div>
		@else
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Request Number</th>
							<th>ISBN</th>
							<th>Book Title</th>
							<th>Shelf Location</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					@foreach($borrow_transactions as $transaction)
						<tr>
							<td>{{ $transaction->request_number }}</td>
							<td><a href="{{ url('book/'.$transaction->book->id) }}">{{ $transaction->book->isbn }}</a></td>
							<td>{{ $transaction->book->title }}, {{ $transaction->book->edition }}, {{ $transaction->book->year }}</td>
							<td>
								{{ $transaction->book->shelf_location }}
							</td>
							<td>{{ $transaction->status }}</td>
							<td>
								<a href="{{ url('book_request/cancel/'.$transaction->id) }}" class="btn btn-danger">Cancel</a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		@endif

	</div>
@endsection
