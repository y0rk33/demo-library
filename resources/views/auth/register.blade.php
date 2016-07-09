@extends('layout.layout')

@section('content')
	<div class="container">
		<div class="row">
				<div class="row text-center">
					<h1>Library</h1>
					<p>Sign Up Form</p>
				</div>

				<div class="row">
					{!! Form::open(['url' => 'auth/register']) !!}
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
						{!! Form::date('date_of_birth', old('date_of_birth'), ['class' => 'form-control']) !!}

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

					<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
						<h4>{!! Form::label('password', 'Password') !!}</h4>
						{!! Form::password('password', ['class' => 'form-control']) !!}

						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>

					<div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
						<h4>{!! Form::label('password_confirmation', 'Password Confirmation') !!}</h4>
						{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}

						@if ($errors->has('password_confirmation'))
							<span class="help-block">
								<strong>{{ $errors->first('password_confirmation') }}</strong>
							</span>
						@endif
					</div>

					{!! Form::submit('Sign Up', ['class' => 'btn btn-primary']) !!}

					<span>Alreay have an account? <a href="login">Login</a></span>

					{!! Form::close() !!}
				</div>
		</div>
	</div>

@endsection


