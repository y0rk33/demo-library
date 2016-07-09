@extends('layout.layout')

@section('content')

	<div class="container">
		<h2>My Settings</h2>

		<div class="spacer"></div>

		<p><label> Email :</label> {{ Auth::user()->email }}</p>
		<p><label> Document Id :</label> {{ Auth::user()->doc_id }}</p>
		<p><label> First Name :</label> {{ Auth::user()->first_name }}</p>
		<p><label> Last Name :</label> {{ Auth::user()->last_name }}</p>
		<p><label> Date of birth :</label> {{ Auth::user()->date_of_birth->toDateString() }}</p>
		<p><label> Registration Date :</label> {{ Auth::user()->created_at }}</p>

		<a href="{{ url('my_profile/edit') }}" class="btn btn-info">
			<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit Information</a>
	</div>
@endsection
