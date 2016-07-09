@extends('layout.layout')

@section('content')
	<div class="container">
		<h1>Edit Book Informaiton</h1>

		{!! Form::model($book, ['method' => 'PATCH', 'action' => ['BooksController@update', $book->id]]) !!}
			<div class="form-group {{ $errors->has('isbn') ? ' has-error' : '' }}">
				{!! Form::hidden('isbn', $book->isbn) !!}
				{!! Form::label('isbn' , 'ISBN') !!}
				{!! Form::text('isbn', null, ['class' => 'form-control', 'disabled']) !!}

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
				{!! Form::hidden('total_qty', $book->total_qty) !!}
				{!! Form::label('add_qty' , 'Add Qty') !!}
				<div class="input-group">
					<span class="input-group-addon">Current Total : {{ $book->total_qty }} + </span>
					{!! Form::number('add_qty', null, ['class' => 'form-control']) !!}
				</div>

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

			<div class="btn-group btn-group-justified" role="group" aria-label="...">
				<div class="btn-group" role="group">
					{!! Form::submit('Save Changes', ['class' => 'btn btn-primary form-control']) !!}
				</div>
				<div class="btn-group" role="group">
					<a href="{{ url('book/'.$book->id) }}" class="btn btn-default form-control"> Cancel</a>
				</div>
			</div>
		{!! Form::close()  !!}
	</div>
@endsection