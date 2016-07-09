@extends('layout.layout')

@section('content')
	<div class="container">
		<h1>Add New Book</h1>

		<div class="alert alert-info" role="alert">
			<p><strong>Tips :</strong></p>
			<ul>
				<li>ISBN can be with or without dashes</li>
			</ul>
		</div>

		{!! Form::open(['action' => 'BooksController@store', 'enctype' => 'multipart/form-data']) !!}

			<div class="form-group {{ $errors->has('isbn') ? ' has-error' : '' }}">
				{!! Form::label('isbn' , 'ISBN') !!}
				{!! Form::text('isbn', null, ['class' => 'form-control']) !!}

				@if ($errors->has('isbn'))
					<span class="help-block">
						<strong>{{ $errors->first('isbn') }}</strong>
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
				{!! Form::label('title' , 'Title') !!}
				{!! Form::text('title', null, ['class' => 'form-control']) !!}

				@if ($errors->has('title'))
					<span class="help-block">
						<strong>{{ $errors->first('title') }}</strong>
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('edition') ? ' has-error' : '' }}">
				{!! Form::label('edition' , 'Edition') !!}
				{!! Form::text('edition', null, ['class' => 'form-control']) !!}

				@if ($errors->has('edition'))
					<span class="help-block">
						<strong>{{ $errors->first('edition') }}</strong>
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('year') ? ' has-error' : '' }}">
				{!! Form::label('year' , 'Year') !!}
				{!! Form::date('year', null, ['class' => 'form-control']) !!}

				@if ($errors->has('year'))
					<span class="help-block">
						<strong>{{ $errors->first('year') }}</strong>
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('author') ? ' has-error' : '' }}">
				{!! Form::label('author' , 'Author') !!}
				{!! Form::text('author', null, ['class' => 'form-control']) !!}

				@if ($errors->has('author'))
					<span class="help-block">
						<strong>{{ $errors->first('author') }}</strong>
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('shelf_location') ? ' has-error' : '' }}">
				{!! Form::label('shelf_location' , 'Shelf Location') !!}
				{!! Form::text('shelf_location', null, ['class' => 'form-control']) !!}

				@if ($errors->has('shelf_location'))
					<span class="help-block">
						<strong>{{ $errors->first('shelf_location') }}</strong>
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('total_qty') ? ' has-error' : '' }}">
				{!! Form::label('total_qty' , 'Quantity') !!}
				{!! Form::number('total_qty', null, ['class' => 'form-control']) !!}

				@if ($errors->has('total_qty'))
					<span class="help-block">
						<strong>{{ $errors->first('total_qty') }}</strong>
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
				{!! Form::label('description' , 'Description') !!}
				{!! Form::textarea('description', null, ['class' => 'form-control']) !!}

				@if ($errors->has('description'))
					<span class="help-block">
						<strong>{{ $errors->first('description') }}</strong>
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('book_cover') ? ' has-error' : '' }}">
				{!! Form::label('book_cover' , 'Book Cover') !!}
				{!! Form::file('book_cover') !!}

				@if ($errors->has('book_cover'))
					<span class="help-block">
						<strong>{{ $errors->first('book_cover') }}</strong>
					</span>
				@endif
			</div>

			<div class="btn-group btn-group-justified" role="group" aria-label="...">
				<div class="btn-group" role="group">
					{!! Form::submit('Add New Book', ['class' => 'btn btn-primary form-control']) !!}
				</div>
				<div class="btn-group" role="group">
					<a href="{{ url('book') }}" class="btn btn-default form-control"> Cancel</a>
				</div>
			</div>

		{!! Form::close() !!}
	</div>
@endsection