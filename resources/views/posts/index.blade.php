@extends('layouts.main')

@section('content')

    <div class="container mb-5">

        <h1>BLOG</h1>

        <!-- non avendo post all'inizio uso il foreles invece che il foreach -->

        @forelse ($posts as $post)
            <article class="mb-5">
                <h2> {{ $post->tile}}</h2>
                <h6> {{ $post->created_at->format('d/m/Y')}}</h6>

                <p>{{ $post->body }}</p>
                <a href="#">Read more</a>
            </article>

        @empty
            <p> Nessun post trovato. <a href="{{ route('posts.create') }}">Clicca qui per crearne uno nuovo!</a></p>

        @endforelse




    
    </div>
@endsection