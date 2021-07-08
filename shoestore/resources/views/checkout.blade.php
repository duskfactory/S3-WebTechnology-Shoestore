@extends('app')
@section('title', 'Checkout')

@section('main')
<div id="basket">
    <h1>Checkout</h1>
    <p>Total price: €@{{ priceSum }}</p>
    <p><a href="{{ route('postPurchase') }}">Make Purchase</a></p>
    <div>
        <article v-for="item in basket">
            <img :src="image(item.image)" :alt="item.name" />
            <p>@{{ item.name }}</p>
            <p>@{{ item.price }}</p>
        </article>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const basket = {
        data() {
            return {
                basket: @json($basket)
            };
        },
        methods: {
            image(url) {
                return `https://shoestore.local/${url}`;
            }
        },
        computed: {
            priceSum() {
                let sum = 0;
                this.basket.foreach(item => sum += item.price);
                return sum;
            }
        }
    };
    Vue.createApp(basket).mount('#basket');
</script>
@endsection