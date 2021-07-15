@extends('app')
@section('title', 'Home')
@section('stylesheets')
<link rel="canonical" href="https://shoestore.local" />
<link rel="stylesheet" href="{{ asset('css/app.css') }}" />
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}" />
@endsection

@section('main')
<section>
@foreach ($articles as $article)
    <article draggable="true" ondragstart="drag(event);" id="{{ $article->id }}">
        <img src="{{ asset($article->image) }}" alt="{{ $article->name }}" />
        <p>{{ $article->name }}</p>
        <p>€{{ $article->price }}</p>
        <a href="{{ route('article', ['id' => $article->id]) }}"><span></span></a>
    </article>
@endforeach
</section>
{{ $articles->links() }}
@endsection

@section('scripts')
<script>
    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("text/plain", ev.target.id);
    }

    function drop(ev) {
        ev.preventDefault();
        window.location.href = `https://shoestore.local/addToBasket/${ev.dataTransfer.getData("text")}`;
    }
</script>
@endsection