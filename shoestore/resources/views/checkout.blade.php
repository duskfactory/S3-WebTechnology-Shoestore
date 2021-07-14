@extends('app')
@section('title', 'Checkout')
@section('stylesheets')
<meta name="robots" content="noindex" />
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}" />
@endsection

@section('main')
<h1>Checkout</h1>
<p>Total price: €{{ $totalSum }}</p>
<p><a href="{{ route('postPurchase') }}">Make Purchase</a></p>
<section>
    @foreach ($basket as $article)
        <article>
            <img src="{{ asset($article->image) }}" alt="{{ $article->name }}" />
            <p class="title">{{ $article->name }}</p>
            <p>€{{ $article->price }}</p>
            <a href="{{ route('removeFromBasket', ['id' => $article->id]) }}">Remove</a>
        </article>
    @endforeach
</section>
@endsection