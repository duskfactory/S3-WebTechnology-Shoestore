@extends('app')

@section('title', 'Home')

@section('main')
<div id="vue">
    <article v-for="article in currentArticles">
        <img src="@{{ article.image }}" alt="@{{ article.title }}" />
        <p>@{{ article.title }}</p>
        <p>@{{ article.price }}</p>
    </article>
    <ul>
        <li v-for="pageNr in pagesAmount">
            <a @@click="changePage(pageNr)">@{{ pageNr }}</a>
        </li>
    </ul>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/vue.min.js') }}"></script>
<script>
    async function getArticles() {
        try {
            const response = await axios.get('https://webtech.local:8080/articles');
            console.log(response);
            return response.data;
        } catch(error) {
            console.error(error);
            return [];
        }
    }

    let vue = new Vue({
        el: '#app',
        data: {
            articles: getArticles(),
            currentPage: 1
        },
        computed: {
            pagesAmount: function() {
                return Math.ceil(this.articles.length / 20);
            },
            currentArticles: function() {
                let end = 20 * this.currentPage;
                let start = end - 20;
                return this.articles.slice(start, end);
            }
        },
        methods: {
            changePage: function(pageNr) {
                this.currentPage = pageNr;
            }
        }
    });
</script>
@endsection
