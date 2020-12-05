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
</header>
<nav>
    <ul>
        <li>
            <a href="{{ route('home') }}">Home</a>
        </li>
        <li>
            <a href="{{ route('profile') }}">Profile</a>
        </li>
    </ul>
</nav>
<main>
    @yield('main')
</main>
<footer>
    <p>&#169;2020 Elegance - Created by Xander Storme</p>
</footer>
@yield('scripts')
</body>
</html>
