<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - Elegance</title>
    <meta charset="UTF-8" />
    <meta name="author" content="Xander Storme" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    @yield('stylesheets')
</head>
<body>
<header>
    <img src="{{ asset('img/elegance.png') }}" alt="Elegance Logo" />
    <nav>
        <ul>
            <li><a href="{{ route('welcome') }}">Home</a></li>
            @auth
                <li><a href="{{ route('checkout') }}"><img src="{{ asset('img/basket.png') }}" alt="Basket" /></a></li>
                <li><a href="{{ route('dashboard') }}">Profile</a></li>
                <li><a href="{{ route('logout') }}">Logout</a></li>
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            @endauth
        </ul>
    </nav>
</header>
<hr />
<main>
    @yield('main')
</main>
<hr />
<footer>
    <p>&#169;2021 Elegance - Created by Xander Storme</p>
</footer>
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>