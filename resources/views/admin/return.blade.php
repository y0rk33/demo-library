@extends('layout.layout')

@section('content')
	<div class="container">
		<h1>Book Return / On Loan</h1>

		<div class="alert alert-info" role="alert">
			<p><strong>Information :</strong></p>
			<ul>
				{{--<li>'Show All' will display all books on loan, however it will take a longer time to load</li>--}}
				<li>If the search returned too many results, you may use search box at the top left corner of the table to narrow down a search result</li>
				<li>To create a report, click 'Show All', filter and export</li>
				<li>The bigger data set, the longer it will take to export</li>
			</ul>
		</div>

		{!! Form::open(['url' => '/book_return/search']) !!}
			<div class="input-group">
				{{--<span class="input-group-btn">--}}
					{{--<a href="{{ url('book_return/show_all') }}" class="btn btn-info">--}}
						{{--<span class="glyphicon glyphicon-list" aria-hidden="true"></span> Show All</a>--}}
				{{--</span>--}}
				{!! Form::text('search_parameter', $search_text, ['class' => 'form-control', 'placeholder' => 'Search by request number, document id or isbn ...']) !!}
				<span class="input-group-btn">
					{!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
				</span>
			</div>
		{!! Form::close() !!}

		<div class="spacer"></div>

		@if (isset($borrow_transactions[0]))
			<table class="table table-striped table-bordered table-responsive" id="table-result">
				<thead>
					<th>Request Number</th>
					<th>Document Id / Name</th>
					<th>ISBN</th>
					<th>Book Title</th>
					<th>Status</th>
					<th>Date of Loan</th>
					<th>Date to Return</th>
					<th>Fine</th>
					<th>Action</th>
				</thead>

				<tbody>
				@foreach($borrow_transactions as $transaction)
					<tr>
						<td>{{ $transaction->request_number }}</td>
						<td>{{ $transaction->user->doc_id }}, {{ $transaction->user->first_name }} {{ $transaction->user->last_name }}</td>
						<td><a href="{{ url('book/'.$transaction->book->id) }}">{{ $transaction->book->isbn }}</a></td>
						<td>{{ $transaction->book->title }}</td>
						<td>{{ $transaction->status }}</td>
						<td>{{ $transaction->borrowed_at->toDateString() }}</td>
						<td>{{ $transaction->to_be_returned_at->toDateString() }}</td>
						<td>
							@if(!empty($transaction->fine))
								<span class="text-danger">${{ $transaction->fine->amount }}</span>
							@else
								<span class="text-success">No Fine</span>
							@endif
						</td>
						<td>
							<a href="{{ url('book_return/return/'.$transaction->id) }}" class="btn btn-success">Return</a>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@else
			<div class="alert alert-warning" role="alert">
				<p>There are no books on loan at the moment</p>
			</div>
		@endif

	</div>
@endsection

@section('script')
	<script>
		$(function() {
			setDataTableSettings('#table-result');
		});
	</script>
@endsection