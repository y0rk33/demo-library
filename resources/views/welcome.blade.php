@extends('layout.layout')

@section('content')
    <div class="container text-center">

        <div class="col-md-6 col-md-offset-3 main_search">
            <h1 class="main_search_logo">Libary</h1>
            {!! Form::open(['url' => 'book_search']) !!}
                <div class="input-group">
                    {!! Form::text('search_text', old('search_text'),
                        ['class' => 'form-control', 'placeholder' => 'Search by isbn, title or author ...']) !!}
                    <span class="input-group-btn">
                        {!! Form::submit('Search', ['class' => 'btn btn-success']) !!}
                    </span>
                </div>
            {!! Form::close() !!}
        </div>

    </div>
@endsection