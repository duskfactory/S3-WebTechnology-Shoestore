<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - Elegance</title>
    <meta charset="UTF-8" />
    <meta name="author" content="Xander Storme" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @yield('stylesheets')
</head>
<body>
<header>
    <img src="{{ asset('img/elegance.png') }}" alt="Elegance Logo" />
    <nav>
        <ul>
            <li><a href="{{ route('welcome') }}" class="active">Home</a></li>
            @auth
                <li ondrop="drop(event);" ondragover="allowDrop(event);">
                    <a href="{{ route('checkout') }}">Checkout</a>
                </li>
                <li><a href="{{ route('dashboard') }}">Profile</a></li>
                <li><a href="{{ route('logout') }}">Logout</a></li>
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            @endauth
        </ul>
    </nav>
</header>
<main>
    @yield('main')
</main>
<hr />
<footer>
    <p>&#169;2021 Elegance - Created by Xander Storme</p>
</footer>
@yield('scripts')
</body>
</html>