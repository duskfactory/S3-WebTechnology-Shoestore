@extends('app')
@section('title', 'Dashboard')
@section('stylesheets')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
@endsection

@section('main')
@isset($message)
<p class="message">{{ $message }}</p>
@endisset
<h1>Hello, {{ $user->name }}</h1>
<section id="overview">
    <div>
        <button class="tablinks" onclick="openTab(event, 'comments')" id="default">Comments</button>
        <button class="tablinks" onclick="openTab(event, 'purchases')">Purchases</button>
    </div>
    <div id="comments" class="tabcontent">
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
    <div id="purchases" class="tabcontent">
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