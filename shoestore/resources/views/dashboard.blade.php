@extends('app')
@section('title', 'Dashboard')

@section('main')
<div id="dashboard">
    <h1>Hello, @{{ user.name }}</h1>
    <section>
        <section>
            <article v-for="comment in user.comments">
                <h1>@{{ comment.title }}</h1>
                <p>@{{ comment.body }}</p>
                <img v-if="comment.image != null" :src="commentImage(comment.image)" />
            </article>
        </section>
        <section>
            <article v-for="item in user.purchases">
                <img :src="itemImage(item.image)" :alt="item.name" />
                <p>@{{ item.name }}</p>
                <p>@{{ item.price }}</p>
            </article>
        </section>
    </section>
</div>
@endsection