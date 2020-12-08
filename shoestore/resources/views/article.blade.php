@extends('app')

@section('title', 'Article')

@section('main')
<section id="article">
    <img src ="@{{ image }}" />
    <h1>@{{ title }}</h1>
    <p>@{{ price }}</p>
    <button id="purchase">Purchase</button>
</section>
<section id="comments">
    <textarea rows="5" cols="33"></textarea>
    <button id="submitComment">Submit</button>
    <article v-for="comment in comments">
        <h1>@{{ title }}</h1>
        <p>@{{  }}</p>
        <p>@{{ content }}</p>
    </article>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/vue.min.js') }}"></script>
<script>
    let article;
    try
        article = 
            axios.get('https://webtech.local:8080/articles/' +
                      location.href.substring(location.href.lastIndexOf('/')))
            .data;
    catch(error)
        location.href = "{{ route('error') }}";
    
    const articleInfo = new Vue({
        el: '#article',
        data: {
            image: article.image,
            title: article.title,
            price: article.price
        }
    });

    const comments = new Vue({
        el: '#comments',
        data: {
            comments: article.comments
        }
    });

    document.getElementById('purchase').addEventListener('click', function() {
        if (sessionStorage.getItem('elegance_user') != null) {
            let purchase = {
                user_id: sessionStorage.getItem('elegance_id'),
                article_id: location.href.substring(location.href.lastIndexOf('/'))
            };

            try
                axios.post('https://webtech.local:8080/users/makePurchase', 
                           JSON.stringify(purchase));
            catch(error)
                location.href = "{{ route('error') }}";
        } else
            location.href = "{{ route('login') }}";
    });
</script>
@endsection
