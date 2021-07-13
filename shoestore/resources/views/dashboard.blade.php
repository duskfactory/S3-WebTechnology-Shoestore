@extends('app')
@section('title', 'Dashboard')

@section('main')
<h1>Hello, {{ $user->name }}</h1>
<section id="overview">
    <div>
        <button onclick="openComments()">Comments</button>
        <button onclick="openPurchases()">Purchases</button>
    </div>
    <div id="comments">
        @foreach($user->comments as $comment)
            <article>
                <a href="{{ route('updateComment', ['id' => $comment->id]) }}">Edit</a>
                <a href="{{ route('deleteComment', ['id' => $comment->id]) }}">Delete</a>
                <h1>{{ $comment->title }}</h1>
                <p>{{ $comment->body }}</p>
                @if ($comment->image != null)
                    <img src="{{ asset($comment->image) }}" />
                @endif
            </article>
        @endforeach
    </div>
    <div id="purchases">
        @foreach($user->purchases as $item)
            <article>
                <img src="{{ asset($item->image) }}" alt="$item->name" />
                <p>{{ $item->name }}</p>
                <p>{{ $item->price }}</p>
            </article>
        @endforeach
    </div>
</section>
@endsection