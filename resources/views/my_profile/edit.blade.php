@extends('layout.layout')

@section('content')

	<div class="container">
		<h2>Edit My Settings</h2>

		<div class="alert alert-info" role="alert">
			<p><strong>Information :</strong></p>
			<ul>
				<li>Leave 'New Password' & 'New Password Confirmation' fields empty if you do no wish to update the password</li>
				<li>To save the changes please provide your current password</li>
				<li>If you wish to update you birthday, please proceed to counter with the ID for verification</li>
			</ul>
		</div>

		<div class="spacer"></div>

		{!! Form::model($user, ['action' => ['UserSettingController@update', $user->id]]) !!}

			<div class="form-group {{ $errors->has('doc_id') ? ' has-error' : '' }}">
				{!! Form::hidden('doc_id', $user->doc_id) !!}
				{!! Form::label('doc_id' , 'Document Id') !!}
				{!! Form::text('doc_id', old('doc_id'),['class' => 'form-control', 'disabled']) !!}

				@if ($errors->has('doc_id'))
					<span class="help-block">
						<strong>{{ $errors->first('doc_id') }}</strong>
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
				{!! Form::label('email' , 'Email') !!}
				{!! Form::email('email', old('email'),['class' => 'form-control']) !!}

				@if ($errors->has('email'))
					<span class="help-block">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
				{!! Form::label('first_name' , 'First Name') !!}
				{!! Form::text('first_name', old('first_name'),['class' => 'form-control']) !!}

				@if ($errors->has('first_name'))
					<span class="help-block">
						<strong>{{ $errors->first('first_name') }}</strong>
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
				{!! Form::label('last_name' , 'Last Name') !!}
				{!! Form::text('last_name', old('last_name'),['class' => 'form-control']) !!}

				@if ($errors->has('last_name'))
					<span class="help-block">
						<strong>{{ $errors->first('last_name') }}</strong>
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('new_password') ? 'has-error' : '' }}">
				{!! Form::label('new_password', 'New Password') !!}
				{!! Form::password('new_password', ['class' => 'form-control']) !!}

				@if ($errors->has('new_password'))
					<span class="help-block">
						<strong>{{ $errors->first('new_password') }}</strong>
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('new_password_confirmation') ? 'has-error' : '' }}">
				{!! Form::label('new_password_confirmation', 'New Password Confirmation') !!}
				{!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}

				@if ($errors->has('new_password_confirmation'))
					<span class="help-block">
						<strong>{{ $errors->first('new_password_confirmation') }}</strong>
					</span>
				@endif
			</div>

			<div class="form-group {{ $errors->has('current_password') ? 'has-error' : '' }}">
				{!! Form::label('current_password', 'Current Password') !!}
				{!! Form::password('current_password', ['class' => 'form-control']) !!}
			</div>

			<div class="btn-group btn-group-justified" role="group" aria-label="...">
				<div class="btn-group" role="group">
					{!! Form::submit('Save Changes', ['class' => 'btn btn-primary form-control']) !!}
				</div>
				<div class="btn-group" role="group">
					<a href="{{ url('my_profile/settings') }}" class="btn btn-default form-control"> Cancel</a>
				</div>
			</div>

		{!! Form::close()  !!}
	</div>
@endsection
