@extends('layout.layout')

@section('content')
	<div class="container">
		<h1>Book Information</h1>

		<div class="spacer"></div>

		<div class="row">
			<div class="col-md-5">

				<div class="cover_frame">
					<img src="/uploads/book_covers/{{ $book->book_cover}}" class="book-cover" alt="book_cover">
				</div>

				<div class="spacer"></div>

				@if(Auth::user()->is_admin())
					{!! Form::open(['url' => 'cover_update/'.$book->id, 'enctype' => 'multipart/form-data', 'class' => 'form-inline']) !!}
						@if ($errors->has('book_cover'))
							<span class="help-block">
								<strong class="text-danger">{{ $errors->first('book_cover') }}</strong>
							</span>
						@endif
						<div class="form-group">
							{!! Form::file('book_cover') !!}
						</div>

						{!! Form::submit('Update Cover', ['class' => 'btn btn-sm btn-primary']) !!}
					{!! Form::close() !!}
				@endif

			</div>

			<div class="col-md-7">
				<h2 class="book_title">{{ $book->title }}</h2>

				<p><label>ISBN :</label> {{ $book->isbn }}</p>
				<p><label>Edition :</label> {{ $book->edition }}</p>
				<p><label>Year :</label> {{ $book->year }}</p>
				<p><label>Author :</label> {{ $book->author }}</p>
				<p><label>Shelf :</label> {{ $book->shelf_location }}</p>
				<p><label>Available Qty :</label> {{ $book->current_qty }}</p>
				<label>Description</label>
				<p style="word-wrap: break-word;">{{ $book->description }}</p>

				{!! Form::open(['url' => 'book_request/'.$book->id, 'class' => 'form-inline']) !!}
					{!! Form::submit('Request a Book', ['class' => 'btn btn-primary']) !!}
				{!! Form::close() !!}

				@if(Auth::user()->is_admin())
					<hr/>
					<p>
						<a href="{{ url('book/'.$book->id.'/edit') }}" class="btn btn-warning">
							<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit Information</a>
						<a href="" class="btn btn-danger delete" id="{{$book->id}}">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a>
					</p>
					<p><label>Total Qty :</label> {{ $book->total_qty }}</p>
					<p><label>Created at :</label> {{ $book->created_at }}</p>
					<p><label>Updated at :</label> {{ $book->updated_at }}</p>
				@endif
			</div>
		</div>

		<div class="row">

		</div>

	</div>
@endsection

@section('script')
	<script>
		$(function() {
			$('.delete').click(function(event) {
				var book_id = event.target.id;
				$.ajax({
					url: '/book/' + book_id,
					type: 'DELETE',
					success: function(response) {
						if (response == 'success') {
							window.location.href = '/book';
						} else {
							location.reload();
						}
					}
				});
			});

		});
	</script>
@endsection