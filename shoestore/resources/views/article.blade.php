@extends('app')
@section('title', 'Article')

@section('main')
<div id="vue">
    <section>
        <img src="{{ asset('articles/' + $article->image + '.webp') }}" />
        <h1>{{ $article->name }}</h1>
        <p>{{ $article->price }}</p>
        <a href="{{ route('addToBasket', ['id' => $article->id]) }}"></a>
    </section>
    <section>
        <form action="{{ route('postComment') }}" method="post" enctype="multipart/form-data">
            <label for="title">Title: </label>
            <input id="title" name="title" />
            <label for="body">Body: </label>
            <textarea id="body" name="body" rows="5" cols="33"></textarea>
            <label for="image">Photo (optional): </label>
            <input type="file" id="image" name="image" accept="image/*" />
            <input type="submit" value="Post Comment" />
        </form>
        <article v-for="comment in article.comments">
            <h1>@{{ comment.title }}</h1>
            <p>@{{ comment.body }}</p>
            <img v-if="comment.image != null" :src="commentImage(comment.image)" />
        </article>
    </section>
</div>
@endsection

@section('scripts')
<script>
    const articleVue = {
        data() {
            return {
                article: @json($article)
            };
        },
        methods: {
            commentImage(url) {
                return `https://shoestore.local/${url}`;
            }
        }
    };
    Vue.createApp(articleVue).mount('#vue');
</script>
@endsection