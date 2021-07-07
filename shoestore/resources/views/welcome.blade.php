@extends('app')
@section('title', 'Home')

@section('main')
<div id="vue">
    <article v-for="article in articles">
        <img :src="`https://shoestore.local/${article.image}`" alt="@{{ article.name }}" />
        <p>@{{ article.name }}</p>
        <p>@{{ article.price }}</p>
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
        }
    };
    Vue.createApp(panel).mount('#vue');
</script>
@endsection