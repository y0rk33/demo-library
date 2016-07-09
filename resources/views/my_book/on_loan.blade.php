@extends('layout.layout')

@section('content')
	<div class="container">
		<h1>My Books On Loan</h1>

		<div class="alert alert-info" role="alert">
			<p><strong>Dev Note : </strong></p>
			<p>Changing the date directly in db will not calculate & display the fine. A daily cron job will run at 00:00
				to calculate ALL the fines. This is assuming the library is not working 24/7.</p>
		</div>

		@if (count($borrow_transactions) <= 0)
			<div class="alert alert-warning" role="alert">
				<p>You don't have any books on loan</p>
			</div>
		@else
			<table class="table table-striped table-bordered table-responsive">
				<thead>
				<th>Request Number</th>
				<th>ISBN</th>
				<th>Book Title</th>
				<th>Status</th>
				<th>Date of Loan</th>
				<th>Date to Return</th>
				<th>Fine</th>
				</thead>

				<tbody>
				@foreach($borrow_transactions as $transaction)
					<tr>
						<td>{{ $transaction->request_number }}</td>
						<td><a href="{{ url('book/'.$transaction->book->id) }}">{{ $transaction->book->isbn }}</a></td>
						<td>
							{{ $transaction->book->title }}, {{ $transaction->book->edition }}, {{ $transaction->book->year }}
						</td>
						<td>{{ $transaction->status }}</td>
						<td>{{ $transaction->borrowed_at }}</td>
						<td>{{ $transaction->to_be_returned_at }}</td>
						<td>
							@if(!empty($transaction->fine))
								<span class="text-danger">{{ $transaction->fine->amount }}</span>
							@else
								<span class="text-success">No Fine</span>
							@endif
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@endif

	</div>
@endsection