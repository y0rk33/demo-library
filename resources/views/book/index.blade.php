@extends('layout.layout')

@section('content')

	<div class="container">
		<h2>Books</h2>

		<div class="spacer"></div>

		<div class="alert alert-info" role="alert">
			<p><strong>Tips :</strong></p>
			<ul>
				<li>You can search for a book by ISBN, Title and Author</li>
				<li>If the search returned too many results, you may use search box at the top left corner of the table to narrow down a search result</li>
			</ul>
		</div>

		@if(Auth::user()->is_admin())
			<div class="alert alert-warning" role="alert">
				<p><strong>Admin Information :</strong></p>
				<ul>
					<li>Search by isbn, title or author for a faster search result</li>
					<li>'Show All' will display all the books that are available in the library, however it will take a longer time ti load</li>
					<li>To create a report, click 'Show All', filter and export</li>
					<li>The bigger data set, the longer it will take to export</li>
				</ul>
			</div>

			{!! Form::open(['url' => '/book_search']) !!}
				<div class="input-group">
					<span class="input-group-btn">
						<a href="{{ url('book/create') }}" class="btn btn-success">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Book</a>
						<a href="{{ url('book_show_all') }}" class="btn btn-info">
							<span class="glyphicon glyphicon-list" aria-hidden="true"></span> Show All</a>
					</span>
					{!! Form::text('search_text', $search_text, ['class' => 'form-control', 'placeholder' => 'Search by request isbn, title or author ...']) !!}
					<span class="input-group-btn">
						{!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
					</span>
				</div>
			{!! Form::close() !!}

			<div class="spacer"></div>

		@endif

		@if (count($books) > 0)
			<table class="table table-striped table-bordered table-responsive" id="table-result">
				<thead>
					<th>ISBN</th>
					<th>Title</th>
					<th>Edition</th>
					<th>Year</th>
					<th>Author</th>
					<th>Available Qty</th>
					<th>Shelf Location</th>
					@if(Auth::user()->is_admin())
						<th>Total Qty</th>
					@endif
				</thead>
				<tbody>
					@foreach($books as $book)
						<tr>
							<td><a href="{{ url('book/'.$book->id) }}">{{ $book->isbn }}</a></td>
							<td>{{ $book->title }}</td>
							<td>{{ $book->edition }}</td>
							<td>{{ $book->year }}</td>
							<td>{{ $book->author }}</td>
							<td>{{ $book->current_qty }}</td>
							<td>{{ $book->shelf_location }}</td>
							@if(Auth::user()->is_admin())
								<td>{{ $book->total_qty }}</td>
							@endif
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
		});
	</script>
@endsection