@extends('app')
@section('title', 'Article')

@section('stylesheets')
<link rel="stylesheet" href="{{ asset('css/article.css') }}" />
@endsection

@section('main')
<section class="description">
    <img src="{{ asset($article->image) }}" alt="{{ $article->name }}" />
    <h1>{{ $article->name }}</h1>
    <p>€{{ $article->price }}</p>
    <a href="{{ route('addToBasket', ['id' => $article->id]) }}">Add To Basket</a>
</section>
<section class="comments">
    <form action="{{ route('postComment') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">Title: </label><br />
            <input id="title" name="title" />
        </div>
        <div>
            <label for="body">Body: </label><br />
            <textarea id="body" name="body" rows="5" cols="33"></textarea>
        </div>
        <div>
            <label for="image">Photo (optional): </label><br/>
            <input type="file" id="image" name="image" accept="image/*" />
        </div>
        <input type="hidden" name="articleId" value="{{ $article->id }}" />
        <input type="submit" value="Post Comment" />
    </form>
    <section>
    @foreach ($article->comments as $comment)
        <article>
            @if ($comment->image != null)
                <img src="{{ asset($comment->image) }}" alt="{{ $comment->title }}" />
            @endif
            @if($comment->user_id === $id)
                <p class="deleteComment"><a href="{{ route('deleteComment', ['id' => $comment->id]) }}">Delete</a></p>
            @endif
            <h1 class="title">{{ $comment->title }}</h1>
            <p>{{ $comment->body }}</p>
        </article>
    @endforeach
    </section>
</section>
@endsection