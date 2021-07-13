@extends('app')
@section('title', 'Home')
@section('stylesheets')
<link rel="stylesheet" href="{{ asset('css/app.css') }}" />
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}" />
@endsection

@section('main')
@foreach ($articles as $article)
    <article>
        <img src="{{ asset($article->image) }}" alt="$article->name" />
        <p>{{ $article->name }}</p>
        <p>€{{ $article->price }}</p>
        <a href="{{ route('article', ['id' => $article->id]) }}"><span></span></a>
    </article>
@endforeach
{{ $articles->links() }}
@endsection