@extends('app')

@section('title', 'Profile')

@section('main')
<div id="profile">
    <h1>Welcome, @{{ user }}</h1>
    <section>
        <h1>Comments</h1>
        <article v-for="comment in comments">
            <h1>@{{ title }}</h1>
            <p>@{{ content }}</p>
        </article>
    </section>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/vue.min.js') }}"></script>
<script>
    if (sessionStorage.getItem('elegance_id') == null)
        location.href = "{{ route('login') }}";

    async function getUser() {
        try
            return await axios.get('https://localhost:8443/users/' + 
            sessionStorage.getItem('elegance_id')).data;
        catch(error)
            location.href = "{{ route('error') }}";
    }

    const user = getUser();

    const profile = new Vue({
        el: '#profile',
        data: {
            user: sessionStorage.getItem('elegance_user'),
            comments: user.comments
        }
    });
</script>
@endsection
