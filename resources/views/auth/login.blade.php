@extends('layout.layout')

@section('content')
	<div class="container">
		<div class="row">
			<div class="jumbotron col-md-6 col-md-offset-3">
				<div class="row text-center">
					<h1>Library</h1>
					<p>A library inspirational quote</p>
				</div>

				<div class="row">

					{!! Form::open([]) !!}
						<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
							<h4>{!! Form::label('email', 'Email') !!}</h4>
							{!! Form::email('email', old('email'), ['class' => 'form-control']) !!}

							@if ($errors->has('email'))
								<span class="help-block">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
						</div>

						<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
							<h4>{!! Form::label('password', 'Password') !!}</h4>
							{!! Form::password('password', ['class' => 'form-control']) !!}

							@if ($errors->has('password'))
								<span class='help-block'>
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
						</div>

						{!! Form::submit('Login', ['class' => 'btn btn-primary']) !!}

						{{--<span>Don't have an account? <a href="register">Sign Up</a></span>--}}

					{!! Form::close() !!}

				</div>
			</div>

		</div>
		<div class="col-md-6 col-md-offset-3">
			<div class="alert alert-info text-center">
				<p>You can Sign Up / Reset password at the counter</p>
			</div>
		</div>
	</div>
@endsection
