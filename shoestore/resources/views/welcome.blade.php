@extends('app')
@section('title', 'Home')

@section('main')
<div id="vue">
    <article v-for="article in articles">
        <img :src="image(article.image)" :alt="article.name" />
        <p>@{{ article->name }}</p>
        <p>@{{ article->price }}</p>
        <p><a :href="articleRoute(article.id)"></a></p>
    </article>
</div>
{{ $articles->links() }}
@endsection

@section('scripts')
<script>
    const panel = {
        data() {
            return {
                articles: @json($articles)
            };
        },
        methods: {
            image(url) {
                return `https://shoestore.local/articles/${url}.webp`;
            },
            articleRoute(id) {
                return `https://shoestore.local/article/${id}`;
            }
        }
    };
    Vue.createApp(panel).mount('#vue');
</script>
@endsection