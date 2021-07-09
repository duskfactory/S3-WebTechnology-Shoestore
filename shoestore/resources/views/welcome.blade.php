@extends('app')
@section('title', 'Home')
@section('stylesheets')
<link rel="stylesheet" href="{{ asset('css/app.css') }}" />
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}" />
@endsection

@section('main')
<div id="vue">
    <article v-for="article in articles">
        <img src="{{ asset('') }}@{{ article.image }}" :alt="article.name" />
        <p>@{{ article.name }}</p>
        <p>@{{ article.price }}</p>
        <p><a href="{{ route('article', '') }}@{{ article.id }}"></a></p>
    </article>
</div>
{{ $articles->links() }}
@endsection

@section('scripts')
<script>
    const panel = new Vue({
        el: '#vue',
        data: {
            articles: @json($articles).data
        }
    });
</script>
@endsection