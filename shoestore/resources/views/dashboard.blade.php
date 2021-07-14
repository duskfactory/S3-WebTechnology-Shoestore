@extends('app')
@section('title', 'Dashboard')
@section('stylesheets')
<meta name="robots" content="noindex" />
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
@endsection

@section('main')
@isset($message)
<p class="message">{{ $message }}</p>
@endisset
<h1>Hello, {{ $user->name }}</h1>
<div id="purchaseChart"></div>
<section id="overview">
    <nav>
        <button class="tablinks" onclick="openTab(event, 'comments')" id="default">Comments</button>
        <button class="tablinks" onclick="openTab(event, 'purchases')">Purchases</button>
    </nav>
    <hr />
    <section id="comments" class="tabcontent">
        @foreach($user->comments as $comment)
            <article>
                @if ($comment->image != null)
                    <img src="{{ asset($comment->image) }}" alt="{{ $comment->title }}" />
                @endif
                <p class="deleteComment"><a href="{{ route('deleteComment', ['id' => $comment->id]) }}">Delete</a></p>
                <h1>{{ $comment->title }}</h1>
                <p>{{ $comment->body }}</p>
            </article>
        @endforeach
    </section>
    <section id="purchases" class="tabcontent">
        @foreach($user->purchases as $item)
            <article>
                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" />
                <h1>{{ $item->name }}</h1>
                <p>€{{ $item->price }}</p>
            </article>
        @endforeach
    </section>
</section>
@endsection

@section('scripts')
<script>
    function openTab(e, tabName) {
        let i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++)
            tabcontent[i].style.display = "none";

        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++)
            tablinks[i].className = tablinks[i].className.replace(" active", "");

        document.getElementById(tabName).style.display = "block";
        e.currentTarget.className += " active";
    }

    document.getElementById("default").click();
</script>
@endsection