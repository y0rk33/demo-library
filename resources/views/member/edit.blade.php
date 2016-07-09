@extends('layout.layout')

@section('content')
	<div class="container">

			<h1>Edit Memeber Informaiton</h1>

			{!! Form::model($user, ['method' => 'PATCH', 'action' => ['Admin\MemberController@update', $user->id]]) !!}
			{!! csrf_field() !!}

				<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
					<h4>{!! Form::label('email', 'Email') !!}</h4>
					{!! Form::email('email', old('email'), ['class' => 'form-control']) !!}

					@if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>

				<div class="form-group {{ $errors->has('doc_id') ? ' has-error' : '' }}">
					<h4>{!! Form::label('doc_id', 'Document Id') !!}</h4>
					{!! Form::text('doc_id', old('doc_id'), ['class' => 'form-control']) !!}

					@if ($errors->has('doc_id'))
						<span class="help-block">
							<strong>{{ $errors->first('doc_id') }}</strong>
						</span>
					@endif
				</div>

				<div class="form-group {{ $errors->has('date_of_birth') ? ' has-error' : '' }}">
					<h4>{!! Form::label('date_of_birth', 'Date Of Birth') !!}</h4>

					<input type="date" class="form-control" name="date_of_birth"
						   value="{{ $user->date_of_birth->toDateString() }}" placeholder="yyyy-mm-dd">

					@if ($errors->has('date_of_birth'))
						<span class="help-block">
							<strong>{{ $errors->first('date_of_birth') }}</strong>
						</span>
					@endif
				</div>

				<div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
					<h4>{!! Form::label('first_name', 'First Name') !!}</h4>
					{!! Form::text('first_name', old('first_name'), ['class' => 'form-control']) !!}

					@if ($errors->has('first_name'))
						<span class="help-block">
								<strong>{{ $errors->first('first_name') }}</strong>
							</span>
					@endif
				</div>

				<div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
					<h4>{!! Form::label('last_name', 'Last Name') !!}</h4>
					{!! Form::text('last_name', old('last_name'), ['class' => 'form-control']) !!}

					@if ($errors->has('last_name'))
						<span class="help-block">
								<strong>{{ $errors->first('last_name') }}</strong>
							</span>
					@endif
				</div>

				<div class="form-group {{ $errors->has('is_admin') ? 'has-error' : '' }}">
					{!! Form::checkbox('is_admin', '1', $user->is_admin === 1 ? true : false, ['id' => 'is_admin']) !!}
					{!! Form::label('is_admin', 'Is Admin') !!}

					@if ($errors->has('is_admin'))
						<span class="help-block">
							<strong>{{ $errors->first('is_admin') }}</strong>
						</span>
					@endif
				</div>

				<div class="btn-group btn-group-justified" role="group" aria-label="...">
					<div class="btn-group" role="group">
						{!! Form::submit('Save Changes', ['class' => 'btn btn-primary form-control']) !!}
					</div>
					<div class="btn-group" role="group">
						<a href="{{ url('member') }}" class="btn btn-default form-control"> Cancel</a>
					</div>
				</div>
			{!! Form::close() !!}

	</div>

@endsection


