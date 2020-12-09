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
    <input id="commentTitle" type="text" />
    <textarea id="commentContent" rows="5" cols="33"></textarea>
    <button id="submitComment">Submit</button>
    <article v-for="comment in comments">
        <h1>@{{ title }}</h1>
        <p>@{{ content }}</p>
    </article>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/vue.min.js') }}"></script>
<script>
    const articleId = location.href.substring(location.href.lastIndexOf('/'));
    async function getArticle() {
        try
            return await axios.get('https://webtech.local:8080/articles/' + articleId).data;
        catch(error)
            location.href = "{{ route('error') }}";
    }

    function isLoggedIn() {
        return sessionStorage.getItem('elegance_id') != null;
    }

    const article = getArticle();

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
        if (isLoggedIn()) {
            let purchase = {
                user_id: sessionStorage.getItem('elegance_id'),
                article_id: articleId
            };

            try
                axios.post('https://webtech.local:8080/users/makePurchase', 
                           JSON.stringify(purchase));
            catch(error)
                location.href = "{{ route('error') }}";
        } else
            location.href = "{{ route('login') }}";
    });

    document.getElementById('submitComment').addEventListener('click', function() {
        if (isLoggedIn()) {
            let comment = {
                user_id: sessionStorage.getItem('elegance_id'),
                article_id: articleId,
                title: document.getElementById('commentTitle').value,
                content: document.getElementById('commentContent').value
            };

            if (!comment.title || !comment.content)
                location.reload();

            try {
                axios.get('https://webtech.local:8080/comments/create', JSON.stringify(comment));
                location.reload();
            } catch(error)
                location.href = "{{ route('error') }}";
        } else
            location.href = "{{ route('login') }}";
    });
</script>
@endsection
