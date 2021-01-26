@extends('layouts.main')


@section('content')

    <div class="container mb-5 text-center">

        <h1>404</h1>

        <h3>OPS! Something gone wrog :( </h3>

        <a class="btn btn-primary" href="{{ route('home') }}">Back to home</a>
    
    </div>
@endsection