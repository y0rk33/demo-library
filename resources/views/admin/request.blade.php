@extends('layout.layout')

@section('content')
	<div class="container">
		<h1>Pending Requests</h1>

		<div class="alert alert-info" role="alert">
			<p><strong>Information :</strong></p>
			<ul>
				{{--<li>'Show All' will display all pending requests, however it will take a longer time to load</li>--}}
				<li>If the search returned too many results, you may use search box at the top left corner of the table to narrow down a search result</li>
				<li>All the available data will be exported</li>
				<li>The bigger data set, the longer it will take to export</li>
			</ul>
		</div>

		{!! Form::open(['url' => '/pending_request/search']) !!}
			<div class="input-group">
				{{--<span class="input-group-btn">--}}
					{{--<a href="{{ url('pending_request/show_all') }}" class="btn btn-info">--}}
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
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table-result">
					<thead>
						<tr>
							<th>Request Number</th>
							<th>Document Id / Name</th>
							<th>ISBN</th>
							<th>Book Title</th>
							<th>Status</th>
							<th class="col-md-2">Action</th>
						</tr>
					</thead>
	
					<tbody>
					@foreach($borrow_transactions as $transaction)
						<tr>
							<td>{{ $transaction->request_number }}</td>
							<td>
								{{ $transaction->user->doc_id }}, {{ $transaction->user->first_name }} {{ $transaction->user->last_name }}
							</td>
							<td>{{ $transaction->book->isbn }}</td>
							<td>
								{{ $transaction->book->title }}, {{ $transaction->book->edition }}, {{ $transaction->book->year }}
							</td>
							<td>{{ $transaction->status }}</td>
							<td>
								<a href="{{ url('pending_request/lend/'.$transaction->id) }}" class="btn btn-success">Lend</a>
								<a href="{{ url('pending_request/cancel/'.$transaction->id) }}" class="btn btn-danger">Cancel</a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		@else
			<div class="alert alert-warning" role="alert">
				<p>There are no pending requests at the moment</p>
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
