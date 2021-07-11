@extends('app')
@section('title', 'Article')

@section('main')
<section>
    <img src="{{ asset($article->image) }}" alt="{{ $article->name }}" />
    <h1>{{ $article->name }}</h1>
    <p>{{ $article->price }}</p>
    <a href="{{ route('addToBasket', ['id' => $article->id]) }}">Add To Basket</a>
</section>
<section>
    <form action="{{ route('postComment') }}" method="post" enctype="multipart/form-data">
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
        <input type="submit" value="Post Comment" />
    </form>
    @foreach ($article->comments as $comment)
        <article>
            @if($comment->user_id == $id)
                <a href="{{ route('updateComment', ['id' => $comment->id]) }}">Edit</a>
                <a href="{{ route('deleteComment', ['id' => $comment->id]) }}">Delete</a>
            @endif
            <h1>{{ $comment->title }}</h1>
            <p>{{ $comment->body }}</p>
            @if ($comment->image != null)
                <img src="{{ asset($comment->image) }}" alt="{{ $comment->title }}" />
            @endif
        </article>
    @endforeach
</section>
@endsection