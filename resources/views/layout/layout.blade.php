<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<title>Library</title>

{!! Html::style('bootstrap/dist/css/bootstrap.min.css') !!}
{!! Html::style('datatables/media/css/dataTables.bootstrap.min.css') !!}
{!! Html::style('https://cdn.datatables.net/buttons/1.2.1/css/buttons.dataTables.min.css') !!}
{!! Html::style('custom/css/custom.css') !!}

<body>
	<!-- Navigation bar to be displayed only when user is logged in -->
	@if(Auth::check())
		@include('layout._navbar')
		<input type="hidden" id="role" value="{{Auth::user()->is_admin}}">
	@endif

	<div class="container">
		@include('flash::message')
	</div>

	@yield('content')

	<div class="spacer"></div>

	@include('layout._footer')

	<!-- Script placed at the bottom for performance -->
	{!! Html::script('js/jquery-2.2.4.min.js') !!}
	{!! Html::script('bootstrap/dist/js/bootstrap.min.js') !!}
	{!! Html::script('datatables/media/js/jquery.dataTables.min.js') !!}
	{!! Html::script('datatables/media/js/dataTables.bootstrap.min.js') !!}

	{!! Html::script('https://cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js') !!}
	{!! Html::script('//cdn.datatables.net/buttons/1.2.1/js/buttons.flash.min.js') !!}
	{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js') !!}
	{!! Html::script('//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js') !!}
	{!! Html::script('//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js') !!}
	{!! Html::script('//cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js') !!}
	{!! Html::script('//cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js') !!}
	{!! Html::script('//cdn.datatables.net/buttons/1.2.1/js/buttons.colVis.min.js') !!}

	{!! Html::script('custom/js/custom.js') !!}
	<script>
		// to send ajax requests
		$(function() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
		});
	</script>
	@yield('script')
</body>
</html>
