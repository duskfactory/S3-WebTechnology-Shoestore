@extends('app')
@section('title', 'Home')
@section('stylesheets')
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}" />
@endsection

@section('main')
<div id="vue">
    <article v-for="article in articles">
        <img :src="image(article.image)" :alt="article.name" />
        <p>@{{ article.name }}</p>
        <p>@{{ article.price }}</p>
        <p><a :href="articleRoute(article.id)"></a></p>
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
        },
        methods: {
            image: function (url) {
                return `https://shoestore.local/${url}`;
            },
            articleRoute: function (id) {
                return `https://shoestore.local/article/${id}`;
            }
        }
    });
</script>
@endsection