@extends('app')
@section('title', 'Dashboard')

@section('main')
<div id="dashboard">
    <h1>Hello, @{{ user.name }}</h1>
    <section id="overview">
        <div>
            <button onclick="openComments()">Comments</button>
            <button onclick="openPurchases()">Purchases</button>
        </div>
        <div id="comments">
            <article v-for="comment in user.comments">
                <h1>@{{ comment.title }}</h1>
                <p>@{{ comment.body }}</p>
                <img v-if="comment.image != null" :src="image(comment.image)" />
            </article>
        </div>
        <div id="purchases">
            <article v-for="item in user.purchases">
                <img :src="image(item.image)" :alt="item.name" />
                <p>@{{ item.name }}</p>
                <p>@{{ item.price }}</p>
            </article>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
    const overview = {
        data() {
            return {
                user: @json($user)
            };
        },
        methods: {
            image(url) {
                return `https://shoestore.local/${url}`;
            }
        }
    };
</script>
@endsection